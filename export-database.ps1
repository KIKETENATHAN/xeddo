# SQLite to MySQL Export Script for Windows PowerShell

Write-Host "🔄 Starting SQLite to MySQL export process..." -ForegroundColor Green

# Check if SQLite database exists
if (!(Test-Path "database\database.sqlite")) {
    Write-Host "❌ SQLite database not found at database\database.sqlite" -ForegroundColor Red
    exit 1
}

Write-Host "📋 Found SQLite database" -ForegroundColor Yellow

# Method 1: Run PHP converter script
Write-Host "🚀 Running PHP converter..." -ForegroundColor Yellow
php sqlite_to_mysql_converter.php

# Method 2: Alternative - Use Laravel Artisan command (if available)
Write-Host "🔄 Attempting Laravel export command..." -ForegroundColor Yellow
php artisan db:export-mysql --file=laravel_mysql_export.sql

# Method 3: Direct SQLite3 command (if available)
Write-Host "🔄 Attempting direct SQLite3 export..." -ForegroundColor Yellow
try {
    sqlite3 database\database.sqlite .dump > sqlite3_direct_export.sql
    Write-Host "✅ Direct SQLite3 export completed" -ForegroundColor Green
} catch {
    Write-Host "⚠️ SQLite3 command not available" -ForegroundColor Yellow
}

Write-Host "📁 Export files created:" -ForegroundColor Cyan
Get-ChildItem -Path "." -Filter "*export*.sql" | ForEach-Object {
    Write-Host "   - $($_.Name)" -ForegroundColor White
}

Write-Host "`n🚀 Next steps:" -ForegroundColor Green
Write-Host "1. Upload the MySQL export file to your cPanel hosting" -ForegroundColor White
Write-Host "2. Create a MySQL database in cPanel" -ForegroundColor White
Write-Host "3. Import the SQL file via phpMyAdmin" -ForegroundColor White
Write-Host "4. Update your .env file with MySQL credentials" -ForegroundColor White

Write-Host "`n✅ Export process completed!" -ForegroundColor Green
