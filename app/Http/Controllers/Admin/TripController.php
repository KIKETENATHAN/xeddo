<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\DriverProfile;
use App\Models\Sacco;
use App\Models\Route;
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
        
        $routes = Route::active()->orderBy('from_location')->orderBy('to_location')->get();
        
        return view('admin.trips.create', compact('drivers', 'routes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'driver_id' => 'required|exists:driver_profiles,id',
            'route_id' => 'required|exists:routes,id',
            'departure_time' => 'required|date|after:now',
            'estimated_arrival_time' => 'required|date|after:departure_time',
            'amount' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:1|max:50',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Get the selected driver and route
        $driver = DriverProfile::findOrFail($request->driver_id);
        $route = Route::findOrFail($request->route_id);

        $trip = Trip::create([
            'driver_id' => $request->driver_id,
            'sacco_id' => $driver->sacco_id, // Get SACCO from driver's profile
            'route_id' => $request->route_id,
            'from_location' => $route->from_location, // Auto-populate from route
            'to_location' => $route->to_location, // Auto-populate from route
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
        
        $routes = Route::active()->orderBy('from_location')->orderBy('to_location')->get();
        
        return view('admin.trips.edit', compact('trip', 'drivers', 'routes'));
    }

    public function update(Request $request, Trip $trip)
    {
        $request->validate([
            'driver_id' => 'required|exists:driver_profiles,id',
            'route_id' => 'required|exists:routes,id',
            'departure_time' => 'required|date',
            'estimated_arrival_time' => 'required|date|after:departure_time',
            'amount' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:1|max:50',
            'status' => 'required|in:pending_acceptance,scheduled,in_progress,completed,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Get the selected driver and route
        $driver = DriverProfile::findOrFail($request->driver_id);
        $route = Route::findOrFail($request->route_id);

        $trip->update([
            'driver_id' => $request->driver_id,
            'sacco_id' => $driver->sacco_id, // Update SACCO from driver's profile
            'route_id' => $request->route_id,
            'from_location' => $route->from_location, // Update from route
            'to_location' => $route->to_location, // Update from route
            'departure_time' => $request->departure_time,
            'estimated_arrival_time' => $request->estimated_arrival_time,
            'amount' => $request->amount,
            'available_seats' => $request->available_seats,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

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

    public function getRouteDetails(Route $route)
    {
        return response()->json([
            'from_location' => $route->from_location,
            'to_location' => $route->to_location,
            'estimated_fare' => $route->estimated_fare,
            'estimated_duration_minutes' => $route->estimated_duration_minutes,
            'description' => $route->description,
        ]);
    }
}
