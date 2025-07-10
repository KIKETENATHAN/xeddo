# Complete SQLite to MySQL Migration Script
# This script runs all migration tools and prepares everything for deployment

param(
    [switch]$AnalyzeOnly,
    [switch]$SkipAnalysis,
    [string]$OutputDir = "exports"
)

function Write-Header($title) {
    Clear-Host
    Write-Host "`n" + "="*80 -ForegroundColor Cyan
    Write-Host " $title" -ForegroundColor Yellow
    Write-Host "="*80 -ForegroundColor Cyan
    Write-Host ""
}

function Write-Step($number, $title, $description) {
    Write-Host "`n[$number] $title" -ForegroundColor Green
    Write-Host "    $description" -ForegroundColor White
}

function Write-Success($message) {
    Write-Host "✅ $message" -ForegroundColor Green
}

function Write-Error($message) {
    Write-Host "❌ $message" -ForegroundColor Red
}

function Test-PhpAvailable {
    try {
        $null = php -v 2>$null
        return $true
    }
    catch {
        return $false
    }
}

function Run-DatabaseAnalysis {
    Write-Step "1" "Database Analysis" "Analyzing current SQLite database structure"
    
    if (Test-Path "database-analyzer.php") {
        try {
            $result = php database-analyzer.php
            Write-Host $result
            Write-Success "Database analysis completed"
            return $true
        }
        catch {
            Write-Error "Database analysis failed: $_"
            return $false
        }
    }
    else {
        Write-Error "Database analyzer script not found"
        return $false
    }
}

function Run-PhpMigration {
    Write-Step "2" "PHP Migration Script" "Running enhanced PHP migration tool"
    
    if (Test-Path "sqlite-to-mysql-migrator.php") {
        try {
            $result = php sqlite-to-mysql-migrator.php
            Write-Host $result
            Write-Success "PHP migration completed"
            return $true
        }
        catch {
            Write-Error "PHP migration failed: $_"
            return $false
        }
    }
    else {
        Write-Error "PHP migration script not found"
        return $false
    }
}

function Run-LaravelMigration {
    Write-Step "3" "Laravel Artisan Command" "Running Laravel migration command"
    
    if (Test-Path "artisan") {
        try {
            $result = php artisan db:migrate-to-mysql --output=$OutputDir
            Write-Host $result
            Write-Success "Laravel migration completed"
            return $true
        }
        catch {
            Write-Error "Laravel migration failed: $_"
            return $false
        }
    }
    else {
        Write-Error "Laravel artisan not found"
        return $false
    }
}

function Show-ExportFiles {
    Write-Step "4" "Export Files" "Checking generated export files"
    
    if (Test-Path $OutputDir) {
        $files = Get-ChildItem -Path $OutputDir -File
        
        if ($files.Count -gt 0) {
            Write-Success "Found $($files.Count) export files:"
            
            foreach ($file in $files) {
                $size = [math]::Round($file.Length/1KB, 2)
                $icon = switch ($file.Extension) {
                    ".sql" { "🗄️" }
                    ".md" { "📋" }
                    ".template" { "⚙️" }
                    default { "📄" }
                }
                Write-Host "   $icon $($file.Name) ($size KB)" -ForegroundColor White
            }
            
            return $true
        }
        else {
            Write-Error "No export files found in $OutputDir"
            return $false
        }
    }
    else {
        Write-Error "Export directory not found: $OutputDir"
        return $false
    }
}

function Show-FinalInstructions {
    Write-Step "5" "Final Instructions" "Next steps for completing the migration"
    
    Write-Host @"

🚀 MIGRATION FILES READY!

📁 Your export files are in: $OutputDir\

🔧 NEXT STEPS:

1. 📤 UPLOAD TO HOSTING
   • Upload mysql_complete_export.sql to your web hosting
   • Use cPanel File Manager or FTP

2. 🗄️ CREATE MYSQL DATABASE
   • Access your hosting control panel
   • Create new MySQL database
   • Create database user with full privileges

3. 📥 IMPORT SQL FILE
   • Open phpMyAdmin
   • Select your database
   • Import the SQL file

4. ⚙️ UPDATE APPLICATION
   • Copy settings from .env.mysql.template
   • Update your .env file
   • Change DB_CONNECTION=mysql

5. 🧪 TEST MIGRATION
   • Run: php artisan config:clear
   • Test your application
   • Verify data integrity

📋 VERIFICATION CHECKLIST:
   □ Database connection works
   □ All tables imported correctly
   □ Record counts match
   □ Application functions normally
   □ No errors in logs

"@ -ForegroundColor White

    Write-Host "🎯 HELPFUL RESOURCES:" -ForegroundColor Yellow
    Write-Host "   • Migration Guide: MYSQL_MIGRATION_GUIDE.md" -ForegroundColor White
    Write-Host "   • Verification Queries: $OutputDir\verification_queries.sql" -ForegroundColor White
    Write-Host "   • Environment Template: $OutputDir\.env.mysql.template" -ForegroundColor White
}

function Main {
    Write-Header "🔄 Complete SQLite to MySQL Migration Suite"
    
    # Check PHP
    if (!(Test-PhpAvailable)) {
        Write-Error "PHP is not available. Please install PHP and add it to PATH."
        exit 1
    }
    
    Write-Success "PHP is available"
    
    # Check database file
    if (!(Test-Path "database\database.sqlite")) {
        Write-Error "SQLite database not found at database\database.sqlite"
        exit 1
    }
    
    Write-Success "SQLite database found"
    
    # Create output directory
    if (!(Test-Path $OutputDir)) {
        New-Item -ItemType Directory -Path $OutputDir -Force | Out-Null
        Write-Success "Created output directory: $OutputDir"
    }
    
    $success = $true
    
    # Run analysis (unless skipped)
    if (!$SkipAnalysis) {
        if (!(Run-DatabaseAnalysis)) {
            $success = $false
        }
    }
    
    # If analyze only, stop here
    if ($AnalyzeOnly) {
        Write-Host "`n✅ Analysis complete. Use -AnalyzeOnly:$false to run full migration." -ForegroundColor Green
        return
    }
    
    # Run PHP migration
    if (!(Run-PhpMigration)) {
        $success = $false
    }
    
    # Run Laravel migration (optional, may fail if not Laravel project)
    Run-LaravelMigration | Out-Null
    
    # Check export files
    if (!(Show-ExportFiles)) {
        $success = $false
    }
    
    if ($success) {
        Show-FinalInstructions
        Write-Host "`n🎉 MIGRATION SUITE COMPLETED SUCCESSFULLY!" -ForegroundColor Green
        Write-Host "Follow the instructions above to complete your MySQL migration." -ForegroundColor White
    }
    else {
        Write-Host "`n❌ MIGRATION SUITE ENCOUNTERED ERRORS" -ForegroundColor Red
        Write-Host "Please review the error messages above and try again." -ForegroundColor White
        exit 1
    }
}

# Run the main function
Main
