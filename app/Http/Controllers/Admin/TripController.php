<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\DriverProfile;
use App\Models\Sacco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::with(['driver.user', 'sacco'])
            ->orderBy('departure_time', 'desc')
            ->paginate(15);
        
        return view('admin.trips.index', compact('trips'));
    }

    public function create()
    {
        $drivers = DriverProfile::with('user', 'sacco')
            ->where('status', 'approved')
            ->where('is_available', true)
            ->get();
        
        $saccos = Sacco::all();
        
        return view('admin.trips.create', compact('drivers', 'saccos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'driver_id' => 'required|exists:driver_profiles,id',
            'sacco_id' => 'required|exists:saccos,id',
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255',
            'departure_time' => 'required|date|after:now',
            'estimated_arrival_time' => 'required|date|after:departure_time',
            'amount' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:1|max:50',
            'notes' => 'nullable|string|max:1000',
        ]);

        $trip = Trip::create([
            'driver_id' => $request->driver_id,
            'sacco_id' => $request->sacco_id,
            'from_location' => $request->from_location,
            'to_location' => $request->to_location,
            'departure_time' => $request->departure_time,
            'estimated_arrival_time' => $request->estimated_arrival_time,
            'amount' => $request->amount,
            'status' => 'pending_acceptance', // Driver needs to accept first
            'available_seats' => $request->available_seats,
            'booked_seats' => 0,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.trips.index')
            ->with('success', 'Trip created successfully! Driver will be notified.');
    }

    public function show(Trip $trip)
    {
        $trip->load(['driver.user', 'sacco', 'bookings.passenger.user']);
        return view('admin.trips.show', compact('trip'));
    }

    public function edit(Trip $trip)
    {
        $drivers = DriverProfile::with('user', 'sacco')
            ->where('status', 'approved')
            ->get();
        
        $saccos = Sacco::all();
        
        return view('admin.trips.edit', compact('trip', 'drivers', 'saccos'));
    }

    public function update(Request $request, Trip $trip)
    {
        $request->validate([
            'driver_id' => 'required|exists:driver_profiles,id',
            'sacco_id' => 'required|exists:saccos,id',
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255',
            'departure_time' => 'required|date',
            'estimated_arrival_time' => 'required|date|after:departure_time',
            'amount' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:1|max:50',
            'status' => 'required|in:pending_acceptance,scheduled,in_progress,completed,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        $trip->update($request->all());

        return redirect()->route('admin.trips.index')
            ->with('success', 'Trip updated successfully!');
    }

    public function destroy(Trip $trip)
    {
        if ($trip->booked_seats > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete trip with existing bookings.');
        }

        $trip->delete();

        return redirect()->route('admin.trips.index')
            ->with('success', 'Trip deleted successfully!');
    }

    public function updateStatus(Request $request, Trip $trip)
    {
        $request->validate([
            'status' => 'required|in:pending_acceptance,scheduled,in_progress,completed,cancelled'
        ]);

        $trip->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Trip status updated successfully!'
        ]);
    }
}
