# Vite Asset Deployment Fix

## Problem Resolution
The "Vite manifest not found" error occurs because the build assets aren't properly deployed to production.

## Solution Steps

### 1. **Local Build** (Already Done)
```bash
npm run build
```
This creates the `public/build/` directory with:
- `manifest.json` - Asset mapping file
- `assets/` - CSS and JS files

### 2. **Production Deployment Structure**
Your production server should have this structure:
```
/home/xeddotra/xeddo/
├── public_html/              # Web root
│   ├── index.php
│   ├── .htaccess
│   └── build/                # Vite build assets
│       ├── manifest.json
│       └── assets/
│           ├── app-ogBwu_Df.css
│           └── app-DaBYqt0m.js
└── laravel_app/              # Laravel application
    ├── app/
    ├── config/
    └── ...
```

### 3. **Upload Requirements**
When uploading to cPanel:
1. **Laravel App**: Upload entire project to `/home/xeddotra/laravel_app/`
2. **Public Files**: Copy `public/*` to `/home/xeddotra/public_html/`
3. **Build Assets**: Ensure `public/build/` is copied to `public_html/build/`

### 4. **Verification Steps**
Check these files exist on production:
- `/home/xeddotra/public_html/build/manifest.json`
- `/home/xeddotra/public_html/build/assets/app-ogBwu_Df.css`
- `/home/xeddotra/public_html/build/assets/app-DaBYqt0m.js`

### 5. **Alternative: Disable Vite in Production**
If you want to use basic CSS/JS without Vite, update your blade templates:

Instead of:
```blade
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

Use:
```blade
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ asset('js/app.js') }}"></script>
```

## Troubleshooting

### If manifest.json is still missing:
1. **Check file permissions**: Ensure 644 for files, 755 for directories
2. **Verify path**: Confirm the path matches your hosting structure
3. **Re-upload build folder**: Sometimes files don't upload completely

### Environment Configuration:
Ensure your `.env` file has:
```env
APP_ENV=production
APP_DEBUG=false
VITE_APP_NAME="${APP_NAME}"
```

### Alternative Asset Compilation:
If Vite continues to have issues, use Laravel Mix:
```bash
npm install laravel-mix --save-dev
npm run production
```
