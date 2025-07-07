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

        $trips = $driverProfile->trips()->with('sacco')->orderBy('departure_time', 'desc')->paginate(10);
        
        return view('driver.trips.index', compact('trips'));
    }

    public function create()
    {
        $user = Auth::user();
        $driverProfile = $user->driverProfile;
        
        if (!$driverProfile || !$driverProfile->sacco) {
            return redirect()->route('driver.dashboard')->with('error', 'You need to be assigned to a SACCO to create trips.');
        }

        $sacco = $driverProfile->sacco;
        
        return view('driver.trips.create', compact('driverProfile', 'sacco'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $driverProfile = $user->driverProfile;
        
        if (!$driverProfile || !$driverProfile->sacco) {
            return redirect()->route('driver.dashboard')->with('error', 'You need to be assigned to a SACCO to create trips.');
        }

        $request->validate([
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255',
            'departure_time' => 'required|date|after:now',
            'estimated_arrival_time' => 'required|date|after:departure_time',
            'amount' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:1|max:50',
            'notes' => 'nullable|string|max:1000',
        ]);

        Trip::create([
            'driver_id' => $driverProfile->id,
            'sacco_id' => $driverProfile->sacco_id,
            'from_location' => $request->from_location,
            'to_location' => $request->to_location,
            'departure_time' => $request->departure_time,
            'estimated_arrival_time' => $request->estimated_arrival_time,
            'amount' => $request->amount,
            'available_seats' => $request->available_seats,
            'booked_seats' => 0,
            'notes' => $request->notes,
            'status' => 'scheduled',
        ]);

        return redirect()->route('driver.trips.index')->with('success', 'Trip created successfully!');
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

    public function edit(Trip $trip)
    {
        $user = Auth::user();
        $driverProfile = $user->driverProfile;
        
        if (!$driverProfile || $trip->driver_id !== $driverProfile->id) {
            abort(403, 'Unauthorized access to this trip.');
        }

        if ($trip->status !== 'scheduled') {
            return redirect()->route('driver.trips.index')->with('error', 'Only scheduled trips can be edited.');
        }

        return view('driver.trips.edit', compact('trip', 'driverProfile'));
    }

    public function update(Request $request, Trip $trip)
    {
        $user = Auth::user();
        $driverProfile = $user->driverProfile;
        
        if (!$driverProfile || $trip->driver_id !== $driverProfile->id) {
            abort(403, 'Unauthorized access to this trip.');
        }

        if ($trip->status !== 'scheduled') {
            return redirect()->route('driver.trips.index')->with('error', 'Only scheduled trips can be edited.');
        }

        $request->validate([
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255',
            'departure_time' => 'required|date|after:now',
            'estimated_arrival_time' => 'required|date|after:departure_time',
            'amount' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:1|max:50',
            'notes' => 'nullable|string|max:1000',
        ]);

        $trip->update([
            'from_location' => $request->from_location,
            'to_location' => $request->to_location,
            'departure_time' => $request->departure_time,
            'estimated_arrival_time' => $request->estimated_arrival_time,
            'amount' => $request->amount,
            'available_seats' => $request->available_seats,
            'notes' => $request->notes,
        ]);

        return redirect()->route('driver.trips.index')->with('success', 'Trip updated successfully!');
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

    public function destroy(Trip $trip)
    {
        $user = Auth::user();
        $driverProfile = $user->driverProfile;
        
        if (!$driverProfile || $trip->driver_id !== $driverProfile->id) {
            abort(403, 'Unauthorized access to this trip.');
        }

        // Only allow deletion of scheduled trips with no bookings
        if ($trip->status !== 'scheduled') {
            return redirect()->route('driver.trips.index')->with('error', 'Only scheduled trips can be deleted.');
        }

        if ($trip->booked_seats > 0) {
            return redirect()->route('driver.trips.index')->with('error', 'Cannot delete trip with existing bookings.');
        }

        $trip->delete();

        return redirect()->route('driver.trips.index')->with('success', 'Trip deleted successfully!');
    }
}
