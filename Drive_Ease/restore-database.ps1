# Database Restore Script
param(
    [Parameter(Mandatory=$true)]
    [string]$BackupFile
)

# Add MySQL to PATH if not already there
$env:Path += ";C:\Program Files\MySQL\MySQL Server 8.0\bin"

# Verify backup file exists
if (-not (Test-Path $BackupFile)) {
    Write-Host "Error: Backup file not found: $BackupFile" -ForegroundColor Red
    exit 1
}

# Verify backup file has content
$fileSize = (Get-Item $BackupFile).Length
if ($fileSize -eq 0) {
    Write-Host "Error: Backup file is empty!" -ForegroundColor Red
    exit 1
}

Write-Host "Starting database restore from: $BackupFile"

try {
    # Drop and recreate the database
    Write-Host "Dropping and recreating database..."
    mysql -u root -e "DROP DATABASE IF EXISTS drive_ease; CREATE DATABASE drive_ease;"
    
    # Restore from backup using Get-Content to handle the file properly
    Write-Host "Restoring database..."
    Get-Content $BackupFile | mysql -u root drive_ease
    
    Write-Host "Database restore completed successfully!" -ForegroundColor Green
} catch {
    Write-Host "Error during restore: $_" -ForegroundColor Red
    exit 1
} 