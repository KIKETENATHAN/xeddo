<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $driverProfile = $user->driverProfile;
        
        if (!$driverProfile) {
            return redirect()->route('driver.profile.create');
        }

        // Get trips assigned to this driver
        $assignedTrips = $driverProfile->trips()
            ->with('sacco')
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->orderBy('departure_time', 'asc')
            ->get();

        // Get available trips that need drivers (optional - if you want to show unassigned trips)
        $availableTrips = Trip::with('sacco')
            ->where('status', 'scheduled')
            ->where('driver_id', null)
            ->orderBy('departure_time', 'asc')
            ->get();
        
        return view('driver.trips.index', compact('assignedTrips', 'availableTrips'));
    }



    public function show(Trip $trip)
    {
        $user = Auth::user();
        $driverProfile = $user->driverProfile;
        
        if (!$driverProfile || $trip->driver_id !== $driverProfile->id) {
            abort(403, 'Unauthorized access to this trip.');
        }

        $trip->load('sacco');
        
        return view('driver.trips.show', compact('trip'));
    }



    public function updateStatus(Request $request, Trip $trip)
    {
        $user = Auth::user();
        $driverProfile = $user->driverProfile;
        
        if (!$driverProfile || $trip->driver_id !== $driverProfile->id) {
            abort(403, 'Unauthorized access to this trip.');
        }

        $request->validate([
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
        ]);

        $trip->update(['status' => $request->status]);

        return redirect()->route('driver.trips.index')->with('success', 'Trip status updated successfully!');
    }



    public function acceptTrip(Request $request, Trip $trip)
    {
        $user = Auth::user();
        $driverProfile = $user->driverProfile;
        
        if (!$driverProfile) {
            return response()->json(['error' => 'Driver profile not found'], 400);
        }

        // Check if trip is available for acceptance
        if ($trip->driver_id !== null && $trip->driver_id !== $driverProfile->id) {
            return response()->json(['error' => 'Trip already assigned to another driver'], 400);
        }

        if ($trip->status !== 'scheduled') {
            return response()->json(['error' => 'Trip is not available for acceptance'], 400);
        }

        // Assign driver to trip
        $trip->update([
            'driver_id' => $driverProfile->id,
            'status' => 'scheduled'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Trip accepted successfully! Admin will be notified.'
        ]);
    }

    public function startTrip(Request $request, Trip $trip)
    {
        $user = Auth::user();
        $driverProfile = $user->driverProfile;
        
        if (!$driverProfile || $trip->driver_id !== $driverProfile->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($trip->status !== 'scheduled') {
            return response()->json(['error' => 'Trip cannot be started'], 400);
        }

        $trip->update(['status' => 'in_progress']);

        return response()->json([
            'success' => true,
            'message' => 'Trip started successfully! Admin will be notified.'
        ]);
    }

    public function completeTrip(Request $request, Trip $trip)
    {
        $user = Auth::user();
        $driverProfile = $user->driverProfile;
        
        if (!$driverProfile || $trip->driver_id !== $driverProfile->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($trip->status !== 'in_progress') {
            return response()->json(['error' => 'Trip cannot be completed'], 400);
        }

        $trip->update(['status' => 'completed']);

        return response()->json([
            'success' => true,
            'message' => 'Trip completed successfully! Admin will be notified.'
        ]);
    }
}
