param(
    [string]$PhpExePath,
    [string]$PortablePhpDir
)

$ErrorActionPreference = 'Continue'

Write-Host "ensure-pdo-sqlite: checking PHP at $PhpExePath" -ForegroundColor Cyan

if (-not (Test-Path $PhpExePath)) {
    Write-Host "PHP executable not found: $PhpExePath" -ForegroundColor Yellow
    exit 2
}

# Function to run php code and return output
function Run-Php($code) {
    & $PhpExePath -r $code 2>$null
}

$check = Run-Php("echo extension_loaded('pdo_sqlite') ? 'OK' : 'MISSING';")
if ($check -eq 'OK') {
    Write-Host "pdo_sqlite already enabled." -ForegroundColor Green
    exit 0
}

if (-not $PortablePhpDir) {
    Write-Host "No portable PHP directory provided; cannot auto-enable extensions." -ForegroundColor Yellow
    exit 3
}

if (-not (Test-Path $PortablePhpDir)) {
    Write-Host "Portable PHP dir not found: $PortablePhpDir" -ForegroundColor Yellow
    exit 4
}

$phpIniProd = Join-Path $PortablePhpDir 'php.ini-production'
$phpIni = Join-Path $PortablePhpDir 'php.ini'

if (-not (Test-Path $phpIni) -and (Test-Path $phpIniProd)) {
    Copy-Item $phpIniProd $phpIni -Force
    Write-Host "Copied php.ini-production -> php.ini" -ForegroundColor Green
}

if (-not (Test-Path $phpIni)) {
    Write-Host "No php.ini found to edit; please create one in $PortablePhpDir" -ForegroundColor Yellow
    exit 5
}

$content = Get-Content $phpIni -Raw

# Ensure extension_dir points to ext folder
if ($content -notmatch 'extension_dir\s*=') {
    $content = "extension_dir = \"ext\"`n" + $content
} else {
    $content = $content -replace 'extension_dir\s*=\s*"?[^"]+"?', 'extension_dir = "ext"'
}

# Try to uncomment common sqlite/pdo lines (several possible variants)
$patterns = @(
    ';extension=pdo_sqlite',
    ';extension=php_pdo_sqlite.dll',
    ';extension=sqlite3',
    ';extension=php_sqlite3.dll',
    ';extension=sqlite3.dll'
)

foreach ($p in $patterns) {
    if ($content -match [regex]::Escape($p)) {
        $content = $content -replace [regex]::Escape($p), $p.TrimStart(';')
        Write-Host "Uncommented $p" -ForegroundColor Green
    }
}

# Some distributions use extension names without php_ prefix; try to ensure both
$content = $content -replace ';\s*extension\s*=\s*pdo_sqlite', 'extension=pdo_sqlite'
$content = $content -replace ';\s*extension\s*=\s*sqlite3', 'extension=sqlite3'

# Save back
Set-Content -Path $phpIni -Value $content -Encoding UTF8
Write-Host "Modified php.ini to enable sqlite/pdo extension lines (best-effort)." -ForegroundColor Cyan

# Re-check
$check2 = Run-Php("echo extension_loaded('pdo_sqlite') ? 'OK' : 'MISSING';")
if ($check2 -eq 'OK') {
    Write-Host "pdo_sqlite enabled successfully." -ForegroundColor Green
    exit 0
} else {
    Write-Host "pdo_sqlite still missing after edits. You may need to enable extension=php_pdo_sqlite.dll or adjust extension_dir." -ForegroundColor Yellow
    exit 6
}
