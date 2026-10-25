$ErrorActionPreference = 'Stop'
$desktopRoot = Split-Path -Parent $PSScriptRoot
$workspaceRoot = Split-Path -Parent $desktopRoot
$setup = Join-Path $desktopRoot 'dist\Invoqly-Setup.exe'
$installRoot = [IO.Path]::GetFullPath((Join-Path $workspaceRoot '.vendor\desktop-install-qa'))
$expectedRoot = [IO.Path]::GetFullPath((Join-Path $workspaceRoot '.vendor')) + [IO.Path]::DirectorySeparatorChar
if (-not $installRoot.StartsWith($expectedRoot, [StringComparison]::OrdinalIgnoreCase)) { throw 'Installer test path is outside workspace' }
$profile = Join-Path ([Environment]::GetFolderPath('ApplicationData')) 'Invoqly'
$desktopLink = Join-Path ([Environment]::GetFolderPath('Desktop')) 'Invoqly.lnk'
$startLink = Join-Path ([Environment]::GetFolderPath('Programs')) 'Invoqly.lnk'
$existing = Get-ItemProperty 'HKCU:\Software\Microsoft\Windows\CurrentVersion\Uninstall\*' -ErrorAction SilentlyContinue | Where-Object { $_.DisplayName -eq 'Invoqly' }
if ($existing -or (Test-Path -LiteralPath $profile) -or (Test-Path -LiteralPath $desktopLink) -or (Test-Path -LiteralPath $startLink) -or (Test-Path 'HKCU:\Software\Classes\invoqly') -or (Test-Path -LiteralPath $installRoot)) {
  Write-Output 'SKIP installer execution: existing Invoqly installation/profile/shortcut/protocol or QA directory detected; preserved existing state.'
  exit 0
}
$installed = Start-Process -FilePath $setup -ArgumentList "/S /D=$installRoot" -WindowStyle Hidden -Wait -PassThru
if ($installed.ExitCode -ne 0) { throw "Installer failed: $($installed.ExitCode)" }
$exe = Join-Path $installRoot 'Invoqly.exe'
if (-not (Test-Path -LiteralPath $exe)) { throw 'Installed executable missing' }

$result = [ordered]@{ installerExitCode=$installed.ExitCode; installedExe=$exe; desktopShortcut=(Test-Path -LiteralPath $desktopLink); startMenuShortcut=(Test-Path -LiteralPath $startLink); productName=(Get-Item -LiteralPath $exe).VersionInfo.ProductName }
$process = Start-Process -FilePath $exe -PassThru
for ($attempt=0; $attempt -lt 15; $attempt++) { Start-Sleep -Seconds 1; $process.Refresh(); if ($process.HasExited -or $process.MainWindowHandle -ne 0) { break } }
$result.windowCreated = (-not $process.HasExited -and $process.MainWindowHandle -ne 0)
$result.windowTitle = $process.MainWindowTitle
$protocol = (Get-Item 'HKCU:\Software\Classes\invoqly\shell\open\command').GetValue('')
$result.protocolPointsToInstalledApp = $protocol.Contains($exe)
if (-not $process.HasExited) { $null=$process.CloseMainWindow(); if (-not $process.WaitForExit(10000)) { Stop-Process -Id $process.Id } }
$uninstaller = Join-Path $installRoot 'Uninstall Invoqly.exe'
if (Test-Path -LiteralPath $uninstaller) { $removed=Start-Process -FilePath $uninstaller -ArgumentList '/S' -WindowStyle Hidden -Wait -PassThru; $result.uninstallExitCode=$removed.ExitCode }
$report = Join-Path $desktopRoot 'test-output\installer.json'
$result | ConvertTo-Json | Set-Content -LiteralPath $report -Encoding utf8
$result | ConvertTo-Json
if (-not $result.desktopShortcut -or -not $result.startMenuShortcut -or -not $result.protocolPointsToInstalledApp -or -not $result.windowCreated) { throw 'Installer acceptance check failed; see test-output/installer.json' }
