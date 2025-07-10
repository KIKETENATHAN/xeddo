# Enhanced SQLite to MySQL Migration Script for Windows
# This script provides a comprehensive database migration solution

param(
    [switch]$ShowHelp,
    [string]$OutputDir = "exports",
    [switch]$OpenPhpMyAdmin,
    [switch]$Verbose
)

# Color functions for better output
function Write-ColorOutput($message, $color = "White") {
    Write-Host $message -ForegroundColor $color
}

function Write-Header($title) {
    Write-Host "`n" + "="*60 -ForegroundColor Cyan
    Write-Host $title -ForegroundColor Yellow
    Write-Host "="*60 -ForegroundColor Cyan
}

function Write-Step($step, $description) {
    Write-Host "`n[$step] " -NoNewline -ForegroundColor Green
    Write-Host $description -ForegroundColor White
}

function Write-Success($message) {
    Write-Host "✅ $message" -ForegroundColor Green
}

function Write-Warning($message) {
    Write-Host "⚠️  $message" -ForegroundColor Yellow
}

function Write-Error($message) {
    Write-Host "❌ $message" -ForegroundColor Red
}

function Show-Help {
    Write-Header "SQLite to MySQL Migration Tool - Help"
    
    Write-Host @"
DESCRIPTION:
    This script migrates your Laravel SQLite database to MySQL format.
    It generates SQL export files and provides step-by-step instructions.

USAGE:
    .\migrate-to-mysql.ps1 [OPTIONS]

OPTIONS:
    -ShowHelp           Show this help message
    -OutputDir <path>   Specify output directory (default: exports)
    -OpenPhpMyAdmin     Open phpMyAdmin URL after migration
    -Verbose            Show detailed output

EXAMPLES:
    .\migrate-to-mysql.ps1
    .\migrate-to-mysql.ps1 -OutputDir "database_exports" -Verbose
    .\migrate-to-mysql.ps1 -OpenPhpMyAdmin

REQUIREMENTS:
    - PHP installed and accessible via 'php' command
    - SQLite database file at database/database.sqlite
    - Internet connection (for opening phpMyAdmin)

"@ -ForegroundColor White
}

function Test-Requirements {
    Write-Step "1" "Checking requirements..."
    
    # Check PHP
    try {
        $phpVersion = php -v 2>$null | Select-String "PHP \d+\.\d+\.\d+" | ForEach-Object { $_.Matches[0].Value }
        Write-Success "PHP found: $phpVersion"
    }
    catch {
        Write-Error "PHP not found. Please install PHP and add it to your PATH."
        return $false
    }
    
    # Check SQLite database
    if (Test-Path "database\database.sqlite") {
        $dbSize = (Get-Item "database\database.sqlite").Length
        Write-Success "SQLite database found (Size: $([math]::Round($dbSize/1KB, 2)) KB)"
    }
    else {
        Write-Error "SQLite database not found at database\database.sqlite"
        return $false
    }
    
    # Check if Laravel project
    if (Test-Path "artisan") {
        Write-Success "Laravel project detected"
    }
    else {
        Write-Warning "artisan file not found. Make sure you're in the Laravel project root."
    }
    
    return $true
}

function Start-Migration {
    Write-Step "2" "Starting database migration..."
    
    # Create output directory
    if (!(Test-Path $OutputDir)) {
        New-Item -ItemType Directory -Path $OutputDir -Force | Out-Null
        Write-Success "Created output directory: $OutputDir"
    }
    
    # Run the enhanced migration script
    Write-Host "🔄 Running enhanced migration script..." -ForegroundColor Cyan
    
    try {
        $result = php sqlite-to-mysql-migrator.php 2>&1
        
        if ($LASTEXITCODE -eq 0) {
            Write-Success "Migration script completed successfully"
            if ($Verbose) {
                Write-Host $result -ForegroundColor Gray
            }
        }
        else {
            Write-Error "Migration script failed"
            Write-Host $result -ForegroundColor Red
            return $false
        }
    }
    catch {
        Write-Error "Failed to run migration script: $_"
        return $false
    }
    
    return $true
}

function Show-ExportedFiles {
    Write-Step "3" "Checking exported files..."
    
    $exportFiles = Get-ChildItem -Path $OutputDir -Filter "*.sql" -ErrorAction SilentlyContinue
    $templateFiles = Get-ChildItem -Path $OutputDir -Filter "*.template" -ErrorAction SilentlyContinue
    
    if ($exportFiles.Count -gt 0) {
        Write-Success "SQL export files created:"
        foreach ($file in $exportFiles) {
            $size = [math]::Round($file.Length/1KB, 2)
            Write-Host "   📄 $($file.Name) ($size KB)" -ForegroundColor White
        }
    }
    
    if ($templateFiles.Count -gt 0) {
        Write-Success "Template files created:"
        foreach ($file in $templateFiles) {
            Write-Host "   📋 $($file.Name)" -ForegroundColor White
        }
    }
    
    return ($exportFiles.Count -gt 0)
}

