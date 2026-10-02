$ErrorActionPreference = 'Stop'

$projectRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
$publicDir = Join-Path $projectRoot 'public'
$assetDir = Join-Path $publicDir 'assets'

New-Item -ItemType Directory -Path $assetDir -Force | Out-Null

function Render-PhpPage {
    param(
        [Parameter(Mandatory = $true)][string]$Source,
        [Parameter(Mandatory = $true)][string]$Destination,
        [string]$Language = 'en'
    )

    $env:INVOQLY_LANG = $Language
    $rendered = & php (Join-Path $projectRoot $Source) | Out-String
    if ($LASTEXITCODE -ne 0) {
        throw "Failed to render $Source"
    }

    $rendered = $rendered.Replace('index.php?lang=en', 'index.html')
    $rendered = $rendered.Replace('index.php?lang=ar', 'index.html')
    $rendered = $rendered.Replace('index.php#', 'index.html#')
    $rendered = $rendered.Replace('login.php?lang=en', 'login.html')
    $rendered = $rendered.Replace('signup.php?lang=en', 'signup.html')
    $rendered = $rendered.Replace('login.php?lang=ar', 'login-ar.html')
    $rendered = $rendered.Replace('signup.php?lang=ar', 'signup-ar.html')
    $rendered = $rendered.Replace('terms.php?lang=en', 'terms.html')
    $rendered = $rendered.Replace('terms.php?lang=ar', 'terms-ar.html')
    $rendered = $rendered.Replace('privacy.php?lang=en', 'privacy.html')
    $rendered = $rendered.Replace('privacy.php?lang=ar', 'privacy-ar.html')
    $rendered = $rendered.Replace('dashboard.php?lang=en', 'dashboard.html')
    $rendered = $rendered.Replace('dashboard.php?lang=ar', 'dashboard-ar.html')

    [IO.File]::WriteAllText(
        (Join-Path $publicDir $Destination),
        $rendered,
        [Text.UTF8Encoding]::new($false)
    )
}

Render-PhpPage -Source 'index.php' -Destination 'index.html'
Render-PhpPage -Source 'login.php' -Destination 'login.html'
Render-PhpPage -Source 'signup.php' -Destination 'signup.html'
Render-PhpPage -Source 'login.php' -Destination 'login-ar.html' -Language 'ar'
Render-PhpPage -Source 'signup.php' -Destination 'signup-ar.html' -Language 'ar'
Render-PhpPage -Source 'terms.php' -Destination 'terms.html'
Render-PhpPage -Source 'terms.php' -Destination 'terms-ar.html' -Language 'ar'
Render-PhpPage -Source 'privacy.php' -Destination 'privacy.html'
Render-PhpPage -Source 'privacy.php' -Destination 'privacy-ar.html' -Language 'ar'
Render-PhpPage -Source 'dashboard.php' -Destination 'dashboard.html'
Render-PhpPage -Source 'dashboard.php' -Destination 'dashboard-ar.html' -Language 'ar'

Remove-Item Env:INVOQLY_LANG -ErrorAction SilentlyContinue

Copy-Item -Path (Join-Path $projectRoot 'assets\*') -Destination $assetDir -Force

Write-Output 'Static Cloudflare build created in public/'
