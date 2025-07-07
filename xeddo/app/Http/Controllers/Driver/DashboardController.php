<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\DriverProfile;
use App\Models\Sacco;
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

        // Get trip statistics
        $totalTrips = $driverProfile->trips()->count();
        $activeTrips = $driverProfile->trips()->whereIn('status', ['scheduled', 'in_progress'])->count();
        $completedTrips = $driverProfile->trips()->where('status', 'completed')->count();
        $totalEarnings = $driverProfile->trips()->where('status', 'completed')->sum('amount');

        $stats = [
            'total_trips' => $totalTrips,
            'active_trips' => $activeTrips,
            'completed_trips' => $completedTrips,
            'total_earnings' => $totalEarnings,
            'rating' => $driverProfile->rating,
            'status' => $driverProfile->status,
            'is_available' => $driverProfile->is_available,
        ];

        return view('driver.dashboard', compact('driverProfile', 'stats'));
    }

    public function createProfile()
    {
        $saccos = Sacco::where('is_active', true)->get();
        return view('driver.profile.create', compact('saccos'));
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
            'sacco_id' => 'nullable|exists:saccos,id'
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

    public function editProfile()
    {
        $driverProfile = Auth::user()->driverProfile;
        $saccos = Sacco::where('is_active', true)->get();
        
        return view('driver.profile.edit', compact('driverProfile', 'saccos'));
    }

    public function updateProfile(Request $request)
    {
        $driverProfile = Auth::user()->driverProfile;
        
        $request->validate([
            'license_number' => 'required|string|unique:driver_profiles,license_number,' . $driverProfile->id,
            'license_expiry' => 'required|date|after:today',
            'vehicle_type' => 'required|string',
            'vehicle_make' => 'required|string',
            'vehicle_model' => 'required|string',
            'vehicle_year' => 'required|integer|min:1980|max:' . (date('Y') + 1),
            'vehicle_plate_number' => 'required|string|unique:driver_profiles,vehicle_plate_number,' . $driverProfile->id,
            'vehicle_color' => 'required|string',
            'vehicle_description' => 'nullable|string',
            'sacco_id' => 'nullable|exists:saccos,id'
        ]);

        $driverProfile->update($request->all());

        return redirect()->route('driver.dashboard')->with('success', 'Driver profile updated successfully!');
    }
}
