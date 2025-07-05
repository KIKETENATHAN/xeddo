# Laravel Deployment Preparation Script for Windows
# Run this script before uploading to shared hosting

Write-Host "🚀 Preparing Laravel application for deployment..." -ForegroundColor Green

# Step 1: Install production dependencies
Write-Host "📦 Installing production dependencies..." -ForegroundColor Yellow
composer install --no-dev --optimize-autoloader --no-interaction

# Step 2: Clear caches
Write-Host "🧹 Clearing application caches..." -ForegroundColor Yellow
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Step 3: Build assets
Write-Host "🎨 Building production assets..." -ForegroundColor Yellow
npm run build

# Step 4: Optimize autoloader
Write-Host "⚡ Optimizing autoloader..." -ForegroundColor Yellow
composer dump-autoload --optimize

# Step 5: Create deployment package
Write-Host "📦 Creating deployment package..." -ForegroundColor Yellow

# Remove development files and folders
$itemsToRemove = @(
    "node_modules",
    ".git",
    "tests",
    "storage/logs/*.log"
)

foreach ($item in $itemsToRemove) {
    if (Test-Path $item) {
        Remove-Item $item -Recurse -Force
        Write-Host "Removed: $item" -ForegroundColor Red
    }
}

# Create a zip file for upload
Write-Host "📁 Creating zip file for upload..." -ForegroundColor Yellow
$sourceDir = Get-Location
$parentDir = Split-Path $sourceDir -Parent
$zipPath = Join-Path $parentDir "xeddolink-deployment.zip"

# Create zip file
Add-Type -AssemblyName System.IO.Compression.FileSystem
[System.IO.Compression.ZipFile]::CreateFromDirectory($sourceDir, $zipPath)

Write-Host "✅ Deployment preparation complete!" -ForegroundColor Green
Write-Host "📂 Upload the 'xeddolink-deployment.zip' file to your hosting account" -ForegroundColor Cyan
Write-Host "📖 Follow the DEPLOYMENT_GUIDE.md for next steps" -ForegroundColor Cyan
