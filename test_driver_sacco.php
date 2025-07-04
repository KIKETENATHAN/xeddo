<?php

// Test SACCO-Driver connection
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class)->bootstrap();

echo "Testing Driver-SACCO Connection...\n";

try {
    // Get all drivers with their SACCOs
    $drivers = \App\Models\DriverProfile::with(['user', 'sacco'])->get();
    
    echo "Found " . $drivers->count() . " drivers\n";
    
    foreach ($drivers as $driver) {
        echo "\nDriver: " . $driver->user->name . "\n";
        echo "Status: " . $driver->status . "\n";
        if ($driver->sacco) {
            echo "SACCO: " . $driver->sacco->name . "\n";
            echo "Route: " . $driver->sacco->full_route . "\n";
        } else {
            echo "SACCO: Not assigned\n";
        }
        echo "Vehicle: " . $driver->vehicle_year . " " . $driver->vehicle_make . " " . $driver->vehicle_model . "\n";
    }
    
    echo "\n✓ Driver-SACCO connection test completed successfully\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
