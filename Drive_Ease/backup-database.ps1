# Database Backup Script
$timestamp = Get-Date -Format "yyyyMMdd_HHmmss"
$backupDir = "database_backups"
$backupFile = "$backupDir\drive_ease_backup_$timestamp.sql"

# Create backup directory if it doesn't exist
if (-not (Test-Path $backupDir)) {
    New-Item -ItemType Directory -Path $backupDir
    Write-Host "Created backup directory: $backupDir"
}

# Add MySQL to PATH if not already there
$env:Path += ";C:\Program Files\MySQL\MySQL Server 8.0\bin"

# Create backup
Write-Host "Creating database backup..."
try {
    mysqldump -u root --databases drive_ease > $backupFile
    Write-Host "Backup created successfully: $backupFile"
} catch {
    Write-Host "Error creating backup: $_" -ForegroundColor Red
    exit 1
}

# Verify backup file exists and has content
if (Test-Path $backupFile) {
    $fileSize = (Get-Item $backupFile).Length
    if ($fileSize -gt 0) {
        Write-Host "Backup verification successful. File size: $($fileSize) bytes" -ForegroundColor Green
    } else {
        Write-Host "Warning: Backup file is empty!" -ForegroundColor Yellow
    }
} else {
    Write-Host "Error: Backup file was not created!" -ForegroundColor Red
    exit 1
} 