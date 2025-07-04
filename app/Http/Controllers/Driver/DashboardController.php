<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\DriverProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $driverProfile = $user->driverProfile;
        
        if (!$driverProfile) {
            return redirect()->route('driver.profile.create');
        }

        // Load the SACCO relationship
        $driverProfile->load('sacco');

        $stats = [
            'total_trips' => $driverProfile->total_trips,
            'rating' => $driverProfile->rating,
            'status' => $driverProfile->status,
            'is_available' => $driverProfile->is_available,
        ];

        return view('driver.dashboard', compact('driverProfile', 'stats'));
    }

    public function createProfile()
    {
        return view('driver.profile.create');
    }

    public function storeProfile(Request $request)
    {
        $request->validate([
            'license_number' => 'required|string|unique:driver_profiles',
            'license_expiry' => 'required|date|after:today',
            'vehicle_type' => 'required|string',
            'vehicle_make' => 'required|string',
            'vehicle_model' => 'required|string',
            'vehicle_year' => 'required|integer|min:1980|max:' . (date('Y') + 1),
            'vehicle_plate_number' => 'required|string|unique:driver_profiles',
            'vehicle_color' => 'required|string',
            'vehicle_description' => 'nullable|string',
        ]);

        Auth::user()->driverProfile()->create($request->all());

        return redirect()->route('driver.dashboard')->with('success', 'Driver profile created successfully! Please wait for admin approval.');
    }

    public function toggleAvailability()
    {
        $driverProfile = Auth::user()->driverProfile;
        $driverProfile->update(['is_available' => !$driverProfile->is_available]);
        
        return redirect()->back()->with('success', 'Availability updated successfully!');
    }
}
