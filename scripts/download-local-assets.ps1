$ErrorActionPreference = "Stop"

$ProjectRoot = Resolve-Path (Join-Path $PSScriptRoot "..")
$ManifestPath = Join-Path $PSScriptRoot "local-assets.json"

if (!(Test-Path $ManifestPath)) {
    throw "Manifest asset tidak ditemukan: $ManifestPath"
}

$Assets = Get-Content $ManifestPath -Raw | ConvertFrom-Json
$Total = $Assets.Count
$Index = 0
$Failed = @()

Write-Host "Mengunduh $Total asset ke folder public/assets..." -ForegroundColor Cyan

foreach ($Asset in $Assets) {
    $Index++
    $Url = [string] $Asset.url
    $Destination = Join-Path $ProjectRoot ([string] $Asset.dest)
    $DestinationDir = Split-Path $Destination -Parent

    if (!(Test-Path $DestinationDir)) {
        New-Item -ItemType Directory -Force -Path $DestinationDir | Out-Null
    }

    try {
        Write-Host "[$Index/$Total] $Url" -ForegroundColor DarkGray
        Invoke-WebRequest -Uri $Url -OutFile $Destination -UseBasicParsing
    } catch {
        $Failed += [PSCustomObject]@{
            Url = $Url
            Destination = $Destination
            Error = $_.Exception.Message
        }
        Write-Warning "Gagal: $Url"
    }
}

if ($Failed.Count -gt 0) {
    Write-Host "`nBeberapa asset gagal diunduh:" -ForegroundColor Yellow
    $Failed | Format-Table -AutoSize
    exit 1
}

Write-Host "`nSelesai. Semua asset berhasil disimpan di public/assets." -ForegroundColor Green
