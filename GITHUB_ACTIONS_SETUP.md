# 🚀 GitHub Actions Deployment Setup for cPanel

## Overview
This setup will automatically deploy your Laravel app to cPanel hosting whenever you push to your main branch.

## 📋 Prerequisites
1. GitHub repository for your Laravel project
2. cPanel hosting with FTP access
3. MySQL database created in cPanel

## 🔧 Setup Steps

### Step 1: Repository Setup
1. Initialize Git in your project (if not already done):
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   ```

2. Create GitHub repository and push:
   ```bash
   git remote add origin https://github.com/yourusername/your-repo-name.git
   git branch -M main
   git push -u origin main
   ```

### Step 2: Configure GitHub Secrets
Go to your GitHub repository → Settings → Secrets and variables → Actions

Add these secrets:

#### FTP Configuration:
- `FTP_HOST`: Your cPanel FTP hostname (e.g., `ftp.yourdomain.com`)
- `FTP_USERNAME`: Your cPanel username
- `FTP_PASSWORD`: Your cPanel password

#### Database Configuration:
- `DB_DATABASE`: Your MySQL database name (e.g., `yourdomain_xeddolink`)
- `DB_USERNAME`: Your MySQL username
- `DB_PASSWORD`: Your MySQL password

#### Domain Configuration:
- `DOMAIN_NAME`: Your domain (e.g., `yourdomain.com`)

#### SSH Configuration (Optional - if your host supports SSH):
- `SSH_HOST`: Your server hostname
- `SSH_USERNAME`: Your SSH username
- `SSH_PASSWORD`: Your SSH password

### Step 3: Workflow Files
Two workflow options are provided:

#### Option 1: `deploy-ftp.yml` (Recommended for shared hosting)
- Simple FTP deployment
- Works with most cPanel hosting
- Deploys to `/laravel_app/` and `/public_html/`

#### Option 2: `deploy.yml` (Advanced)
- Includes testing and SSH commands
- Requires SSH access
- More comprehensive deployment

### Step 4: cPanel Directory Structure
The deployment expects this structure:
```
/home/yourusername/
├── public_html/              # Web root
│   ├── index.php            # Laravel entry point
│   ├── .htaccess            # URL rewriting
│   └── build/               # Vite assets
└── laravel_app/             # Laravel application
    ├── app/
    ├── config/
    ├── vendor/
    └── .env                 # Production environment
```

## 🎯 How It Works

### Automated Process:
1. **Trigger**: Push to main branch
2. **Build**: Install dependencies and build assets
3. **Deploy**: Upload files via FTP to correct locations
4. **Configure**: Update .env for production settings

### Manual Trigger:
You can also manually trigger deployment:
1. Go to Actions tab in GitHub
2. Select "Deploy to cPanel (FTP Only)"
3. Click "Run workflow"

## 🔧 First Time Setup

### 1. Database Migration
After first deployment, run migrations:
- Upload `migrate.php` to `public_html/`
- Visit `yourdomain.com/migrate.php?password=your_secure_password`
- Delete `migrate.php` after completion

### 2. File Permissions
Ensure correct permissions in cPanel File Manager:
- `laravel_app/storage/`: 755
- `laravel_app/bootstrap/cache/`: 755

### 3. Environment Variables
The workflow automatically creates a production `.env` file with:
- `APP_ENV=production`
- `APP_DEBUG=false`
- MySQL database configuration
- Your domain URL

## 🚨 Security Notes

### Protect Sensitive Files:
The workflow excludes:
- `.env.example`
- `tests/`
- `node_modules/`
- `.git/`

### Environment Security:
- Never commit `.env` files
- Use GitHub Secrets for sensitive data
- Enable two-factor authentication on GitHub

## 🔄 Development Workflow

### Standard Flow:
1. Make changes locally
2. Test thoroughly
3. Commit and push to main branch
4. GitHub Actions automatically deploys
5. Verify deployment on your live site

### Rollback Process:
If deployment fails:
1. Check Actions logs for errors
2. Fix issues locally
3. Push new commit to trigger redeployment

## 📊 Monitoring

### Check Deployment Status:
- GitHub Actions tab shows deployment progress
- Green checkmark = successful deployment
- Red X = deployment failed (check logs)

### Common Issues:
1. **FTP connection failed**: Check FTP credentials in secrets
2. **File permission errors**: Update permissions in cPanel
3. **Database connection errors**: Verify database secrets
4. **Asset loading issues**: Ensure build files are uploaded

## 🎉 Benefits

✅ **Automatic deployment** on every push
✅ **Consistent builds** with proper dependencies
✅ **Production optimization** (minified assets, cached config)
✅ **Version control** for all changes
✅ **Rollback capability** through Git history
✅ **Team collaboration** with controlled deployments

## 🚀 Next Steps

1. Set up GitHub repository
2. Configure secrets
3. Push code to trigger first deployment
4. Run database migrations
5. Test your live application!

Your Laravel app will now deploy automatically whenever you push changes! 🎯
