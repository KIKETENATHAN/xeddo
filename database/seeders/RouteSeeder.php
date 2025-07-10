<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Route;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routes = [
            [
                'from_location' => 'Nairobi CBD',
                'to_location' => 'Mombasa',
                'estimated_fare' => 1500.00,
                'estimated_duration_minutes' => 480,
                'description' => 'Direct route from Nairobi Central Business District to Mombasa city center.',
                'is_active' => true,
            ],
            [
                'from_location' => 'Nairobi CBD',
                'to_location' => 'Kisumu',
                'estimated_fare' => 800.00,
                'estimated_duration_minutes' => 300,
                'description' => 'Popular route from Nairobi to Kisumu city.',
                'is_active' => true,
            ],
            [
                'from_location' => 'Nairobi CBD',
                'to_location' => 'Nakuru',
                'estimated_fare' => 400.00,
                'estimated_duration_minutes' => 120,
                'description' => 'Regular route to Nakuru town.',
                'is_active' => true,
            ],
            [
                'from_location' => 'Mombasa',
                'to_location' => 'Malindi',
                'estimated_fare' => 300.00,
                'estimated_duration_minutes' => 90,
                'description' => 'Coastal route from Mombasa to Malindi.',
                'is_active' => true,
            ],
            [
                'from_location' => 'Nairobi CBD',
                'to_location' => 'Eldoret',
                'estimated_fare' => 600.00,
                'estimated_duration_minutes' => 240,
                'description' => 'Route to Eldoret town via Nakuru.',
                'is_active' => true,
            ],
            [
                'from_location' => 'Kisumu',
                'to_location' => 'Kakamega',
                'estimated_fare' => 200.00,
                'estimated_duration_minutes' => 60,
                'description' => 'Short route between western Kenya towns.',
                'is_active' => true,
            ],
            [
                'from_location' => 'Nairobi CBD',
                'to_location' => 'Machakos',
                'estimated_fare' => 150.00,
                'estimated_duration_minutes' => 45,
                'description' => 'Short route to Machakos town.',
                'is_active' => false,
            ],
        ];

        foreach ($routes as $routeData) {
            Route::create($routeData);
        }
    }
}
