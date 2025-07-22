#!/usr/bin/env pwsh

# Xeddolink Production Deployment Checklist
# Run this script before uploading to your hosting provider

Write-Host "🚀 XEDDOLINK PRODUCTION DEPLOYMENT CHECKLIST" -ForegroundColor Green
Write-Host "=============================================" -ForegroundColor Green
Write-Host ""

$projectPath = Get-Location
$errors = @()
$warnings = @()

# Check 1: Environment file
Write-Host "1. Checking environment configuration..." -ForegroundColor Cyan
if (Test-Path ".env") {
    $envContent = Get-Content ".env" -Raw
    if ($envContent -match "APP_ENV=production") {
        Write-Host "   ✅ APP_ENV is set to production" -ForegroundColor Green
    } else {
        $errors += "APP_ENV should be set to 'production'"
    }
    
    if ($envContent -match "APP_DEBUG=false") {
        Write-Host "   ✅ APP_DEBUG is disabled" -ForegroundColor Green
    } else {
        $errors += "APP_DEBUG should be set to 'false'"
    }
    
    if ($envContent -match "DB_CONNECTION=mysql") {
        Write-Host "   ✅ Database is configured for MySQL" -ForegroundColor Green
    } else {
        $warnings += "Consider using MySQL for production (currently using SQLite)"
    }
} else {
    $errors += ".env file not found"
}

# Check 2: Dependencies
Write-Host "`n2. Checking dependencies..." -ForegroundColor Cyan
if (Test-Path "vendor/autoload.php") {
    Write-Host "   ✅ Composer dependencies installed" -ForegroundColor Green
} else {
    $errors += "Composer dependencies not installed. Run 'composer install --no-dev --optimize-autoloader'"
}

if (Test-Path "node_modules") {
    Write-Host "   ⚠️  node_modules found - should be excluded from upload" -ForegroundColor Yellow
    $warnings += "node_modules folder found - don't upload this to production"
}

# Check 3: Built assets
Write-Host "`n3. Checking built assets..." -ForegroundColor Cyan
if (Test-Path "public/build") {
    Write-Host "   ✅ Vite assets built" -ForegroundColor Green
} else {
    $errors += "Assets not built. Run 'npm run build'"
}

# Check 4: Cache directories
Write-Host "`n4. Checking cache directories..." -ForegroundColor Cyan
$cacheDirs = @(
    "bootstrap/cache",
    "storage/framework/cache",
    "storage/framework/sessions",
    "storage/framework/views",
    "storage/logs"
)

foreach ($dir in $cacheDirs) {
    if (Test-Path $dir) {
        Write-Host "   ✅ $dir exists" -ForegroundColor Green
    } else {
        $warnings += "Directory $dir should exist"
    }
}

# Check 5: Production index.php
Write-Host "`n5. Checking production files..." -ForegroundColor Cyan
if (Test-Path "index_for_public_html.php") {
    Write-Host "   ✅ Production index.php ready" -ForegroundColor Green
} else {
    $errors += "index_for_public_html.php not found"
}

# Check 6: Database export
Write-Host "`n6. Checking database export..." -ForegroundColor Cyan
if (Test-Path "exports/mysql_export.sql") {
    Write-Host "   ✅ MySQL export file exists" -ForegroundColor Green
} else {
    $warnings += "No MySQL export found. Run database export if needed"
}

# Summary
Write-Host "`n📋 DEPLOYMENT SUMMARY" -ForegroundColor Yellow
Write-Host "===================" -ForegroundColor Yellow

if ($errors.Count -eq 0) {
    Write-Host "✅ All critical checks passed!" -ForegroundColor Green
} else {
    Write-Host "❌ Critical issues found:" -ForegroundColor Red
    foreach ($error in $errors) {
        Write-Host "   • $error" -ForegroundColor Red
    }
}

if ($warnings.Count -gt 0) {
    Write-Host "`n⚠️  Warnings:" -ForegroundColor Yellow
    foreach ($warning in $warnings) {
        Write-Host "   • $warning" -ForegroundColor Yellow
    }
}

Write-Host "`n🔧 NEXT STEPS FOR DEPLOYMENT:" -ForegroundColor Cyan
Write-Host "1. Upload deployment-verify.php to public_html" -ForegroundColor White
Write-Host "2. Upload index_for_public_html.php as index.php to public_html" -ForegroundColor White
Write-Host "3. Upload .htaccess from public/ to public_html" -ForegroundColor White
Write-Host "4. Upload built assets from public/build to public_html/build" -ForegroundColor White
Write-Host "5. Upload Laravel app to laravel_app/ (not public_html)" -ForegroundColor White
Write-Host "6. Update .env with production database credentials" -ForegroundColor White
Write-Host "7. Clear all caches via cPanel or SSH" -ForegroundColor White
Write-Host "8. Test deployment with deployment-verify.php" -ForegroundColor White

Write-Host "`n🚨 CACHE CLEARING COMMANDS (if you have SSH access):" -ForegroundColor Magenta
Write-Host "php artisan config:clear" -ForegroundColor White
Write-Host "php artisan route:clear" -ForegroundColor White
Write-Host "php artisan view:clear" -ForegroundColor White
Write-Host "php artisan cache:clear" -ForegroundColor White

Write-Host "`nDeployment checklist completed!" -ForegroundColor Green
