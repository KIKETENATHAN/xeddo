<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DriverProfile;
use App\Models\PassengerProfile;
use App\Models\Sacco;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalDrivers = User::where('role', 'driver')->count();
        $totalPassengers = User::where('role', 'passenger')->count();
        $pendingDrivers = DriverProfile::where('status', 'pending')->count();
        $activeDrivers = DriverProfile::where('status', 'approved')->where('is_available', true)->count();
        $totalSaccos = Sacco::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalDrivers',
            'totalPassengers',
            'pendingDrivers',
            'activeDrivers',
            'totalSaccos'
        ));
    }

    public function manageUsers()
    {
        $users = User::with(['driverProfile', 'passengerProfile'])->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function manageDrivers()
    {
        $drivers = DriverProfile::with('user')->paginate(10);
        return view('admin.drivers.index', compact('drivers'));
    }

    public function approveDriver(DriverProfile $driver)
    {
        $driver->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Driver approved successfully!');
    }

    public function rejectDriver(DriverProfile $driver)
    {
        $driver->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Driver rejected successfully!');
    }
}
