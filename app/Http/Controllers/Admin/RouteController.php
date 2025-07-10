<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Trip;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routes = Route::orderBy('from_location')
            ->orderBy('to_location')
            ->paginate(15);
        
        return view('admin.routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.routes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255|different:from_location',
            'estimated_fare' => 'nullable|numeric|min:0',
            'estimated_duration_minutes' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        // Check if route already exists
        $existingRoute = Route::where('from_location', $validated['from_location'])
            ->where('to_location', $validated['to_location'])
            ->first();

        if ($existingRoute) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['route' => 'A route from ' . $validated['from_location'] . ' to ' . $validated['to_location'] . ' already exists.']);
        }

        Route::create($validated);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Route $route)
    {
        // Get trips that are directly linked to this route OR match the locations
        $trips = Trip::where(function($query) use ($route) {
            $query->where('route_id', $route->id)
                  ->orWhere(function($subQuery) use ($route) {
                      $subQuery->where('from_location', $route->from_location)
                               ->where('to_location', $route->to_location);
                  });
        })
        ->with(['driver.user', 'sacco'])
        ->latest()
        ->take(10)
        ->get();

        // Assign trips to route for the view
        $route->setRelation('trips', $trips);

        return view('admin.routes.show', compact('route'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Route $route)
    {
        return view('admin.routes.edit', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Route $route)
    {
        $validated = $request->validate([
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255|different:from_location',
            'estimated_fare' => 'nullable|numeric|min:0',
            'estimated_duration_minutes' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        // Check if route already exists (excluding current route)
        $existingRoute = Route::where('from_location', $validated['from_location'])
            ->where('to_location', $validated['to_location'])
            ->where('id', '!=', $route->id)
            ->first();

        if ($existingRoute) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['route' => 'A route from ' . $validated['from_location'] . ' to ' . $validated['to_location'] . ' already exists.']);
        }

        $route->update($validated);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Route $route)
    {
        // Check if route has associated trips (either by route_id or matching locations)
        $tripsCount = Trip::where(function($query) use ($route) {
            $query->where('route_id', $route->id)
                  ->orWhere(function($subQuery) use ($route) {
                      $subQuery->where('from_location', $route->from_location)
                               ->where('to_location', $route->to_location);
                  });
        })->count();

        if ($tripsCount > 0) {
            return redirect()->back()
                ->withErrors(['route' => 'Cannot delete route that has associated trips. Set as inactive instead.']);
        }

        $route->delete();

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route deleted successfully!');
    }

    /**
     * Toggle route active status
     */
    public function toggleStatus(Route $route)
    {
        $route->update(['is_active' => !$route->is_active]);
        
        $status = $route->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Route {$status} successfully!");
    }
}
