<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Barryvdh\DomPDF\Facade\Pdf;

class PassengerController extends Controller
{
    /**
     * Display a listing of passengers.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'passenger');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $passengers = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get statistics
        $totalPassengers = User::where('role', 'passenger')->count();
        $activePassengers = User::where('role', 'passenger')->whereNotNull('email_verified_at')->count();
        $inactivePassengers = User::where('role', 'passenger')->whereNull('email_verified_at')->count();

        return view('admin.passengers.index', compact('passengers', 'totalPassengers', 'activePassengers', 'inactivePassengers'));
    }

    /**
     * Show the form for creating a new passenger.
     */
    public function create()
    {
        return view('admin.passengers.create');
    }

    /**
     * Store a newly created passenger in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 'passenger',
            'password' => Hash::make($request->password),
            'email_verified_at' => now(), // Auto-verify admin created passengers
        ]);

        return redirect()->route('admin.passengers.index')->with('success', 'Passenger created successfully!');
    }

    /**
     * Display the specified passenger.
     */
    public function show(User $passenger)
    {
        // Make sure it's a passenger
        if ($passenger->role !== 'passenger') {
            abort(404);
        }

        // Load passenger's bookings/trips
        $passenger->load(['bookings' => function ($query) {
            $query->with(['trip'])->orderBy('created_at', 'desc')->take(10);
        }]);

        return view('admin.passengers.show', compact('passenger'));
    }

    /**
     * Show the form for editing the specified passenger.
     */
    public function edit(User $passenger)
    {
        // Make sure it's a passenger
        if ($passenger->role !== 'passenger') {
            abort(404);
        }

        return view('admin.passengers.edit', compact('passenger'));
    }

    /**
     * Update the specified passenger in storage.
     */
    public function update(Request $request, User $passenger)
    {
        // Make sure it's a passenger
        if ($passenger->role !== 'passenger') {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $passenger->id],
            'phone' => ['required', 'string', 'max:15', 'unique:users,phone,' . $passenger->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $passenger->update($updateData);

        return redirect()->route('admin.passengers.index')->with('success', 'Passenger updated successfully!');
    }

    /**
     * Remove the specified passenger from storage.
     */
    public function destroy(User $passenger)
    {
        // Make sure it's a passenger
        if ($passenger->role !== 'passenger') {
            abort(404);
        }

        $passenger->delete();

        return redirect()->route('admin.passengers.index')->with('success', 'Passenger deleted successfully!');
    }

    /**
     * Export passengers data to CSV
     */
    public function export(Request $request)
    {
        $query = User::where('role', 'passenger');

        // Apply same filters as index method
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $passengers = $query->orderBy('created_at', 'desc')->get();

        $csvData = [];
        $csvData[] = [
            'Name',
            'Email',
            'Phone',
            'Registration Date',
        ];

        foreach ($passengers as $passenger) {
            $csvData[] = [
                $passenger->name,
                $passenger->email,
                $passenger->phone,
                $passenger->created_at->format('Y-m-d H:i:s'),
            ];
        }

        $filename = 'passengers_export_' . date('Y-m-d_H-i-s') . '.csv';
        
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
     * Export passengers data to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = User::where('role', 'passenger');

        // Apply same filters as index method
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $passengers = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('admin.passengers.pdf', compact('passengers'));
        
        $filename = 'passengers_export_' . date('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }
}