function Show-Instructions {
    Write-Header "📋 MIGRATION INSTRUCTIONS"
    
    Write-Host @"
🚀 NEXT STEPS TO COMPLETE MIGRATION:

1. 📤 UPLOAD TO HOSTING
   • Upload the file: $OutputDir/mysql_complete_export.sql
   • Use cPanel File Manager or FTP client

2. 🗄️  CREATE MYSQL DATABASE
   • Log into your cPanel
   • Go to 'MySQL Databases'
   • Create a new database
   • Create a database user
   • Assign user to database with ALL PRIVILEGES

3. 📥 IMPORT SQL FILE
   • Open phpMyAdmin in cPanel
   • Select your new database
   • Click 'Import' tab
   • Choose your mysql_complete_export.sql file
   • Click 'Go' to import

4. ⚙️  UPDATE .ENV FILE
   • Copy settings from: $OutputDir/.env.mysql.template
   • Update DB_CONNECTION=mysql
   • Set your MySQL credentials

5. 🧪 TEST YOUR APPLICATION
   • Run: php artisan migrate:status
   • Test key functionality
   • Monitor for any errors

"@ -ForegroundColor White

    Write-Header "🔧 HELPFUL COMMANDS"
    
    Write-Host @"
# Check database connection
php artisan tinker
>>> DB::connection()->getPdo();

# Clear application cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# Run database tests
php artisan migrate:status
php artisan db:show

"@ -ForegroundColor Cyan
}

function Open-PhpMyAdminUrl {
    if ($OpenPhpMyAdmin) {
        Write-Step "4" "Opening phpMyAdmin..."
        
        $urls = @(
            "http://localhost/phpmyadmin",
            "http://localhost:8080/phpmyadmin",
            "https://cpanel.yourhost.com:2083",
            "https://www.yourhost.com:2083"
        )
        
        Write-Host "Common phpMyAdmin URLs:" -ForegroundColor Yellow
        foreach ($url in $urls) {
            Write-Host "   🔗 $url" -ForegroundColor Cyan
        }
        
        # Try to open the most common one
        try {
            Start-Process "http://localhost/phpmyadmin"
            Write-Success "Opened phpMyAdmin in default browser"
        }
        catch {
            Write-Warning "Could not open phpMyAdmin automatically. Please open it manually."
        }
    }
}

function Show-TroubleshootingTips {
    Write-Header "🔧 TROUBLESHOOTING TIPS"
    
    Write-Host @"
Common Issues and Solutions:

❓ Import fails in phpMyAdmin?
   • Check file size limits in hosting
   • Try uploading via File Manager instead
   • Contact hosting support for large databases

❓ Connection errors after switching?
   • Verify .env credentials are correct
   • Check database user permissions
   • Ensure database name matches exactly

❓ Missing data after migration?
   • Compare record counts: SELECT COUNT(*) FROM table_name
   • Check for special characters in data
   • Verify foreign key constraints

❓ Performance issues?
   • Add database indexes if needed
   • Optimize queries for MySQL syntax
   • Consider database connection pooling

"@ -ForegroundColor White
}

function Main {
    Clear-Host
    
    Write-Header "🔄 SQLite to MySQL Migration Tool"
    Write-Host "Migrating your Laravel application database..." -ForegroundColor White
    
    if ($ShowHelp) {
        Show-Help
        return
    }
    
    # Step 1: Check requirements
    if (!(Test-Requirements)) {
        Write-Error "Requirements check failed. Please fix the issues above."
        return
    }
    
    # Step 2: Run migration
    if (!(Start-Migration)) {
        Write-Error "Migration failed. Please check the errors above."
        return
    }
    
    # Step 3: Show results
    if (!(Show-ExportedFiles)) {
        Write-Error "No export files were created. Migration may have failed."
        return
    }
    
    # Step 4: Show instructions
    Show-Instructions
    
    # Step 5: Optional phpMyAdmin
    Open-PhpMyAdminUrl
    
    # Step 6: Troubleshooting
    Show-TroubleshootingTips
    
    Write-Header "✅ MIGRATION PREPARATION COMPLETED"
    Write-Success "Your database is ready for MySQL migration!"
    Write-Host "Follow the instructions above to complete the process." -ForegroundColor White
}

# Run the main function
Main
