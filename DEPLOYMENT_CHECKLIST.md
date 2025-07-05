# 🚀 Laravel Deployment Checklist for Shared Hosting

## Pre-Deployment (Local Machine)

### 1. Prepare Environment
- [ ] Copy `.env.production` to `.env` and update with production values
- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Update `APP_URL` to your domain
- [ ] Configure database credentials for your hosting MySQL database

### 2. Run Preparation Script
```powershell
# On Windows
.\deploy-prepare.ps1

# On Linux/Mac
./deploy-prepare.sh
```

### 3. Manual Preparation (if script fails)
```bash
composer install --no-dev --optimize-autoloader
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
npm run build
composer dump-autoload --optimize
```

## Deployment Steps

### Step 1: cPanel Database Setup
1. [ ] Login to cPanel
2. [ ] Navigate to "MySQL Databases"
3. [ ] Create new database: `yourdomain_xeddolink`
4. [ ] Create database user with full privileges
5. [ ] Note credentials for `.env` file

### Step 2: File Upload
1. [ ] Upload `xeddolink-deployment.zip` to hosting account
2. [ ] Extract to temporary folder (not `public_html`)
3. [ ] You should have: `/home/username/laravel_app/`

### Step 3: Public Files Setup
1. [ ] Copy all files from `laravel_app/public/` to `public_html/`
2. [ ] Upload `index_for_public_html.php` as `public_html/index.php`
3. [ ] Copy `migrate.php` to `public_html/migrate.php`

### Step 4: Environment Configuration
1. [ ] Upload `.env.production` as `laravel_app/.env`
2. [ ] Update database credentials in `.env`
3. [ ] Update `APP_URL` to your domain
4. [ ] Generate new `APP_KEY` if needed

### Step 5: File Permissions
Set these permissions in cPanel File Manager:
- [ ] `laravel_app/bootstrap/cache/` → 755
- [ ] `laravel_app/storage/` → 755 (recursive)
- [ ] `laravel_app/storage/logs/` → 755
- [ ] `laravel_app/storage/framework/` → 755

### Step 6: Run Migrations
**Option A: Via Browser (if no terminal access)**
1. [ ] Visit: `yourdomain.com/migrate.php?password=your_secure_password_here`
2. [ ] For seeding: `yourdomain.com/migrate.php?password=your_secure_password_here&seed=1`
3. [ ] Delete `migrate.php` after completion

**Option B: Via Terminal (if available)**
```bash
cd /home/username/laravel_app
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 7: SSL Setup
1. [ ] Enable SSL certificate in cPanel
2. [ ] Force HTTPS redirect
3. [ ] Update `.env` to use HTTPS URLs

## Post-Deployment Verification

### Test Your Application
- [ ] Visit your domain
- [ ] Test user registration/login
- [ ] Test core functionality
- [ ] Check error logs if issues occur

### Security Checklist
- [ ] Delete `migrate.php` from public_html
- [ ] Verify `.env` is not accessible via browser
- [ ] Check file permissions are correct
- [ ] Ensure `APP_DEBUG=false` in production

### Performance Optimization
- [ ] Enable OPcache in cPanel if available
- [ ] Check that caches are working
- [ ] Monitor application performance

## Troubleshooting

### Common Issues:

**500 Internal Server Error**
- Check file permissions
- Verify `.htaccess` is uploaded
- Check error logs in cPanel

**Database Connection Error**
- Verify database credentials in `.env`
- Ensure database user has proper privileges
- Check if database server is accessible

**Missing Assets**
- Ensure `npm run build` was executed
- Check that assets were uploaded to `public_html/build/`
- Verify asset paths in blade templates

**Route Not Found**
- Check that `.htaccess` is in `public_html/`
- Verify URL rewriting is enabled
- Clear route cache: `php artisan route:cache`

### Log Files to Check:
- cPanel Error Logs
- `laravel_app/storage/logs/laravel.log`
- PHP Error Logs

## Environment Variables Template

```env
APP_NAME=Xeddolink
APP_ENV=production
APP_KEY=base64:your_generated_key_here
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=yourdomain_xeddolink
DB_USERNAME=yourdomain_dbuser
DB_PASSWORD=your_secure_password

MAIL_MAILER=smtp
MAIL_HOST=mail.yourdomain.com
MAIL_PORT=587
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
```

## Final Notes

1. **Security**: Never expose `.env` file via web
2. **Backups**: Always backup before deployment
3. **Testing**: Test thoroughly on production
4. **Monitoring**: Set up error monitoring
5. **Updates**: Plan for future updates/maintenance

🎉 **Congratulations!** Your Laravel application should now be live!
