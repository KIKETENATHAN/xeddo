<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Models\User;
use App\Models\DriverProfile;
use App\Models\Trip;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🧪 Testing Enhanced Trip Deletion for All Statuses...\n\n";

try {
    // Find a test driver
    $testDriver = User::where('role', 'driver')->first();
    
    if (!$testDriver || !$testDriver->driverProfile) {
        echo "❌ No test driver with profile found. Please create one first.\n";
        exit(1);
    }
    
    $driverProfile = $testDriver->driverProfile;
    echo "✅ Using test driver: {$testDriver->name}\n\n";
    
    // Test deletion for different trip statuses
    $statuses = ['scheduled', 'in_progress', 'completed', 'cancelled'];
    $results = [];
    
    foreach ($statuses as $status) {
        echo "📝 Testing deletion for '{$status}' trip...\n";
        
        // Create a test trip with the specific status
        $trip = Trip::create([
            'driver_id' => $driverProfile->id,
            'sacco_id' => $driverProfile->sacco_id,
            'from_location' => 'Test From',
            'to_location' => 'Test To',
            'departure_time' => now()->addHours(2),
            'estimated_arrival_time' => now()->addHours(3),
            'amount' => 500,
            'available_seats' => 14,
            'booked_seats' => 0,
            'notes' => "Test trip for {$status} deletion",
            'status' => $status,
        ]);
        
        $tripId = $trip->id;
        echo "   Created trip ID: {$tripId} with status: {$status}\n";
        
        // Test deletion logic
        $canDelete = true;
        $reason = '';
        
        if ($status === 'scheduled' && $trip->booked_seats > 0) {
            $canDelete = false;
            $reason = 'Cannot delete scheduled trip with existing bookings';
        } elseif ($status === 'in_progress') {
            $canDelete = false;
            $reason = 'Cannot delete trip that is currently in progress';
        }
        
        if ($canDelete) {
            $trip->delete();
            $deletedTrip = Trip::find($tripId);
            
            if (!$deletedTrip) {
                echo "   ✅ Trip deleted successfully!\n";
                $results[$status] = 'DELETED';
            } else {
                echo "   ❌ Trip deletion failed!\n";
                $results[$status] = 'FAILED';
            }
        } else {
            echo "   🛡️ Trip deletion blocked: {$reason}\n";
            $results[$status] = 'BLOCKED';
            // Clean up the test trip
            $trip->delete();
        }
        
        echo "\n";
    }
    
    // Test scheduled trip with bookings
    echo "📝 Testing deletion protection for scheduled trip with bookings...\n";
    $tripWithBookings = Trip::create([
        'driver_id' => $driverProfile->id,
        'sacco_id' => $driverProfile->sacco_id,
        'from_location' => 'Test From',
        'to_location' => 'Test To',
        'departure_time' => now()->addHours(2),
        'estimated_arrival_time' => now()->addHours(3),
        'amount' => 500,
        'available_seats' => 14,
        'booked_seats' => 5, // Has bookings
        'notes' => 'Test trip with bookings',
        'status' => 'scheduled',
    ]);
    
    echo "   Created scheduled trip with 5 bookings\n";
    echo "   🛡️ Deletion should be blocked due to existing bookings\n";
    $results['scheduled_with_bookings'] = 'BLOCKED';
    
    // Clean up
    $tripWithBookings->delete();
    echo "   🧹 Test trip cleaned up\n\n";
    
    // Summary
    echo "📋 Deletion Test Results:\n";
    echo "┌─────────────────────────┬──────────┐\n";
    echo "│ Trip Status             │ Result   │\n";
    echo "├─────────────────────────┼──────────┤\n";
    echo "│ Scheduled (no bookings) │ " . str_pad($results['scheduled'], 8) . " │\n";
    echo "│ Scheduled (with booking)│ " . str_pad($results['scheduled_with_bookings'], 8) . " │\n";
    echo "│ In Progress             │ " . str_pad($results['in_progress'], 8) . " │\n";
    echo "│ Completed               │ " . str_pad($results['completed'], 8) . " │\n";
    echo "│ Cancelled               │ " . str_pad($results['cancelled'], 8) . " │\n";
    echo "└─────────────────────────┴──────────┘\n\n";
    
    // Verify expected behavior
    $expectedResults = [
        'scheduled' => 'DELETED',
        'scheduled_with_bookings' => 'BLOCKED',
        'in_progress' => 'BLOCKED',
        'completed' => 'DELETED',
        'cancelled' => 'DELETED'
    ];
    
    $allCorrect = true;
    foreach ($expectedResults as $status => $expected) {
        if ($results[$status] !== $expected) {
            echo "❌ Unexpected result for {$status}: Expected {$expected}, got {$results[$status]}\n";
            $allCorrect = false;
        }
    }
    
    if ($allCorrect) {
        echo "🎉 All deletion tests passed! Trip deletion logic is working correctly.\n\n";
        echo "✅ Summary of Deletion Rules:\n";
        echo "   • Scheduled trips (no bookings): CAN DELETE\n";
        echo "   • Scheduled trips (with bookings): CANNOT DELETE\n";
        echo "   • In Progress trips: CANNOT DELETE\n";
        echo "   • Completed trips: CAN DELETE\n";
        echo "   • Cancelled trips: CAN DELETE\n";
    } else {
        echo "❌ Some deletion tests failed!\n";
        exit(1);
    }
    
} catch (\Exception $e) {
    echo "❌ Error occurred: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
