<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    /**
     * Display a listing of all payments
     */
    public function index(Request $request)
    {
        $query = Payment::with(['booking.trip.driver.user', 'booking.trip.sacco']);
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('payment_reference', 'like', "%{$search}%")
                  ->orWhere('transaction_id', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhereHas('booking', function ($bookingQuery) use ($search) {
                      $bookingQuery->where('booking_reference', 'like', "%{$search}%")
                                  ->orWhere('passenger_name', 'like', "%{$search}%")
                                  ->orWhere('passenger_email', 'like', "%{$search}%");
                  });
            });
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }
        
        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }
        
        $payments = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get summary statistics
        $stats = [
            'total_payments' => Payment::count(),
            'successful_payments' => Payment::where('status', 'completed')->count(),
            'failed_payments' => Payment::where('status', 'failed')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'processing_payments' => Payment::where('status', 'processing')->count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            'todays_revenue' => Payment::where('status', 'completed')
                                      ->whereDate('created_at', today())
                                      ->sum('amount'),
            'this_month_revenue' => Payment::where('status', 'completed')
                                           ->whereYear('created_at', date('Y'))
                                           ->whereMonth('created_at', date('m'))
                                           ->sum('amount'),
        ];
        
        return view('admin.payments.index', compact('payments', 'stats'));
    }
    
    /**
     * Display the specified payment
     */
    public function show(Payment $payment)
    {
        $payment->load(['booking.trip.driver.user', 'booking.trip.sacco', 'booking.user']);
        return view('admin.payments.show', compact('payment'));
    }
    
    /**
     * Update the payment status
     */
    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,failed,refunded',
            'admin_notes' => 'nullable|string|max:500'
        ]);
        
        $oldStatus = $payment->status;
        
        $payment->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes
        ]);
        
        // Update related booking status based on payment status
        if ($request->status === 'completed' && $oldStatus !== 'completed') {
            $payment->booking->update(['status' => 'confirmed']);
        } elseif ($request->status === 'failed' && $oldStatus !== 'failed') {
            $payment->booking->update(['status' => 'cancelled']);
        } elseif ($request->status === 'refunded' && $oldStatus !== 'refunded') {
            $payment->booking->update(['status' => 'cancelled']);
        }
        
        return redirect()->back()->with('success', 'Payment status updated successfully!');
    }
    
    /**
     * Refund a payment
     */
    public function refund(Payment $payment)
    {
        if ($payment->status !== 'completed') {
            return redirect()->back()->with('error', 'Only completed payments can be refunded.');
        }
        
        DB::transaction(function () use ($payment) {
            // Update payment status
            $payment->update([
                'status' => 'refunded',
                'refunded_at' => now(),
                'admin_notes' => 'Refunded by admin at ' . now()->format('Y-m-d H:i:s')
            ]);
            
            // Update booking status
            $payment->booking->update(['status' => 'cancelled']);
            
            // Decrease trip booked seats if booking was confirmed
            if ($payment->booking->status === 'confirmed') {
                $payment->booking->trip->decrement('booked_seats', $payment->booking->seats_booked);
            }
        });
        
        return redirect()->back()->with('success', 'Payment refunded successfully!');
    }
    
    /**
     * Get payment analytics data
     */
    public function analytics()
    {
        // Check if we're using SQLite or MySQL and use appropriate date functions
        $driver = config('database.default');
        $isSqlite = $driver === 'sqlite';
        
        // Monthly payment statistics with database-specific date functions
        if ($isSqlite) {
            $payments_by_month = Payment::select(
                DB::raw('strftime("%Y", created_at) as year'),
                DB::raw('strftime("%m", created_at) as month'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN amount ELSE 0 END) as revenue'),
                DB::raw('COUNT(CASE WHEN status = "completed" THEN 1 END) as successful_count'),
                DB::raw('COUNT(CASE WHEN status = "failed" THEN 1 END) as failed_count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();
        } else {
            $payments_by_month = Payment::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN amount ELSE 0 END) as revenue'),
                DB::raw('COUNT(CASE WHEN status = "completed" THEN 1 END) as successful_count'),
                DB::raw('COUNT(CASE WHEN status = "failed" THEN 1 END) as failed_count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();
        }
        
        // Payment status distribution
        $payments_by_status = Payment::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();
            
        // Payment method statistics
        $payments_by_method = Payment::select('payment_method', 
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(CASE WHEN status = "completed" THEN amount ELSE 0 END) as revenue')
        )
        ->groupBy('payment_method')
        ->get();
        
        // Daily revenue for last 30 days with database-specific date functions
        if ($isSqlite) {
            $daily_revenue = Payment::select(
                DB::raw('date(created_at) as date'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN amount ELSE 0 END) as revenue'),
                DB::raw('COUNT(CASE WHEN status = "completed" THEN 1 END) as successful_payments')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        } else {
            $daily_revenue = Payment::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN amount ELSE 0 END) as revenue'),
                DB::raw('COUNT(CASE WHEN status = "completed" THEN 1 END) as successful_payments')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        }
        
        // Overall statistics
        $totalPayments = Payment::count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $pendingPayments = Payment::where('status', 'pending')->count();
        $failedPayments = Payment::where('status', 'failed')->count();
        $refundedAmount = Payment::where('status', 'refunded')->sum('amount');
        $averagePayment = Payment::where('status', 'completed')->avg('amount');
        
        // Top payment methods
        $topPaymentMethods = Payment::select('payment_method', 
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(CASE WHEN status = "completed" THEN amount ELSE 0 END) as revenue')
        )
        ->groupBy('payment_method')
        ->orderBy('revenue', 'desc')
        ->get();
        
        return view('admin.payments.analytics', compact(
            'payments_by_month',
            'payments_by_status', 
            'payments_by_method',
            'daily_revenue',
            'totalPayments',
            'totalRevenue',
            'pendingPayments',
            'failedPayments',
            'refundedAmount',
            'averagePayment',
            'topPaymentMethods'
        ));
    }
    
    /**
     * Export payments to CSV or PDF
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv'); // Default to CSV
        
        $query = Payment::with(['booking.trip.driver.user', 'booking.trip.sacco', 'booking.user']);
        
        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $payments = $query->orderBy('created_at', 'desc')->get();
        
        if ($format === 'pdf') {
            return $this->exportToPDF($payments, $request);
        }
        
        return $this->exportToCSV($payments);
    }
    
    /**
     * Export payments to CSV
     */
    private function exportToCSV($payments)
    {
        $filename = 'payments_export_' . date('Y_m_d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'Payment Reference',
                'Transaction ID',
                'Booking Reference',
                'Passenger Name',
                'Phone Number',
                'Amount',
                'Payment Method',
                'Status',
                'Trip Route',
                'SACCO',
                'Created At',
                'Paid At',
                'Refunded At'
            ]);
            
            // Add payment data
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->payment_reference,
                    $payment->transaction_id ?? 'N/A',
                    $payment->booking->booking_reference ?? 'N/A',
                    $payment->booking->user->name ?? 'N/A',
                    $payment->phone_number,
                    $payment->amount,
                    ucfirst($payment->payment_method),
                    ucfirst($payment->status),
                    ($payment->booking->trip->from_location ?? '') . ' → ' . ($payment->booking->trip->to_location ?? ''),
                    $payment->booking->trip->sacco->name ?? 'N/A',
                    $payment->created_at->format('Y-m-d H:i:s'),
                    $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i:s') : 'N/A',
                    $payment->refunded_at ? $payment->refunded_at->format('Y-m-d H:i:s') : 'N/A'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Export payments to PDF
     */
    private function exportToPDF($payments, $request)
    {
        $totalRevenue = $payments->where('status', 'completed')->sum('amount');
        $totalPayments = $payments->count();
        $completedPayments = $payments->where('status', 'completed')->count();
        $pendingPayments = $payments->where('status', 'pending')->count();
        $failedPayments = $payments->where('status', 'failed')->count();
        
        $data = [
            'payments' => $payments,
            'totalRevenue' => $totalRevenue,
            'totalPayments' => $totalPayments,
            'completedPayments' => $completedPayments,
            'pendingPayments' => $pendingPayments,
            'failedPayments' => $failedPayments,
            'filters' => $request->only(['status', 'payment_method', 'date_from', 'date_to']),
            'exportDate' => now()->format('Y-m-d H:i:s')
        ];
        
        $pdf = PDF::loadView('admin.payments.export-pdf', $data);
        $filename = 'payments_report_' . date('Y_m_d_His') . '.pdf';
        
        return $pdf->download($filename);
    }
}
