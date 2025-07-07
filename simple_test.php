<?php
echo "<h1>Simple Test</h1>";
echo "<p>If you see this, files are being deployed correctly!</p>";
echo "<p>Current time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>File location: " . __FILE__ . "</p>";
echo "<p>Directory: " . __DIR__ . "</p>";

// Test if we can see the Laravel app
echo "<h2>Laravel App Check</h2>";
$laravel_path = __DIR__ . '/../xeddo';
if (is_dir($laravel_path)) {
    echo "✅ Laravel app directory found at: " . $laravel_path . "<br>";
    if (file_exists($laravel_path . '/vendor/autoload.php')) {
        echo "✅ vendor/autoload.php exists<br>";
    } else {
        echo "❌ vendor/autoload.php missing<br>";
    }
    if (file_exists($laravel_path . '/.env')) {
        echo "✅ .env file exists<br>";
    } else {
        echo "❌ .env file missing<br>";
    }
} else {
    echo "❌ Laravel app directory not found<br>";
}
?>
