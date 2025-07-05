<?php

namespace Database\Seeders;

use App\Models\Sacco;
use Illuminate\Database\Seeder;

class SaccoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $saccos = [
            [
                'name' => 'Nairobi City Express',
                'phone_number' => '+254712345678',
                'location' => 'Nairobi CBD',
                'route_from' => 'Nairobi',
                'route_to' => 'Mombasa',
                'description' => 'Express transport service between Nairobi and Mombasa',
                'is_active' => true,
            ],
            [
                'name' => 'Kisumu Transport Co-op',
                'phone_number' => '+254723456789',
                'location' => 'Kisumu',
                'route_from' => 'Kisumu',
                'route_to' => 'Eldoret',
                'description' => 'Regional transport cooperative serving western Kenya',
                'is_active' => true,
            ],
            [
                'name' => 'Nakuru SACCO',
                'phone_number' => '+254734567890',
                'location' => 'Nakuru',
                'route_from' => 'Nakuru',
                'route_to' => 'Nairobi',
                'description' => 'Reliable transport service from Nakuru to Nairobi',
                'is_active' => true,
            ],
            [
                'name' => 'Mombasa Coast Shuttle',
                'phone_number' => '+254745678901',
                'location' => 'Mombasa',
                'route_from' => 'Mombasa',
                'route_to' => 'Malindi',
                'description' => 'Coastal transport service',
                'is_active' => true,
            ],
        ];

        foreach ($saccos as $sacco) {
            Sacco::create($sacco);
        }
    }
}
