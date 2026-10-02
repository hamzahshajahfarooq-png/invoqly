Add-Type -AssemblyName System.Drawing

$size = 512
$bitmap = [System.Drawing.Bitmap]::new($size, $size, [System.Drawing.Imaging.PixelFormat]::Format32bppArgb)
$graphics = [System.Drawing.Graphics]::FromImage($bitmap)
$graphics.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::AntiAlias
$graphics.CompositingQuality = [System.Drawing.Drawing2D.CompositingQuality]::HighQuality
$graphics.InterpolationMode = [System.Drawing.Drawing2D.InterpolationMode]::HighQualityBicubic
$graphics.Clear([System.Drawing.ColorTranslator]::FromHtml('#F7F8F0'))

$dark = [System.Drawing.SolidBrush]::new([System.Drawing.ColorTranslator]::FromHtml('#111713'))
$green = [System.Drawing.SolidBrush]::new([System.Drawing.ColorTranslator]::FromHtml('#A6F46B'))
$background = [System.Drawing.SolidBrush]::new([System.Drawing.ColorTranslator]::FromHtml('#F7F8F0'))

# Draw the established iQ mark at a generous, centered size for Google OAuth branding.
$scale = 4.1
$offsetX = 10
$offsetY = 58
function X([double]$value) { return [single]($offsetX + ($value * $scale)) }
function Y([double]$value) { return [single]($offsetY + ($value * $scale)) }
function S([double]$value) { return [single]($value * $scale) }

$graphics.FillRectangle($dark, (X 8), (Y 25), (S 20), (S 63))
$graphics.FillRectangle($dark, (X 8), (Y 4), (S 20), (S 15))
$graphics.FillEllipse($dark, (X 30), (Y 5), (S 84), (S 84))
$graphics.FillEllipse($background, (X 49), (Y 24), (S 46), (S 46))

$points = [System.Drawing.PointF[]]@(
    [System.Drawing.PointF]::new((X 66), (Y 54)),
    [System.Drawing.PointF]::new((X 88), (Y 54)),
    [System.Drawing.PointF]::new((X 113), (Y 84)),
    [System.Drawing.PointF]::new((X 91), (Y 84))
)
$graphics.FillPolygon($green, $points)

$outputPath = Join-Path $PSScriptRoot '..\assets\invoqly-google-logo.png'
$bitmap.Save($outputPath, [System.Drawing.Imaging.ImageFormat]::Png)

$dark.Dispose()
$green.Dispose()
$background.Dispose()
$graphics.Dispose()
$bitmap.Dispose()

Write-Output (Resolve-Path $outputPath)
