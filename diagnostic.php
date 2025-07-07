<?php
// Diagnostic script for Laravel on shared hosting
echo "<h2>Laravel Deployment Diagnostic</h2>";

echo "<h3>1. File Paths Check</h3>";
echo "Current directory: " . __DIR__ . "<br>";
echo "Laravel app path: " . __DIR__ . '/../laravel_app' . "<br>";

echo "<h3>2. Key Files Existence</h3>";
$files_to_check = [
    '../laravel_app/vendor/autoload.php',
    '../laravel_app/bootstrap/app.php',
    '../laravel_app/storage/framework/maintenance.php',
    '../laravel_app/.env',
    '../laravel_app/config/app.php'
];

foreach ($files_to_check as $file) {
    $full_path = __DIR__ . '/' . $file;
    echo $file . ": " . (file_exists($full_path) ? "✅ EXISTS" : "❌ MISSING") . "<br>";
}

echo "<h3>3. Directory Permissions</h3>";
$dirs_to_check = [
    '../laravel_app/storage',
    '../laravel_app/storage/logs',
    '../laravel_app/storage/framework',
    '../laravel_app/bootstrap/cache'
];

foreach ($dirs_to_check as $dir) {
    $full_path = __DIR__ . '/' . $dir;
    if (is_dir($full_path)) {
        echo $dir . ": ✅ EXISTS (Writable: " . (is_writable($full_path) ? "YES" : "NO") . ")<br>";
    } else {
        echo $dir . ": ❌ MISSING<br>";
    }
}

echo "<h3>4. Environment Check</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Current working directory: " . getcwd() . "<br>";

echo "<h3>5. Try Loading Laravel</h3>";
try {
    if (file_exists(__DIR__ . '/../laravel_app/vendor/autoload.php')) {
        require __DIR__ . '/../laravel_app/vendor/autoload.php';
        echo "✅ Autoloader loaded successfully<br>";
        
        if (file_exists(__DIR__ . '/../laravel_app/bootstrap/app.php')) {
            $app = require_once __DIR__ . '/../laravel_app/bootstrap/app.php';
            echo "✅ Laravel app loaded successfully<br>";
            echo "App Name: " . config('app.name', 'Not found') . "<br>";
            echo "App Environment: " . config('app.env', 'Not found') . "<br>";
        } else {
            echo "❌ bootstrap/app.php not found<br>";
        }
    } else {
        echo "❌ vendor/autoload.php not found<br>";
    }
} catch (Exception $e) {
    echo "❌ Error loading Laravel: " . $e->getMessage() . "<br>";
}

echo "<h3>6. Server Information</h3>";
echo "Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "<br>";
echo "Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "<br>";
echo "Script Name: " . ($_SERVER['SCRIPT_NAME'] ?? 'Unknown') . "<br>";
?>
