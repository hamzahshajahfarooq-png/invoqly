$ErrorActionPreference = 'Stop'
$desktopRoot = Split-Path -Parent $PSScriptRoot
$workspaceRoot = Split-Path -Parent $desktopRoot
$qaRoot = [IO.Path]::GetFullPath((Join-Path $workspaceRoot '.vendor\desktop-install-qa'))
$workspacePrefix = [IO.Path]::GetFullPath((Join-Path $workspaceRoot '.vendor')) + [IO.Path]::DirectorySeparatorChar
if (-not $qaRoot.StartsWith($workspacePrefix,[StringComparison]::OrdinalIgnoreCase)) { throw 'Unexpected QA installation path' }
$exe = Join-Path $qaRoot 'Invoqly.exe'
if (-not (Test-Path -LiteralPath $exe)) {
  $qaRoot = [IO.Path]::GetFullPath((Join-Path ([Environment]::GetFolderPath('LocalApplicationData')) 'Programs\Invoqly'))
  $exe = Join-Path $qaRoot 'Invoqly.exe'
  if ((Test-Path -LiteralPath $qaRoot) -and -not (Test-Path -LiteralPath $exe)) { throw 'Preserved an existing unrecognized installation directory' }
}
if ((Test-Path -LiteralPath $exe) -and (Get-Item -LiteralPath $exe).VersionInfo.ProductName -ne 'Invoqly') { throw 'Unexpected installed product' }
# Only close the recognized Invoqly installation. Preserve unsaved work.
$running = Get-Process Invoqly -ErrorAction SilentlyContinue | Where-Object { $_.Path -eq $exe -and $_.MainWindowHandle -ne 0 }
foreach ($process in $running) {
  $null = $process.CloseMainWindow()
  if (-not $process.WaitForExit(20000)) { throw 'App is still open; preserved unsaved work and skipped upgrade' }
}
$setup = Join-Path $desktopRoot 'dist\Invoqly-Setup.exe'
$profileRoots = @((Join-Path $env:APPDATA 'Invoqly'),(Join-Path $env:APPDATA 'invoqly-desktop')) | Where-Object { Test-Path -LiteralPath $_ }
$profileChecks = @()
foreach ($profileRoot in $profileRoots) {
  $marker = Join-Path $profileRoot ('upgrade-preservation-' + [guid]::NewGuid().ToString() + '.txt')
  [IO.File]::WriteAllText($marker,'Invoqly installer preservation check')
  $profileChecks += [pscustomobject]@{ Marker=$marker; Hash=(Get-FileHash -LiteralPath $marker -Algorithm SHA256).Hash; Session=(Join-Path $profileRoot 'session.dpapi'); HadSession=(Test-Path -LiteralPath (Join-Path $profileRoot 'session.dpapi')) }
}
$installer = Start-Process -FilePath $setup -ArgumentList "/S /D=$qaRoot" -WindowStyle Hidden -Wait -PassThru
if ($installer.ExitCode -ne 0) { throw "Installer failed: $($installer.ExitCode)" }
$profilePreserved = $true
foreach ($check in $profileChecks) {
  if (-not (Test-Path -LiteralPath $check.Marker)) { $profilePreserved=$false }
  elseif ((Get-FileHash -LiteralPath $check.Marker -Algorithm SHA256).Hash -ne $check.Hash) { $profilePreserved=$false }
  if ($check.HadSession -and -not (Test-Path -LiteralPath $check.Session)) { $profilePreserved=$false }
  if (Test-Path -LiteralPath $check.Marker) { Remove-Item -LiteralPath $check.Marker }
}
if (-not $profilePreserved) { throw 'Installer profile preservation check failed' }
$process = Start-Process -FilePath $exe -PassThru
for ($attempt=0; $attempt -lt 45; $attempt++) {
  Start-Sleep -Seconds 1
  $process.Refresh()
  if ($process.HasExited -or $process.MainWindowHandle -ne 0) { break }
}
$protocol = (Get-Item 'HKCU:\Software\Classes\invoqly\shell\open\command').GetValue('')
$report = [ordered]@{
  installerExitCode=$installer.ExitCode
  productVersion=(Get-Item -LiteralPath $exe).VersionInfo.ProductVersion
  windowCreated=(-not $process.HasExited -and $process.MainWindowHandle -ne 0)
  windowTitle=$process.MainWindowTitle
  desktopShortcut=(Test-Path -LiteralPath (Join-Path ([Environment]::GetFolderPath('Desktop')) 'Invoqly.lnk'))
  startMenuShortcut=(Test-Path -LiteralPath (Join-Path ([Environment]::GetFolderPath('Programs')) 'Invoqly.lnk'))
  protocolPointsToInstalledApp=$protocol.Contains($exe)
  profilePreserved=$profilePreserved
  profileDirectoriesChecked=$profileChecks.Count
}
$report | ConvertTo-Json | Set-Content -LiteralPath (Join-Path $desktopRoot 'test-output\upgrade.json') -Encoding utf8
$report | ConvertTo-Json
if (-not $report.windowCreated -or -not $report.protocolPointsToInstalledApp -or -not $report.desktopShortcut -or -not $report.startMenuShortcut) { throw 'Upgrade acceptance check failed' }
