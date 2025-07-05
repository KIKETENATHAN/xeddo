<?php
// Alternative index.php configurations for different hosting structures

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// OPTION 1: Laravel app in /home/username/xeddo/
if (file_exists($maintenance = __DIR__.'/../xeddo/storage/framework/maintenance.php')) {
    require $maintenance;
}
require __DIR__.'/../xeddo/vendor/autoload.php';
$app = require_once __DIR__.'/../xeddo/bootstrap/app.php';

/* 
// OPTION 2: Laravel app in same directory as public_html
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

// OPTION 3: Laravel app in public_html subdirectory
if (file_exists($maintenance = __DIR__.'/laravel/storage/framework/maintenance.php')) {
    require $maintenance;
}
require __DIR__.'/laravel/vendor/autoload.php';
$app = require_once __DIR__.'/laravel/bootstrap/app.php';
*/

$app->handleRequest(Request::capture());
?>
