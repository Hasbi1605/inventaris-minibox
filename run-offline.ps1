#!/usr/bin/env pwsh
# Minimal manual helper - performs only basic checks and prints manual steps.
$ErrorActionPreference = 'Stop'

Write-Host "Inventaris - Manual helper (Windows)" -ForegroundColor Cyan

$scriptDir = Split-Path -Parent $MyInvocation.MyCommand.Definition
Set-Location $scriptDir

Write-Host "Working directory: $scriptDir"

Write-Host "Checking for PHP..." -NoNewline
$phpCmd = Get-Command php -ErrorAction SilentlyContinue
if ($phpCmd) {
    Write-Host " found in PATH: $($phpCmd.Source)"
} elseif (Test-Path (Join-Path $scriptDir 'portable-php\php.exe')) {
    Write-Host " found bundled at portable-php\php.exe"
} else {
    Write-Host " NOT FOUND" -ForegroundColor Yellow
}

Write-Host "\nThis script will NOT perform any automatic fixes. Follow the manual steps in WINDOWS_OFFLINE_README.txt to prepare and run the app."
Write-Host "When you're ready, run the commands from the README manually (open a Command Prompt in this folder)."

Pause
