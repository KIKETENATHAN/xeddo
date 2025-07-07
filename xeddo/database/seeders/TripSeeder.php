<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\DriverProfile;
use App\Models\Sacco;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first sacco and driver to create test trips
        $sacco = Sacco::first();
        $driver = DriverProfile::first();

        if (!$sacco || !$driver) {
            $this->command->info('No SACCO or Driver found. Please run SaccoSeeder first and create a driver.');
            return;
        }

        $trips = [
            [
                'driver_id' => $driver->id,
                'sacco_id' => $sacco->id,
                'from_location' => 'Nairobi CBD',
                'to_location' => 'Westlands',
                'departure_time' => Carbon::now()->addHours(2),
                'estimated_arrival_time' => Carbon::now()->addHours(2)->addMinutes(30),
                'amount' => 50.00,
                'status' => 'scheduled',
                'available_seats' => 14,
                'booked_seats' => 0,
                'notes' => 'Express route via Uhuru Highway',
            ],
            [
                'driver_id' => $driver->id,
                'sacco_id' => $sacco->id,
                'from_location' => 'Westlands',
                'to_location' => 'Nairobi CBD',
                'departure_time' => Carbon::now()->addHours(4),
                'estimated_arrival_time' => Carbon::now()->addHours(4)->addMinutes(30),
                'amount' => 50.00,
                'status' => 'scheduled',
                'available_seats' => 14,
                'booked_seats' => 2,
                'notes' => 'Return trip via Uhuru Highway',
            ],
            [
                'driver_id' => $driver->id,
                'sacco_id' => $sacco->id,
                'from_location' => 'Nairobi CBD',
                'to_location' => 'Karen',
                'departure_time' => Carbon::now()->addHours(6),
                'estimated_arrival_time' => Carbon::now()->addHours(6)->addMinutes(45),
                'amount' => 80.00,
                'status' => 'scheduled',
                'available_seats' => 14,
                'booked_seats' => 1,
                'notes' => 'Route via Langata Road',
            ],
            [
                'driver_id' => $driver->id,
                'sacco_id' => $sacco->id,
                'from_location' => 'Karen',
                'to_location' => 'Nairobi CBD',
                'departure_time' => Carbon::now()->addHours(8),
                'estimated_arrival_time' => Carbon::now()->addHours(8)->addMinutes(45),
                'amount' => 80.00,
                'status' => 'scheduled',
                'available_seats' => 14,
                'booked_seats' => 0,
                'notes' => 'Return trip via Langata Road',
            ],
            [
                'driver_id' => $driver->id,
                'sacco_id' => $sacco->id,
                'from_location' => 'CBD',
                'to_location' => 'Eastlands',
                'departure_time' => Carbon::now()->addDay()->addHours(1),
                'estimated_arrival_time' => Carbon::now()->addDay()->addHours(1)->addMinutes(40),
                'amount' => 60.00,
                'status' => 'scheduled',
                'available_seats' => 14,
                'booked_seats' => 3,
                'notes' => 'Route via Outer Ring Road',
            ],
        ];

        foreach ($trips as $trip) {
            Trip::create($trip);
        }

        $this->command->info('Trip test data created successfully!');
    }
}
