# Production Setup Script for Xeddolink Laravel App

Write-Host "🚀 Setting up Xeddolink for Production Deployment..." -ForegroundColor Green

# Check if we're in a Git repository
try {
    $gitStatus = git status 2>$null
    Write-Host "✅ Git repository detected" -ForegroundColor Green
} catch {
    Write-Host "❌ No Git repository found. Initializing..." -ForegroundColor Red
    git init
    Write-Host "✅ Git repository initialized" -ForegroundColor Green
}

# Check current branch
$currentBranch = git branch --show-current
Write-Host "📍 Current branch: $currentBranch" -ForegroundColor Yellow

# Switch to main branch if on master
if ($currentBranch -eq "master") {
    Write-Host "🔄 Renaming master branch to main..." -ForegroundColor Yellow
    git branch -m master main
    Write-Host "✅ Branch renamed to main" -ForegroundColor Green
}

# Add remote origin if not exists
$remotes = git remote
if (-not $remotes -contains "origin") {
    Write-Host "🔗 GitHub repository setup needed..." -ForegroundColor Yellow
    Write-Host "📋 Steps to create GitHub repository:" -ForegroundColor Cyan
    Write-Host "1. Go to https://github.com/new" -ForegroundColor White
    Write-Host "2. Repository name: xeddolink" -ForegroundColor White
    Write-Host "3. Keep it Public or Private as needed" -ForegroundColor White
    Write-Host "4. Don't initialize with README" -ForegroundColor White
    Write-Host "5. Click 'Create repository'" -ForegroundColor White
    Write-Host ""
    
    $repoUrl = Read-Host "Enter your GitHub repository URL (https://github.com/username/reponame.git)"
    if ($repoUrl) {
        git remote add origin $repoUrl
        Write-Host "✅ Remote origin added: $repoUrl" -ForegroundColor Green
    }
} else {
    $originUrl = git remote get-url origin
    Write-Host "✅ Remote origin already set: $originUrl" -ForegroundColor Green
}

# Create .gitignore if it doesn't exist
if (!(Test-Path ".gitignore")) {
    Write-Host "📝 Creating .gitignore..." -ForegroundColor Yellow
    @"
# Laravel
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.env.production
.phpunit.result.cache
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log
auth.json

# IDE
/.idea
/.vscode
/.fleet

# OS
.DS_Store
Thumbs.db

# Temporary files
*.tmp
*.temp
*.log
"@ | Out-File -FilePath ".gitignore" -Encoding UTF8
    Write-Host "✅ .gitignore created" -ForegroundColor Green
}

# Check for uncommitted changes
$status = git status --porcelain
if ($status) {
    Write-Host "📦 Committing pending changes..." -ForegroundColor Yellow
    git add .
    git commit -m "Production deployment setup with GitHub Actions"
    Write-Host "✅ Changes committed" -ForegroundColor Green
}

# Build production assets
Write-Host "🎨 Building production assets..." -ForegroundColor Yellow
try {
    npm run build
    Write-Host "✅ Production assets built successfully" -ForegroundColor Green
} catch {
    Write-Host "⚠️ Asset build failed. Make sure to run 'npm install' first" -ForegroundColor Yellow
}

# Push to GitHub
Write-Host "🚀 Pushing to GitHub..." -ForegroundColor Yellow
try {
    git push -u origin main
    Write-Host "✅ Code pushed to GitHub successfully!" -ForegroundColor Green
} catch {
    Write-Host "⚠️ Push failed. You may need to:" -ForegroundColor Yellow
    Write-Host "   1. Set up GitHub repository first" -ForegroundColor Gray
    Write-Host "   2. Authenticate with GitHub" -ForegroundColor Gray
    Write-Host "   3. Run: git push -u origin main" -ForegroundColor Gray
}

Write-Host "`n🎯 Next Steps for Production Deployment:" -ForegroundColor Cyan
Write-Host "1. ✅ GitHub Repository Setup" -ForegroundColor Green
Write-Host "2. 🔐 Configure GitHub Secrets:" -ForegroundColor Yellow
Write-Host "   Go to: Repository → Settings → Secrets and variables → Actions" -ForegroundColor Gray
Write-Host "   Add these secrets:" -ForegroundColor Gray
Write-Host "   • FTP_HOST (your cPanel FTP hostname)" -ForegroundColor Gray
Write-Host "   • FTP_USERNAME (your cPanel username)" -ForegroundColor Gray
Write-Host "   • FTP_PASSWORD (your cPanel password)" -ForegroundColor Gray
Write-Host "   • DB_DATABASE (your MySQL database name)" -ForegroundColor Gray
Write-Host "   • DB_USERNAME (your MySQL username)" -ForegroundColor Gray
Write-Host "   • DB_PASSWORD (your MySQL password)" -ForegroundColor Gray
Write-Host "   • DOMAIN_NAME (your domain, e.g., yourdomain.com)" -ForegroundColor Gray

Write-Host "`n3. 🗄️ Database Setup:" -ForegroundColor Yellow
Write-Host "   • Upload mysql_export.sql to cPanel" -ForegroundColor Gray
Write-Host "   • Import via phpMyAdmin" -ForegroundColor Gray
Write-Host "   • Or use fresh migrations on production" -ForegroundColor Gray

Write-Host "`n4. 🚀 Automatic Deployment:" -ForegroundColor Yellow
Write-Host "   • Push changes to main branch" -ForegroundColor Gray
Write-Host "   • GitHub Actions will automatically deploy" -ForegroundColor Gray
Write-Host "   • Check Actions tab for deployment status" -ForegroundColor Gray

Write-Host "`n✨ Your app is ready for production deployment!" -ForegroundColor Green
Write-Host "📖 See GITHUB_ACTIONS_SETUP.md for detailed instructions" -ForegroundColor Cyan
