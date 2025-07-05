<?php
/**
 * Migration Script for Shared Hosting
 * Access this file via browser: yourdomain.com/migrate.php
 * Delete this file after running migrations for security
 */

// Only allow access from specific IP (optional - replace with your IP)
// $allowedIPs = ['your.ip.address.here'];
// if (!in_array($_SERVER['REMOTE_ADDR'], $allowedIPs)) {
//     die('Access denied');
// }

// Simple password protection (change this password)
$password = 'your_secure_password_here';
if (!isset($_GET['password']) || $_GET['password'] !== $password) {
    die('Invalid password. Access via: yourdomain.com/migrate.php?password=your_secure_password_here');
}

// Include Laravel's autoloader
require_once '../laravel_app/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once '../laravel_app/bootstrap/app.php';

// Create kernel
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "<h2>Running Laravel Migrations</h2>";
echo "<pre>";

try {
    // Run migrations
    $kernel->call('migrate', ['--force' => true]);
    echo "✅ Migrations completed successfully!\n";
    
    // Run seeders (optional)
    if (isset($_GET['seed'])) {
        $kernel->call('db:seed', ['--force' => true]);
        echo "✅ Database seeded successfully!\n";
    }
    
    // Clear and cache config
    $kernel->call('config:cache');
    $kernel->call('route:cache');
    $kernel->call('view:cache');
    echo "✅ Application optimized for production!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "</pre>";
echo "<p><strong>Important:</strong> Delete this file after running migrations for security!</p>";
?>
