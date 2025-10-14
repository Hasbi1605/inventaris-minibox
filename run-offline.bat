@echo off
REM Minimal wrapper: call the manual PowerShell helper to instruct user.
SET SCRIPT_DIR=%~dp0
IF "%SCRIPT_DIR:~-1%"=="\" SET SCRIPT_DIR=%SCRIPT_DIR:~0,-1%

powershell -NoProfile -ExecutionPolicy Bypass -File "%SCRIPT_DIR%\run-offline.ps1"
