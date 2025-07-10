<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DriverProfile;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of all vehicles from driver profiles.
     */
    public function index(Request $request)
    {
        $query = DriverProfile::with(['user', 'sacco'])
            ->whereNotNull('vehicle_plate_number');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('vehicle_plate_number', 'like', "%{$search}%")
                  ->orWhere('vehicle_make', 'like', "%{$search}%")
                  ->orWhere('vehicle_model', 'like', "%{$search}%")
                  ->orWhere('vehicle_color', 'like', "%{$search}%")
                  ->orWhere('vehicle_type', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Apply vehicle type filter
        if ($request->filled('vehicle_type')) {
            $query->where('vehicle_type', $request->vehicle_type);
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply SACCO filter
        if ($request->filled('sacco_id')) {
            $query->where('sacco_id', $request->sacco_id);
        }

        $vehicles = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get distinct vehicle types for filter dropdown
        $vehicleTypes = DriverProfile::whereNotNull('vehicle_type')
            ->distinct()
            ->pluck('vehicle_type')
            ->sort()
            ->values();

        // Get SACCOs for filter dropdown
        $saccos = \App\Models\Sacco::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.vehicles.index', compact('vehicles', 'vehicleTypes', 'saccos'));
    }

    /**
     * Display the specified vehicle details.
     */
    public function show(DriverProfile $vehicle)
    {
        $vehicle->load(['user', 'sacco', 'trips' => function ($query) {
            $query->orderBy('departure_time', 'desc')->take(10);
        }]);

        return view('admin.vehicles.show', compact('vehicle'));
    }

    /**
     * Get vehicle data for API/AJAX requests
     */
    public function getVehicleData(Request $request)
    {
        $vehicles = DriverProfile::select('id', 'vehicle_plate_number', 'vehicle_make', 'vehicle_model', 'vehicle_year', 'vehicle_color', 'vehicle_type')
            ->whereNotNull('vehicle_plate_number')
            ->where('status', 'approved')
            ->orderBy('vehicle_plate_number')
            ->get();

        return response()->json([
            'success' => true,
            'vehicles' => $vehicles
        ]);
    }

    /**
     * Get vehicle plate numbers for dropdown
     */
    public function getPlateNumbers()
    {
        $plateNumbers = DriverProfile::whereNotNull('vehicle_plate_number')
            ->where('status', 'approved')
            ->orderBy('vehicle_plate_number')
            ->pluck('vehicle_plate_number', 'id')
            ->toArray();

        return response()->json([
            'success' => true,
            'plate_numbers' => $plateNumbers
        ]);
    }

    /**
     * Export vehicles data to CSV
     */
    public function export(Request $request)
    {
        $query = DriverProfile::with(['user', 'sacco'])
            ->whereNotNull('vehicle_plate_number');

        // Apply same filters as index method
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('vehicle_plate_number', 'like', "%{$search}%")
                  ->orWhere('vehicle_make', 'like', "%{$search}%")
                  ->orWhere('vehicle_model', 'like', "%{$search}%")
                  ->orWhere('vehicle_color', 'like', "%{$search}%")
                  ->orWhere('vehicle_type', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('vehicle_type')) {
            $query->where('vehicle_type', $request->vehicle_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('sacco_id')) {
            $query->where('sacco_id', $request->sacco_id);
        }

        $vehicles = $query->orderBy('created_at', 'desc')->get();

        $csvData = [];
        $csvData[] = [
            'Driver Name',
            'Email',
            'Phone',
            'Vehicle Type',
            'Make',
            'Model',
            'Year',
            'Plate Number',
            'Color',
            'SACCO',
            'Status',
            'Available',
            'Registration Date'
        ];

        foreach ($vehicles as $vehicle) {
            $csvData[] = [
                $vehicle->user->name,
                $vehicle->user->email,
                $vehicle->user->phone,
                ucfirst($vehicle->vehicle_type),
                $vehicle->vehicle_make,
                $vehicle->vehicle_model,
                $vehicle->vehicle_year,
                $vehicle->vehicle_plate_number,
                $vehicle->vehicle_color,
                $vehicle->sacco ? $vehicle->sacco->name : 'No SACCO',
                ucfirst($vehicle->status),
                $vehicle->is_available ? 'Yes' : 'No',
                $vehicle->created_at->format('Y-m-d H:i:s'),
            ];
        }

        $filename = 'vehicles_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $output = fopen('php://output', 'w');
        
        return response()->stream(function() use ($csvData, $output) {
            foreach ($csvData as $row) {
                fputcsv($output, $row);
            }
            fclose($output);
        }, 200, $headers);
    }

    /**
     * Show the form for creating a new vehicle.
     */
    public function create()
    {
        // Get approved drivers who don't have a vehicle yet or want to add another vehicle
        $drivers = \App\Models\User::where('role', 'driver')
            ->whereHas('driverProfile', function ($query) {
                $query->where('status', 'approved');
            })
            ->with('driverProfile')
            ->orderBy('name')
            ->get();

        // Get active SACCOs
        $saccos = \App\Models\Sacco::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.vehicles.create', compact('drivers', 'saccos'));
    }

    /**
     * Store a newly created vehicle in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vehicle_type' => 'required|string',
            'vehicle_make' => 'required|string',
            'vehicle_model' => 'required|string',
            'vehicle_year' => 'required|integer|min:1980|max:' . (date('Y') + 1),
            'vehicle_plate_number' => 'required|string|unique:driver_profiles,vehicle_plate_number',
            'vehicle_color' => 'required|string',
            'vehicle_description' => 'nullable|string',
            'sacco_id' => 'nullable|exists:saccos,id'
        ]);

        // Get the user's driver profile
        $user = \App\Models\User::findOrFail($request->user_id);
        $driverProfile = $user->driverProfile;

        if (!$driverProfile) {
            return redirect()->back()->withErrors(['user_id' => 'Selected user does not have a driver profile.']);
        }

        // Update the driver profile with new vehicle information
        $driverProfile->update([
            'vehicle_type' => $request->vehicle_type,
            'vehicle_make' => $request->vehicle_make,
            'vehicle_model' => $request->vehicle_model,
            'vehicle_year' => $request->vehicle_year,
            'vehicle_plate_number' => $request->vehicle_plate_number,
            'vehicle_color' => $request->vehicle_color,
            'vehicle_description' => $request->vehicle_description,
            'sacco_id' => $request->sacco_id,
        ]);

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle added successfully!');
    }
}
