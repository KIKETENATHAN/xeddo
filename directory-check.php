<?php
/**
 * Server Directory Structure Checker
 * Upload this to your public_html folder to understand your hosting structure
 */

echo "<h2>🏗️ Server Directory Structure Checker</h2>";

function listDirectory($path, $level = 0, $maxLevel = 3) {
    if ($level > $maxLevel || !is_dir($path)) return;
    
    $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
    $items = scandir($path);
    
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        
        $fullPath = $path . '/' . $item;
        $isDir = is_dir($fullPath);
        $icon = $isDir ? '📁' : '📄';
        
        echo $indent . $icon . ' ' . $item;
        
        if (!$isDir) {
            echo ' (' . formatBytes(filesize($fullPath)) . ')';
        }
        
        echo '<br>';
        
        // Recursively list subdirectories
        if ($isDir && $level < $maxLevel) {
            listDirectory($fullPath, $level + 1, $maxLevel);
        }
    }
}

function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    
    for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
        $bytes /= 1024;
    }
    
    return round($bytes, $precision) . ' ' . $units[$i];
}

// Current directory info
echo "<h3>📍 Current Location:</h3>";
echo "Script location: " . __FILE__ . "<br>";
echo "Current directory: " . __DIR__ . "<br>";
echo "Parent directory: " . dirname(__DIR__) . "<br>";
echo "Server root: " . $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown' . "<br><br>";

// Check common hosting structures
echo "<h3>🔍 Common Laravel Deployment Patterns:</h3>";

$patterns = [
    [
        'name' => 'Standard cPanel Structure',
        'public' => '/home/username/public_html/',
        'laravel' => '/home/username/laravel_app/',
        'description' => 'Laravel app outside web root, public files in public_html'
    ],
    [
        'name' => 'Subdirectory Deployment',
        'public' => '/home/username/public_html/myapp/',
        'laravel' => '/home/username/public_html/myapp/',
        'description' => 'Entire Laravel app in public_html subdirectory'
    ],
    [
        'name' => 'Root Deployment',
        'public' => '/home/username/public_html/',
        'laravel' => '/home/username/public_html/',
        'description' => 'Laravel app directly in public_html (less secure)'
    ]
];

foreach ($patterns as $pattern) {
    echo "<h4>" . $pattern['name'] . "</h4>";
    echo "Description: " . $pattern['description'] . "<br>";
    echo "Public files: " . $pattern['public'] . "<br>";
    echo "Laravel app: " . $pattern['laravel'] . "<br><br>";
}

// List current directory structure
echo "<h3>📂 Your Current Directory Structure:</h3>";
echo "<strong>Starting from: " . dirname(__DIR__) . "</strong><br><br>";
listDirectory(dirname(__DIR__));

// Check for Laravel indicators
echo "<h3>🔍 Laravel Detection:</h3>";
$laravelIndicators = [
    dirname(__DIR__) . '/artisan',
    dirname(__DIR__) . '/composer.json',
    dirname(__DIR__) . '/vendor/autoload.php',
    dirname(__DIR__) . '/app/Http/Kernel.php',
    dirname(__DIR__) . '/bootstrap/app.php',
    dirname(__DIR__) . '/laravel_app/artisan',
    dirname(__DIR__) . '/laravel_app/composer.json',
    dirname(__DIR__) . '/laravel_app/vendor/autoload.php',
    dirname(__DIR__) . '/xeddo/artisan',
    dirname(__DIR__) . '/xeddo/vendor/autoload.php',
];

foreach ($laravelIndicators as $indicator) {
    if (file_exists($indicator)) {
        echo "✅ <strong>Found Laravel indicator:</strong> " . $indicator . "<br>";
    }
}

echo "<br><h3>💡 Next Steps:</h3>";
echo "1. Identify where your Laravel app is located from the directory listing above<br>";
echo "2. Update your index.php to point to the correct Laravel location<br>";
echo "3. Ensure the vendor/autoload.php and bootstrap/app.php paths are correct<br>";

echo "<br><p><strong>🗑️ Note:</strong> Delete this file after checking for security.</p>";
?>
