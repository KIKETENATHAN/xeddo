<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\AdminNotification;
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

        // Get trips assigned to this driver that are pending acceptance
        $pendingTrips = Trip::with('sacco')
            ->where('driver_id', $driverProfile->id)
            ->where('status', 'pending_acceptance')
            ->orderBy('departure_time', 'asc')
            ->get();

        // Get trips accepted by this driver
        $acceptedTrips = Trip::with('sacco')
            ->where('driver_id', $driverProfile->id)
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->orderBy('departure_time', 'asc')
            ->get();

        // Get completed trips for reference
        $completedTrips = Trip::with('sacco')
            ->where('driver_id', $driverProfile->id)
            ->where('status', 'completed')
            ->orderBy('departure_time', 'desc')
            ->limit(5)
            ->get();

        // Count of new notifications (pending trips)
        $newNotificationsCount = $pendingTrips->count();
        
        return view('driver.trips.index', compact('pendingTrips', 'acceptedTrips', 'completedTrips', 'newNotificationsCount'));
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

        // Check if trip is assigned to this driver and pending acceptance
        if ($trip->driver_id !== $driverProfile->id) {
            return response()->json(['error' => 'Trip not assigned to you'], 400);
        }

        if ($trip->status !== 'pending_acceptance') {
            return response()->json(['error' => 'Trip is not available for acceptance'], 400);
        }

        // Accept the trip
        $trip->update(['status' => 'scheduled']);

        // Send notification to admin about trip acceptance
        $this->notifyAdmin('Trip Accepted', "Driver {$driverProfile->user->name} has accepted the trip from {$trip->from_location} to {$trip->to_location} scheduled for {$trip->departure_time->format('M d, Y H:i')}.", $trip, $driverProfile);

        return response()->json([
            'success' => true,
            'message' => 'Trip accepted successfully! Admin will be notified.'
        ]);
    }

    public function rejectTrip(Request $request, Trip $trip)
    {
        $user = Auth::user();
        $driverProfile = $user->driverProfile;
        
        if (!$driverProfile) {
            return response()->json(['error' => 'Driver profile not found'], 400);
        }

        // Check if trip is assigned to this driver and pending acceptance
        if ($trip->driver_id !== $driverProfile->id) {
            return response()->json(['error' => 'Trip not assigned to you'], 400);
        }

        if ($trip->status !== 'pending_acceptance') {
            return response()->json(['error' => 'Trip is not available for rejection'], 400);
        }

        // Reject the trip - unassign driver and set back to available
        $trip->update([
            'driver_id' => null,
            'status' => 'scheduled'
        ]);

        // Send notification to admin about trip rejection
        $this->notifyAdmin('Trip Rejected', "Driver {$driverProfile->user->name} has rejected the trip from {$trip->from_location} to {$trip->to_location} scheduled for {$trip->departure_time->format('M d, Y H:i')}. Please reassign to another driver.", $trip, $driverProfile);

        return response()->json([
            'success' => true,
            'message' => 'Trip rejected. Admin will be notified to reassign.'
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

        // Send notification to admin about trip start
        $this->notifyAdmin('Trip Started', "Driver {$driverProfile->user->name} has started the trip from {$trip->from_location} to {$trip->to_location}.", $trip, $driverProfile);

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

        // Send notification to admin about trip completion
        $this->notifyAdmin('Trip Completed', "Driver {$driverProfile->user->name} has completed the trip from {$trip->from_location} to {$trip->to_location}.", $trip, $driverProfile);

        return response()->json([
            'success' => true,
            'message' => 'Trip completed successfully! Admin will be notified.'
        ]);
    }

    /**
     * Send notification to admin about driver actions
     */
    private function notifyAdmin($title, $message, $trip = null, $driverProfile = null)
    {
        AdminNotification::create([
            'title' => $title,
            'message' => $message,
            'type' => 'driver_action',
            'trip_id' => $trip ? $trip->id : null,
            'driver_id' => $driverProfile ? $driverProfile->id : null,
            'read' => false
        ]);
    }
}
