$ErrorActionPreference = "Stop"
$ProjectRoot = Resolve-Path (Join-Path $PSScriptRoot "..")
$ManifestPath = Join-Path $PSScriptRoot "local-assets.json"
$Assets = Get-Content $ManifestPath -Raw | ConvertFrom-Json
$Missing = @()
foreach ($Asset in $Assets) {
    $Destination = Join-Path $ProjectRoot ([string] $Asset.dest)
    if (!(Test-Path $Destination)) {
        $Missing += [PSCustomObject]@{ Path = $Destination; Source = $Asset.url }
    }
}
if ($Missing.Count -gt 0) {
    Write-Host "Asset yang belum ada:" -ForegroundColor Yellow
    $Missing | Format-Table -AutoSize
    exit 1
}
Write-Host "Semua file asset lokal ditemukan." -ForegroundColor Green
