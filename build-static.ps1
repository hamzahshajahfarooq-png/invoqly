$ErrorActionPreference = 'Stop'

$projectRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
$publicDir = Join-Path $projectRoot 'public'
$assetDir = Join-Path $publicDir 'assets'

New-Item -ItemType Directory -Path $assetDir -Force | Out-Null

function Render-PhpPage {
    param(
        [Parameter(Mandatory = $true)][string]$Source,
        [Parameter(Mandatory = $true)][string]$Destination
    )

    $rendered = & php (Join-Path $projectRoot $Source) | Out-String
    if ($LASTEXITCODE -ne 0) {
        throw "Failed to render $Source"
    }

    $rendered = $rendered.Replace('index.php?lang=en', 'index.html')
    $rendered = $rendered.Replace('index.php?lang=ar', 'index.html')
    $rendered = $rendered.Replace('index.php#', 'index.html#')
    $rendered = $rendered.Replace('login.php?lang=en', 'login.html')
    $rendered = $rendered.Replace('login.php?lang=ar', 'login.html')
    $rendered = $rendered.Replace('signup.php?lang=en', 'signup.html')
    $rendered = $rendered.Replace('signup.php?lang=ar', 'signup.html')

    [IO.File]::WriteAllText(
        (Join-Path $publicDir $Destination),
        $rendered,
        [Text.UTF8Encoding]::new($false)
    )
}

Render-PhpPage -Source 'index.php' -Destination 'index.html'
Render-PhpPage -Source 'login.php' -Destination 'login.html'
Render-PhpPage -Source 'signup.php' -Destination 'signup.html'

Copy-Item -Path (Join-Path $projectRoot 'assets\*') -Destination $assetDir -Force

Write-Output 'Static Cloudflare build created in public/'
