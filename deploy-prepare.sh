#!/bin/bash

# Laravel Deployment Preparation Script
# Run this script before uploading to shared hosting

echo "🚀 Preparing Laravel application for deployment..."

# Step 1: Install production dependencies
echo "📦 Installing production dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Step 2: Clear caches
echo "🧹 Clearing application caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Step 3: Build assets
echo "🎨 Building production assets..."
npm run build

# Step 4: Optimize autoloader
echo "⚡ Optimizing autoloader..."
composer dump-autoload --optimize

# Step 5: Create deployment package
echo "📦 Creating deployment package..."
# Remove development files
rm -rf node_modules
rm -rf .git
rm -rf tests
rm -rf storage/logs/*.log

# Create a zip file for upload
echo "📁 Creating zip file for upload..."
cd ..
zip -r xeddolink-deployment.zip xeddo -x "*.git*" "node_modules/*" "tests/*" "*.log"

echo "✅ Deployment preparation complete!"
echo "📂 Upload the 'xeddolink-deployment.zip' file to your hosting account"
echo "📖 Follow the DEPLOYMENT_GUIDE.md for next steps"
