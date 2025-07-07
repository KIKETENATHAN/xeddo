<?php
// Simple test script to check if trips exist in database and test the API

require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use App\Models\Trip;
use App\Models\Sacco;
use App\Models\DriverProfile;
use App\Models\User;

// Check if there are any trips in the database
$tripCount = Trip::count();
echo "Total trips in database: " . $tripCount . "\n";

if ($tripCount > 0) {
    echo "\nFirst 5 trips:\n";
    $trips = Trip::with(['driver.user', 'sacco'])
        ->take(5)
        ->get();
    
    foreach ($trips as $trip) {
        echo "ID: {$trip->id}, From: {$trip->from_location}, To: {$trip->to_location}, Status: {$trip->status}, Departure: {$trip->departure_time}\n";
    }
} else {
    echo "No trips found. Creating sample data...\n";
    
    // Check if we have users and SACCOs
    $saccoCount = Sacco::count();
    $driverCount = DriverProfile::count();
    
    echo "SACCOs: $saccoCount, Drivers: $driverCount\n";
    
    if ($saccoCount > 0 && $driverCount > 0) {
        $sacco = Sacco::first();
        $driver = DriverProfile::first();
        
        // Create a sample trip
        Trip::create([
            'driver_id' => $driver->id,
            'sacco_id' => $sacco->id,
            'from_location' => 'Nairobi CBD',
            'to_location' => 'Westlands',
            'departure_time' => now()->addHours(2),
            'estimated_arrival_time' => now()->addHours(3),
            'amount' => 150.00,
            'status' => 'scheduled',
            'available_seats' => 4,
            'booked_seats' => 0,
            'notes' => 'Test trip'
        ]);
        
        echo "Sample trip created!\n";
    }
}

// Test the search logic
echo "\nTesting search logic:\n";
$searchTrips = Trip::with(['driver.user', 'sacco'])
    ->where('status', 'scheduled')
    ->where('available_seats', '>', 0)
    ->where(function ($query) {
        $query->where('from_location', 'LIKE', '%Nairobi%')
              ->orWhere('from_location', 'LIKE', '%nairobi%');
    })
    ->where(function ($query) {
        $query->where('to_location', 'LIKE', '%West%')
              ->orWhere('to_location', 'LIKE', '%west%');
    })
    ->get();

echo "Search results: " . $searchTrips->count() . "\n";
foreach ($searchTrips as $trip) {
    echo "Found: {$trip->from_location} to {$trip->to_location}\n";
}
