<?php

namespace App\Http\Controllers\Passenger;

use App\Http\Controllers\Controller;
use App\Models\PassengerProfile;
use App\Models\Sacco;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $passengerProfile = $user->passengerProfile;
        
        if (!$passengerProfile) {
            $passengerProfile = $user->passengerProfile()->create([]);
        }

        $stats = [
            'total_trips' => $passengerProfile->total_trips,
            'rating' => $passengerProfile->rating,
        ];

        // Get active SACCOs for booking
        $saccos = Sacco::where('is_active', true)->get();

        return view('passenger.dashboard', compact('passengerProfile', 'stats', 'saccos'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'preferences' => 'nullable|string',
        ]);

        Auth::user()->passengerProfile()->updateOrCreate(
            ['user_id' => Auth::id()],
            $request->all()
        );

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function searchRides(Request $request)
    {
        // If it's a GET request, redirect to dashboard
        if ($request->isMethod('get')) {
            return redirect()->route('passenger.dashboard');
        }

        $request->validate([
            'pickup' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'travel_time' => 'required|date|after:now',
        ]);

        $user = Auth::user();
        $passengerProfile = $user->passengerProfile;
        
        if (!$passengerProfile) {
            $passengerProfile = $user->passengerProfile()->create([]);
        }

        $stats = [
            'total_trips' => $passengerProfile->total_trips,
            'rating' => $passengerProfile->rating,
        ];

        // Get active SACCOs for display
        $saccos = Sacco::where('is_active', true)->get();

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
            ->whereDate('departure_time', '>=', date('Y-m-d', strtotime($request->travel_time)))
            ->where('departure_time', '>=', $request->travel_time)
            ->orderBy('departure_time')
            ->get();

        // Keep search parameters for the form
        $searchParams = [
            'pickup' => $request->pickup,
            'destination' => $request->destination,
            'travel_time' => $request->travel_time,
        ];

        return view('passenger.dashboard', compact('passengerProfile', 'stats', 'saccos', 'trips', 'searchParams'));
    }

    public function bookRide(Request $request, Trip $trip)
    {
        // Check if trip is still available
        if ($trip->status !== 'scheduled' || $trip->remaining_seats <= 0) {
            return redirect()->back()->with('error', 'This trip is no longer available for booking.');
        }

        // Check if trip is in the future
        if ($trip->departure_time <= now()) {
            return redirect()->back()->with('error', 'Cannot book a trip that has already departed.');
        }

        // For now, just increment booked seats
        // In a real application, you would create a booking record
        $trip->increment('booked_seats');

        return redirect()->back()->with('success', 'Ride booked successfully! You will receive confirmation details soon.');
    }
}
