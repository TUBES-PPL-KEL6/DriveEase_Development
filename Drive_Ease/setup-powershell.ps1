# Setup PowerShell Execution Policy
Write-Host "Setting up PowerShell execution policy..."

# Check if running as administrator
$isAdmin = ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)

if (-not $isAdmin) {
    Write-Host "Please run this script as Administrator" -ForegroundColor Red
    Write-Host "Right-click on PowerShell and select 'Run as Administrator'"
    exit 1
}

# Set execution policy for current user
try {
    Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser -Force
    Write-Host "Execution policy set successfully!" -ForegroundColor Green
} catch {
    Write-Host "Error setting execution policy: $_" -ForegroundColor Red
    exit 1
}

Write-Host "`nYou can now run the database scripts.`n" -ForegroundColor Green
Write-Host "To run the scripts:"
Write-Host "1. .\backup-database.ps1"
Write-Host "2. .\restore-database.ps1 -BackupFile 'path_to_backup'"
Write-Host "3. .\setup-test-env.ps1" 