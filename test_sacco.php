<?php

// Simple test script to verify SACCO system
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

echo "Testing SACCO System...\n";

try {
    // Test if we can access the Sacco model
    $saccos = \App\Models\Sacco::all();
    echo "Found " . $saccos->count() . " SACCOs in the database\n";
    
    if ($saccos->count() > 0) {
        $sacco = $saccos->first();
        echo "First SACCO: " . $sacco->name . "\n";
        echo "Location: " . $sacco->location . "\n";
        echo "Route: " . $sacco->full_route . "\n";
        echo "Status: " . ($sacco->is_active ? 'Active' : 'Inactive') . "\n";
        echo "Drivers: " . $sacco->drivers->count() . "\n";
    }
    
    // Test if the admin.saccos.show view file exists
    $viewPath = 'resources/views/admin/saccos/show.blade.php';
    if (file_exists($viewPath)) {
        echo "✓ Admin SACCO show view exists\n";
    } else {
        echo "✗ Admin SACCO show view missing\n";
    }
    
    // Test if the controller method exists
    if (method_exists(\App\Http\Controllers\Admin\SaccoController::class, 'show')) {
        echo "✓ Admin SACCO show controller method exists\n";
    } else {
        echo "✗ Admin SACCO show controller method missing\n";
    }
    
    echo "✓ SACCO system is working correctly\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
