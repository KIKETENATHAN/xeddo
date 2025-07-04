<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sacco;
use Illuminate\Http\Request;

class SaccoController extends Controller
{
    /**
     * Display a listing of the SACCOs.
     */
    public function index()
    {
        $saccos = Sacco::withCount('drivers', 'activeDrivers')->get();
        return view('admin.saccos.index', compact('saccos'));
    }

    /**
     * Show the form for creating a new SACCO.
     */
    public function create()
    {
        return view('admin.saccos.create');
    }

    /**
     * Store a newly created SACCO in storage.
     */
    public function store(Request $request)
    {
        // Debug: Log the request data
        \Log::info('SACCO Store Request:', $request->all());
        
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'location' => 'required|string|max:255',
                'route_from' => 'required|string|max:255',
                'route_to' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

            // Handle checkbox separately
            $validated['is_active'] = $request->has('is_active') ? true : false;
            
            // Debug: Log validated data
            \Log::info('SACCO Validated Data:', $validated);

            $sacco = Sacco::create($validated);
            
            // Debug: Log created SACCO
            \Log::info('SACCO Created:', $sacco->toArray());

            return redirect()->route('admin.saccos.index')
                ->with('success', 'SACCO "' . $sacco->name . '" created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('SACCO Validation Error:', $e->validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($e->validator->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('SACCO Creation Error:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()
                ->withErrors(['error' => 'Failed to create SACCO: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified SACCO.
     */
    public function show(Sacco $sacco)
    {
        $sacco->load('drivers.user');
        return view('admin.saccos.show', compact('sacco'));
    }

    /**
     * Show the form for editing the specified SACCO.
     */
    public function edit(Sacco $sacco)
    {
        return view('admin.saccos.edit', compact('sacco'));
    }

    /**
     * Update the specified SACCO in storage.
     */
    public function update(Request $request, Sacco $sacco)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'route_from' => 'required|string|max:255',
            'route_to' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $sacco->update($validated);

        return redirect()->route('admin.saccos.index')
            ->with('success', 'SACCO updated successfully.');
    }

    /**
     * Remove the specified SACCO from storage.
     */
    public function destroy(Sacco $sacco)
    {
        $sacco->delete();

        return redirect()->route('admin.saccos.index')
            ->with('success', 'SACCO deleted successfully.');
    }
}
