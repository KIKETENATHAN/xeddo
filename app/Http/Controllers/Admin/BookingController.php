<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Trip;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of all bookings
     */
    public function index(Request $request)
    {
        $query = Booking::with(['trip.driver.user', 'trip.sacco', 'payment', 'user']);
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_reference', 'like', "%{$search}%")
                  ->orWhere('passenger_name', 'like', "%{$search}%")
                  ->orWhere('passenger_email', 'like', "%{$search}%")
                  ->orWhere('passenger_phone', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('booking_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('booking_date', '<=', $request->date_to);
        }
        
        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get summary statistics
        $stats = [
            'total_bookings' => Booking::count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'cancelled_bookings' => Booking::where('status', 'cancelled')->count(),
            'total_revenue' => Booking::where('status', 'confirmed')->sum('amount'),
        ];
        
        return view('admin.bookings.index', compact('bookings', 'stats'));
    }
    
    /**
     * Display the specified booking
     */
    public function show(Booking $booking)
    {
        $booking->load(['trip.driver.user', 'trip.sacco', 'payment', 'user']);
        return view('admin.bookings.show', compact('booking'));
    }
    
    /**
     * Update the booking status
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'notes' => 'nullable|string|max:500'
        ]);
        
        $oldStatus = $booking->status;
        
        $booking->update([
            'status' => $request->status,
            'admin_notes' => $request->notes
        ]);
        
        // Update trip booked seats if status changes
        if ($oldStatus === 'confirmed' && $request->status === 'cancelled') {
            // Decrease booked seats when booking is cancelled
            $booking->trip->decrement('booked_seats', $booking->seats_booked);
        } elseif ($oldStatus === 'cancelled' && $request->status === 'confirmed') {
            // Increase booked seats when booking is confirmed again
            $booking->trip->increment('booked_seats', $booking->seats_booked);
        }
        
        return redirect()->back()->with('success', 'Booking status updated successfully!');
    }
    
    /**
     * Cancel a booking
     */
    public function cancel(Booking $booking)
    {
        if ($booking->status === 'cancelled') {
            return redirect()->back()->with('error', 'Booking is already cancelled.');
        }
        
        DB::transaction(function () use ($booking) {
            // Update booking status
            $booking->update(['status' => 'cancelled']);
            
            // Update payment status if exists
            if ($booking->payment) {
                $booking->payment->update(['status' => 'refunded']);
            }
            
            // Decrease trip booked seats
            $booking->trip->decrement('booked_seats', $booking->seats_booked);
        });
        
        return redirect()->back()->with('success', 'Booking cancelled successfully!');
    }
    
    /**
     * Get booking analytics data
     */
    public function analytics()
    {
        $bookings_by_month = Booking::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(amount) as revenue')
        )
        ->where('status', 'confirmed')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();
        
        $bookings_by_status = Booking::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();
        
        $top_routes = Booking::select(
            'trips.from_location',
            'trips.to_location',
            DB::raw('COUNT(*) as booking_count'),
            DB::raw('SUM(bookings.amount) as total_revenue')
        )
        ->join('trips', 'bookings.trip_id', '=', 'trips.id')
        ->where('bookings.status', 'confirmed')
        ->groupBy('trips.from_location', 'trips.to_location')
        ->orderBy('booking_count', 'desc')
        ->limit(10)
        ->get();
        
        return response()->json([
            'bookings_by_month' => $bookings_by_month,
            'bookings_by_status' => $bookings_by_status,
            'top_routes' => $top_routes
        ]);
    }
    
    /**
     * Export bookings to CSV
     */
    public function export(Request $request)
    {
        $query = Booking::with(['trip.driver.user', 'trip.sacco', 'payment']);
        
        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('booking_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('booking_date', '<=', $request->date_to);
        }
        
        $bookings = $query->orderBy('created_at', 'desc')->get();
        
        $filename = 'bookings_export_' . date('Y_m_d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'Booking Reference',
                'Passenger Name',
                'Passenger Email',
                'Passenger Phone',
                'Trip Route',
                'Departure Time',
                'Driver',
                'SACCO',
                'Seats Booked',
                'Amount',
                'Status',
                'Payment Status',
                'Booking Date',
                'Created At'
            ]);
            
            // Add booking data
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->booking_reference,
                    $booking->passenger_name,
                    $booking->passenger_email,
                    $booking->passenger_phone,
                    $booking->trip->from_location . ' → ' . $booking->trip->to_location,
                    $booking->trip->departure_time->format('Y-m-d H:i'),
                    $booking->trip->driver ? $booking->trip->driver->user->name : 'N/A',
                    $booking->trip->sacco->name,
                    $booking->seats_booked,
                    $booking->amount,
                    ucfirst($booking->status),
                    $booking->payment ? ucfirst($booking->payment->status) : 'N/A',
                    $booking->booking_date ? $booking->booking_date->format('Y-m-d') : 'N/A',
                    $booking->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
