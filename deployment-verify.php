<?php
/**
 * Deployment Verification Script
 * Upload this file to your public_html directory and access it via browser
 * to verify your deployment status
 */

echo "<h1>🚀 Xeddolink Deployment Verification</h1>";
echo "<hr>";

// Check Laravel installation
echo "<h2>📋 Laravel Installation Check</h2>";
if (file_exists('../bootstrap/app.php')) {
    echo "✅ Laravel bootstrap found<br>";
} else {
    echo "❌ Laravel bootstrap NOT found<br>";
}

if (file_exists('../vendor/autoload.php')) {
    echo "✅ Composer autoload found<br>";
} else {
    echo "❌ Composer autoload NOT found<br>";
}

// Check environment
echo "<h2>🔧 Environment Check</h2>";
if (file_exists('../.env')) {
    echo "✅ Environment file found<br>";
} else {
    echo "❌ Environment file NOT found<br>";
}

// Check current timestamp
echo "<h2>📅 Deployment Timestamp</h2>";
echo "Current server time: " . date('Y-m-d H:i:s') . "<br>";
echo "File modification time: " . date('Y-m-d H:i:s', filemtime(__FILE__)) . "<br>";

// Check file permissions
echo "<h2>🔐 File Permissions</h2>";
$paths = [
    '../bootstrap/cache',
    '../storage/logs',
    '../storage/framework',
    '../storage/app'
];

foreach ($paths as $path) {
    if (is_dir($path)) {
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        echo "📁 $path: $perms<br>";
    } else {
        echo "❌ $path: Directory not found<br>";
    }
}

// Test database connection (if Laravel is accessible)
echo "<h2>🗄️ Database Connection</h2>";
try {
    if (file_exists('../vendor/autoload.php')) {
        require_once '../vendor/autoload.php';
        
        if (file_exists('../bootstrap/app.php')) {
            $app = require_once '../bootstrap/app.php';
            
            // Try to get Laravel version
            echo "✅ Laravel application loaded<br>";
            echo "Laravel Version: " . app()->version() . "<br>";
            
            // Test database connection
            try {
                $pdo = new PDO(
                    "mysql:host=" . env('DB_HOST') . ";dbname=" . env('DB_DATABASE'),
                    env('DB_USERNAME'),
                    env('DB_PASSWORD')
                );
                echo "✅ Database connection successful<br>";
            } catch (Exception $e) {
                echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
            }
        }
    }
} catch (Exception $e) {
    echo "❌ Laravel loading failed: " . $e->getMessage() . "<br>";
}

// Show PHP info
echo "<h2>🐘 PHP Information</h2>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "Server: " . $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown' . "<br>";

echo "<hr>";
echo "<p><strong>📝 Instructions:</strong></p>";
echo "<ul>";
echo "<li>Upload this file to your public_html directory</li>";
echo "<li>Access it via: https://yourdomain.com/deployment-verify.php</li>";
echo "<li>Check all items show ✅ green checkmarks</li>";
echo "<li>Delete this file after verification for security</li>";
echo "</ul>";
?>
