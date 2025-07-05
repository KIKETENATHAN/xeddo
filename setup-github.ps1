# GitHub Repository Setup Script for Windows PowerShell

Write-Host "🚀 Setting up GitHub repository for Laravel deployment..." -ForegroundColor Green

# Check if git is installed
try {
    $gitVersion = git --version
    Write-Host "✅ Git found: $gitVersion" -ForegroundColor Green
} catch {
    Write-Host "❌ Git not found. Please install Git first: https://git-scm.com/download/win" -ForegroundColor Red
    exit 1
}

# Check if we're in the right directory
if (!(Test-Path "composer.json")) {
    Write-Host "❌ Please run this script from your Laravel project root directory" -ForegroundColor Red
    exit 1
}

Write-Host "📂 Current directory: $(Get-Location)" -ForegroundColor Yellow

# Initialize git repository if not already done
if (!(Test-Path ".git")) {
    Write-Host "🔧 Initializing Git repository..." -ForegroundColor Yellow
    git init
    Write-Host "✅ Git repository initialized" -ForegroundColor Green
} else {
    Write-Host "✅ Git repository already exists" -ForegroundColor Green
}

# Create .gitignore if it doesn't exist
if (!(Test-Path ".gitignore")) {
    Write-Host "📝 Creating .gitignore file..." -ForegroundColor Yellow
    @"
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.env.production
.phpunit.result.cache
docker-compose.override.yml
Homestead.json
Homestead.yaml
auth.json
npm-debug.log
yarn-error.log
/.fleet
/.idea
/.vscode
"@ | Out-File -FilePath ".gitignore" -Encoding UTF8
    Write-Host "✅ .gitignore created" -ForegroundColor Green
}

# Add files to git
Write-Host "📦 Adding files to Git..." -ForegroundColor Yellow
git add .

# Check if there are changes to commit
$status = git status --porcelain
if ($status) {
    Write-Host "💾 Committing files..." -ForegroundColor Yellow
    git commit -m "Initial commit: Laravel project with GitHub Actions deployment"
    Write-Host "✅ Files committed" -ForegroundColor Green
} else {
    Write-Host "✅ No changes to commit" -ForegroundColor Green
}

# Set main branch
Write-Host "🌿 Setting main branch..." -ForegroundColor Yellow
git branch -M main

Write-Host "`n🎯 Next Steps:" -ForegroundColor Cyan
Write-Host "1. Create a GitHub repository:" -ForegroundColor White
Write-Host "   - Go to https://github.com/new" -ForegroundColor Gray
Write-Host "   - Repository name: xeddolink (or your preferred name)" -ForegroundColor Gray
Write-Host "   - Keep it public or private as needed" -ForegroundColor Gray
Write-Host "   - Don't initialize with README (we already have files)" -ForegroundColor Gray

Write-Host "`n2. Copy these commands to link your repository:" -ForegroundColor White
Write-Host "   git remote add origin https://github.com/YOURUSERNAME/YOURREPOSITORY.git" -ForegroundColor Gray
Write-Host "   git push -u origin main" -ForegroundColor Gray

Write-Host "`n3. Set up GitHub Secrets (after creating repository):" -ForegroundColor White
Write-Host "   - Go to Repository → Settings → Secrets and variables → Actions" -ForegroundColor Gray
Write-Host "   - Add the secrets listed in GITHUB_ACTIONS_SETUP.md" -ForegroundColor Gray

Write-Host "`n4. Your GitHub Actions workflow will run automatically on push!" -ForegroundColor White

Write-Host "`n📖 See GITHUB_ACTIONS_SETUP.md for detailed instructions" -ForegroundColor Cyan
Write-Host "✅ Repository setup complete!" -ForegroundColor Green
