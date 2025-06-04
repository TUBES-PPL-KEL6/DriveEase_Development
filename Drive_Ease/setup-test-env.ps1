# Test Environment Setup Script
$logFile = "test-setup.log"
$startTime = Get-Date

function Write-Log {
    param($Message)
    $timestamp = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
    $logMessage = "[$timestamp] $Message"
    Add-Content -Path $logFile -Value $logMessage
    Write-Host $logMessage
}

# Start logging
Write-Log "Starting test environment setup"

# Check if MySQL is installed and accessible
try {
    $env:Path += ";C:\Program Files\MySQL\MySQL Server 8.0\bin"
    $mysqlVersion = mysql --version
    Write-Log "MySQL detected: $mysqlVersion"
} catch {
    Write-Log "ERROR: MySQL not found in PATH. Please ensure MySQL is installed and added to PATH."
    exit 1
}

# Check if we can connect to MySQL
try {
    mysql -u root -e "SELECT 1" | Out-Null
    Write-Log "Successfully connected to MySQL"
} catch {
    Write-Log "ERROR: Cannot connect to MySQL. Please check your MySQL credentials."
    exit 1
}

# Check if main database exists
$mainDbExists = mysql -u root -e "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'drive_ease'" | Select-String "drive_ease"
if (-not $mainDbExists) {
    Write-Log "ERROR: Main database 'drive_ease' not found. Please ensure the main database exists."
    exit 1
}

# Create test database if it doesn't exist
$testDbExists = mysql -u root -e "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'drive_ease_test'" | Select-String "drive_ease_test"
if (-not $testDbExists) {
    Write-Log "Creating test database..."
    try {
        mysql -u root -e "CREATE DATABASE drive_ease_test;"
        Write-Log "Test database created successfully"
    } catch {
        Write-Log "ERROR: Failed to create test database: $_"
        exit 1
    }
} else {
    Write-Log "Test database already exists"
}

# Create .env.testing if it doesn't exist
if (-not (Test-Path .env.testing)) {
    Write-Log "Creating .env.testing..."
    try {
        Copy-Item .env .env.testing
        Write-Log ".env.testing created successfully"
    } catch {
        Write-Log "ERROR: Failed to create .env.testing: $_"
        exit 1
    }
} else {
    Write-Log ".env.testing already exists"
}

# Update .env.testing with test database
Write-Log "Updating .env.testing..."
try {
    (Get-Content .env.testing) -replace 'DB_DATABASE=.*', 'DB_DATABASE=drive_ease_test' | Set-Content .env.testing
    Write-Log ".env.testing updated successfully"
} catch {
    Write-Log "ERROR: Failed to update .env.testing: $_"
    exit 1
}

# Clear config cache
Write-Log "Clearing config cache..."
try {
    php artisan config:clear
    php artisan config:cache
    Write-Log "Config cache cleared successfully"
} catch {
    Write-Log "ERROR: Failed to clear config cache: $_"
    exit 1
}

# Run migrations and seeders
Write-Log "Running migrations on test database..."
try {
    php artisan migrate:fresh --env=testing --database=mysql_test
    Write-Log "Migrations completed successfully"
} catch {
    Write-Log "ERROR: Failed to run migrations: $_"
    exit 1
}

Write-Log "Running seeders..."
try {
    php artisan db:seed --class=TestDataSeeder --env=testing --database=mysql_test
    Write-Log "Seeders completed successfully"
} catch {
    Write-Log "ERROR: Failed to run seeders: $_"
    exit 1
}

# Calculate and log total execution time
$endTime = Get-Date
$duration = $endTime - $startTime
Write-Log "Setup completed in $($duration.TotalSeconds) seconds"
Write-Log "Test environment setup complete!" 