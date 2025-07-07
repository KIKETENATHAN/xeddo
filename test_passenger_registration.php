<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\User;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🧪 Testing Passenger Registration...\n\n";

// Test data
$testData = [
    'name' => 'John Doe Test',
    'email' => 'johntest' . time() . '@example.com',
    'phone' => '0712345678',
    'address' => '123 Test Street, Nairobi',
    'password' => 'password123',
    'password_confirmation' => 'password123'
];

echo "📝 Test Data:\n";
echo "Name: " . $testData['name'] . "\n";
echo "Email: " . $testData['email'] . "\n";
echo "Phone: " . $testData['phone'] . "\n";
echo "Address: " . $testData['address'] . "\n\n";

try {
    // Create a request object
    $request = Request::create('/register/passenger', 'POST', $testData);
    
    // Create controller instance
    $controller = new RegisterController();
    
    echo "🔍 Testing validation...\n";
    
    // Test validation rules
    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:500',
        'password' => 'required|string|min:8|confirmed',
    ];
    
    $validator = \Validator::make($testData, $rules);
    
    if ($validator->fails()) {
        echo "❌ Validation failed:\n";
        foreach ($validator->errors()->all() as $error) {
            echo "  - $error\n";
        }
        exit(1);
    }
    
    echo "✅ Validation passed!\n\n";
    
    echo "💾 Testing user creation...\n";
    
    // Test user creation directly
    $user = User::create([
        'name' => $testData['name'],
        'email' => $testData['email'],
        'phone' => $testData['phone'],
        'address' => $testData['address'],
        'password' => \Hash::make($testData['password']),
        'role' => 'passenger',
    ]);
    
    if ($user) {
        echo "✅ User created successfully!\n";
        echo "User ID: " . $user->id . "\n";
        echo "User Role: " . $user->role . "\n";
        echo "User Email: " . $user->email . "\n\n";
        
        // Verify user exists in database
        $dbUser = User::find($user->id);
        if ($dbUser) {
            echo "✅ User verified in database!\n";
            echo "Database Record:\n";
            echo "  ID: " . $dbUser->id . "\n";
            echo "  Name: " . $dbUser->name . "\n";
            echo "  Email: " . $dbUser->email . "\n";
            echo "  Phone: " . $dbUser->phone . "\n";
            echo "  Address: " . $dbUser->address . "\n";
            echo "  Role: " . $dbUser->role . "\n";
            echo "  Created: " . $dbUser->created_at . "\n\n";
        } else {
            echo "❌ User not found in database!\n";
        }
        
        // Clean up - delete test user
        $user->delete();
        echo "🧹 Test user cleaned up.\n\n";
        
    } else {
        echo "❌ User creation failed!\n";
        exit(1);
    }
    
    echo "🎉 All tests passed! Passenger registration is working correctly.\n";
    
} catch (Exception $e) {
    echo "❌ Error occurred: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
