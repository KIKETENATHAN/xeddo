<?php
// Simple deployment verification script
echo "<h2>🔍 Deployment Verification</h2>";
echo "<p><strong>Current Location:</strong> " . __FILE__ . "</p>";
echo "<p><strong>Current Directory:</strong> " . __DIR__ . "</p>";
echo "<p><strong>Document Root:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "</p>";
echo "<p><strong>Server Name:</strong> " . ($_SERVER['SERVER_NAME'] ?? 'Unknown') . "</p>";
echo "<p><strong>Request URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'Unknown') . "</p>";
echo "<p><strong>Script Name:</strong> " . ($_SERVER['SCRIPT_NAME'] ?? 'Unknown') . "</p>";

echo "<h3>📁 Directory Contents</h3>";
$files = scandir(__DIR__);
foreach ($files as $file) {
    if ($file !== '.' && $file !== '..') {
        echo "• " . $file . (is_dir(__DIR__ . '/' . $file) ? ' (directory)' : ' (file)') . "<br>";
    }
}

echo "<h3>🔍 Looking for Laravel App</h3>";
$laravel_paths = [
    '../laravel_app',
    './laravel_app', 
    '../xeddo',
    './xeddo'
];

foreach ($laravel_paths as $path) {
    $full_path = __DIR__ . '/' . $path;
    echo "Checking: " . $path . " → ";
    if (is_dir($full_path)) {
        echo "✅ EXISTS<br>";
        if (file_exists($full_path . '/vendor/autoload.php')) {
            echo "&nbsp;&nbsp;✅ vendor/autoload.php found<br>";
        } else {
            echo "&nbsp;&nbsp;❌ vendor/autoload.php missing<br>";
        }
    } else {
        echo "❌ NOT FOUND<br>";
    }
}

echo "<p><strong>Time:</strong> " . date('Y-m-d H:i:s') . "</p>";
?>
