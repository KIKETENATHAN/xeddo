<?php

namespace App\Http\Controllers\Passenger;

use App\Http\Controllers\Controller;
use App\Models\PassengerProfile;
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

        return view('passenger.dashboard', compact('passengerProfile', 'stats'));
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
}
