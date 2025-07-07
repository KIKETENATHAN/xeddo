<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sacco;
use App\Models\Trip;
use Illuminate\Http\Request;

class RideSearchController extends Controller
{
    public function getSaccos()
    {
        $saccos = Sacco::where('is_active', true)->get();
        return response()->json($saccos);
    }

    public function searchRides(Request $request)
    {
        \Log::info('Search request received', $request->all());
        
        $request->validate([
            'pickup' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'travel_time' => 'required|date',
        ]);

        \Log::info('Validation passed');

        // Search for available trips across all SACCOs
        $trips = Trip::with(['driver.user', 'sacco'])
            ->where('status', 'scheduled')
            ->where('available_seats', '>', 0)
            ->where(function ($query) use ($request) {
                $query->where('from_location', 'LIKE', '%' . $request->pickup . '%')
                      ->orWhere('from_location', 'LIKE', '%' . strtolower($request->pickup) . '%');
            })
            ->where(function ($query) use ($request) {
                $query->where('to_location', 'LIKE', '%' . $request->destination . '%')
                      ->orWhere('to_location', 'LIKE', '%' . strtolower($request->destination) . '%');
            })
            ->where('departure_time', '>=', $request->travel_time)
            ->orderBy('departure_time')
            ->get();

        \Log::info('Query completed', ['count' => $trips->count()]);

        // Add remaining seats and formatted amount to each trip
        $trips->transform(function ($trip) {
            $trip->remaining_seats = $trip->available_seats - $trip->booked_seats;
            $trip->formatted_amount = 'KSH ' . number_format((float) $trip->amount, 2);
            return $trip;
        });

        return response()->json([
            'success' => true,
            'trips' => $trips,
            'count' => $trips->count()
        ]);
    }
}
