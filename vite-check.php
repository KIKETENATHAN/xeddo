<?php
/**
 * Vite Manifest Checker
 * Upload this to your public_html folder and access via browser
 * to verify Vite assets are properly deployed
 */

echo "<h2>🔍 Vite Manifest Checker</h2>";

// Check if manifest.json exists
$manifestPath = __DIR__ . '/build/manifest.json';
echo "<h3>Manifest File Check:</h3>";

if (file_exists($manifestPath)) {
    echo "✅ <strong>SUCCESS:</strong> manifest.json found at: " . $manifestPath . "<br>";
    
    // Read and display manifest content
    $manifest = json_decode(file_get_contents($manifestPath), true);
    echo "<pre>";
    print_r($manifest);
    echo "</pre>";
    
    // Check individual assets
    echo "<h3>Asset Files Check:</h3>";
    foreach ($manifest as $key => $asset) {
        $assetPath = __DIR__ . '/build/' . $asset['file'];
        if (file_exists($assetPath)) {
            echo "✅ <strong>Found:</strong> " . $asset['file'] . " (" . formatBytes(filesize($assetPath)) . ")<br>";
        } else {
            echo "❌ <strong>Missing:</strong> " . $asset['file'] . "<br>";
        }
    }
    
} else {
    echo "❌ <strong>ERROR:</strong> manifest.json not found at: " . $manifestPath . "<br>";
    echo "<br><strong>📋 Required Actions:</strong><br>";
    echo "1. Upload your 'public/build/' folder to 'public_html/build/'<br>";
    echo "2. Ensure file permissions are correct (755 for folders, 644 for files)<br>";
    echo "3. Verify the build folder structure matches your local setup<br>";
}

// Check Laravel app path
echo "<h3>Laravel App Check:</h3>";
$laravelPath = dirname(__DIR__) . '/laravel_app/vendor/autoload.php';
if (file_exists($laravelPath)) {
    echo "✅ <strong>SUCCESS:</strong> Laravel app found<br>";
} else {
    echo "❌ <strong>ERROR:</strong> Laravel app not found. Expected at: " . dirname(__DIR__) . "/laravel_app/<br>";
    
    // Additional diagnostic checks
    echo "<h4>🔍 Diagnostic Information:</h4>";
    echo "Current script location: " . __FILE__ . "<br>";
    echo "Parent directory: " . dirname(__DIR__) . "<br>";
    echo "Looking for Laravel at: " . $laravelPath . "<br><br>";
    
    // Check common Laravel locations
    $possiblePaths = [
        dirname(__DIR__) . '/xeddo/vendor/autoload.php',
        dirname(__DIR__) . '/laravel/vendor/autoload.php',
        dirname(__DIR__) . '/app/vendor/autoload.php',
        dirname(__DIR__) . '/public_html/../vendor/autoload.php',
        __DIR__ . '/../vendor/autoload.php',
        '/home/xeddotra/vendor/autoload.php',
        '/home/xeddotra/xeddo/vendor/autoload.php',
    ];
    
    echo "<h4>🔍 Checking possible Laravel locations:</h4>";
    foreach ($possiblePaths as $path) {
        if (file_exists($path)) {
            echo "✅ <strong>FOUND:</strong> " . $path . "<br>";
        } else {
            echo "❌ Not found: " . $path . "<br>";
        }
    }
    
    // List directory contents
    echo "<h4>📁 Directory Contents:</h4>";
    $parentDir = dirname(__DIR__);
    if (is_dir($parentDir)) {
        echo "<strong>Contents of: " . $parentDir . "</strong><br>";
        $contents = scandir($parentDir);
        foreach ($contents as $item) {
            if ($item !== '.' && $item !== '..') {
                $fullPath = $parentDir . '/' . $item;
                $type = is_dir($fullPath) ? '[DIR]' : '[FILE]';
                echo $type . " " . $item . "<br>";
            }
        }
    }
}

// Environment check
echo "<h3>Environment Info:</h3>";
echo "Current directory: " . __DIR__ . "<br>";
echo "PHP version: " . phpversion() . "<br>";
echo "Server: " . $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' . "<br>";

function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    
    for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
        $bytes /= 1024;
    }
    
    return round($bytes, $precision) . ' ' . $units[$i];
}

echo "<br><p><strong>💡 Note:</strong> Delete this file after verification for security.</p>";
?>
