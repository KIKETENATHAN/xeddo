<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DriverProfile;
use App\Models\PassengerProfile;
use App\Models\Sacco;
use App\Models\Trip;
use App\Models\AdminNotification;
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
        $totalTrips = Trip::count();
        $activeTrips = Trip::whereIn('status', ['scheduled', 'in_progress'])->count();

        // Get admin notifications
        $notifications = AdminNotification::with(['trip.user', 'trip.sacco'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        $unreadNotificationsCount = AdminNotification::where('read', false)->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalDrivers',
            'totalPassengers',
            'pendingDrivers',
            'activeDrivers',
            'totalSaccos',
            'totalTrips',
            'activeTrips',
            'notifications',
            'unreadNotificationsCount'
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

    public function markNotificationAsRead(AdminNotification $notification)
    {
        $notification->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function markAllNotificationsAsRead()
    {
        AdminNotification::where('is_read', false)->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function getNotifications()
    {
        $notifications = AdminNotification::with(['trip.user', 'trip.sacco'])
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();
        
        $unreadCount = AdminNotification::where('is_read', false)->count();

        return response()->json([
            'notifications' => $notifications,
            'unreadCount' => $unreadCount
        ]);
    }
}
