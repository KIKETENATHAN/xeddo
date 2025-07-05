# Laravel Deployment Guide for Shared Hosting (cPanel)

## Pre-deployment Checklist

### 1. Prepare Your Application
- [ ] Test your application locally
- [ ] Optimize for production
- [ ] Create production environment file
- [ ] Build assets

### 2. Run these commands locally before deployment:

```bash
# Install production dependencies
composer install --no-dev --optimize-autoloader

# Clear all caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Build assets for production
npm run build

# Generate optimized autoloader
composer dump-autoload --optimize

# Export SQLite database to MySQL format
php sqlite_to_mysql_converter.php
```

## Deployment Steps

### Step 1: Create Database in cPanel
1. Login to your cPanel
2. Go to "MySQL Databases"
3. Create a new database (e.g., `yourdomain_xeddolink`)
4. Create a database user with full privileges
5. Note down database name, username, and password

### Step 2: Upload Files
1. Compress your entire Laravel project (excluding node_modules)
2. Upload to your hosting account
3. Extract in a temporary folder (not public_html)

### Step 3: File Structure Setup
Your hosting file structure should look like this:
```
/home/username/
├── public_html/           # This is your domain's document root
│   ├── index.php         # Laravel's public/index.php (modified)
│   ├── .htaccess         # Laravel's public/.htaccess
│   └── assets/           # Built CSS/JS files
├── laravel_app/          # Your Laravel application
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── routes/
│   └── vendor/
```

### Step 4: Move Files to Correct Locations
1. Upload your Laravel app to `/home/username/laravel_app/`
2. Copy contents of `public/` folder to `public_html/`
3. Update `public_html/index.php` to point to Laravel app

### Step 5: Configure Environment
1. Rename `.env.production` to `.env`
2. Update database credentials
3. Update APP_URL to your domain
4. Set APP_ENV=production and APP_DEBUG=false

### Step 6: Set Permissions
Set these folder permissions:
- `bootstrap/cache/` - 755
- `storage/` and all subdirectories - 755
- `storage/logs/` - 755
- `storage/framework/` - 755

### Step 7: Run Migrations (via cPanel Terminal or PHP script)
If cPanel has terminal access:
```bash
php artisan migrate --force
php artisan db:seed --force
```

## Important Notes

1. **Security**: Never upload your local `.env` file
2. **Database**: Use MySQL instead of SQLite for shared hosting
3. **File Permissions**: Ensure correct permissions for Laravel folders
4. **URL Configuration**: Update APP_URL in .env to your domain
5. **SSL**: Enable SSL in cPanel for HTTPS

## Troubleshooting

### Common Issues:
1. **500 Internal Server Error**: Check file permissions and .htaccess
2. **Database Connection**: Verify database credentials
3. **Missing Dependencies**: Ensure all Composer packages are installed
4. **Asset Issues**: Make sure assets are built and paths are correct

### Debug Steps:
1. Check error logs in cPanel
2. Temporarily enable APP_DEBUG=true (remember to disable after)
3. Verify file permissions
4. Check .htaccess configuration
