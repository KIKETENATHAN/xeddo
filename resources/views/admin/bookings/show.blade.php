<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking Details - Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary-navy: #1e3a8a;
            --secondary-gold: #f59e0b;
            --gradient-navy: linear-gradient(135deg, #1e3a8a 0%, #3730a3 100%);
            --gradient-gold: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .detail-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(30, 58, 138, 0.1);
            overflow: hidden;
            position: relative;
        }

        .detail-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-gold);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: start;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: var(--primary-navy);
            min-width: 140px;
        }

        .info-value {
            color: #374151;
            flex: 1;
            text-align: right;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-confirmed {
            background: #d1fae5;
            color: #065f46;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-completed {
            background: #dbeafe;
            color: #1e40af;
        }

        .btn-primary {
            background: var(--gradient-navy);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(30, 58, 138, 0.3);
        }

        .btn-secondary {
            background: white;
            color: var(--primary-navy);
            border: 2px solid var(--primary-navy);
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: var(--primary-navy);
            color: white;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #ef4444;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        .btn-success {
            background: #10b981;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: #059669;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-navy);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--secondary-gold);
            display: inline-block;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-navy);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        .hero-section {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="hero-section">
    <!-- Navigation -->
    <nav class="bg-white/95 backdrop-blur-md shadow-lg border-b border-blue-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-4">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg p-2">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-blue-900">Xeddo Admin</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.bookings.index') }}" class="text-blue-900 hover:text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                        ← Back to Bookings
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-blue-900 hover:text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-blue-900 mb-4">Booking Details</h2>
            <p class="text-gray-600">Complete information for booking reference {{ $booking->booking_reference }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Booking Information -->
            <div class="lg:col-span-2">
                <div class="detail-card p-6 mb-6">
                    <h3 class="section-title">Booking Information</h3>
                    
                    <div class="space-y-0">
                        <div class="info-row">
                            <span class="info-label">Reference:</span>
                            <span class="info-value font-mono font-bold text-blue-900">{{ $booking->booking_reference }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Status:</span>
                            <span class="info-value">
                                <span class="status-badge status-{{ $booking->status }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Seats Booked:</span>
                            <span class="info-value font-semibold">{{ $booking->seats_booked }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Total Amount:</span>
                            <span class="info-value font-bold text-green-600 text-lg">KES {{ number_format($booking->amount, 2) }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Booking Date:</span>
                            <span class="info-value">{{ $booking->booking_date ? $booking->booking_date->format('M d, Y \a\t g:i A') : 'N/A' }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Created:</span>
                            <span class="info-value">{{ $booking->created_at->format('M d, Y \a\t g:i A') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Passenger Information -->
                <div class="detail-card p-6 mb-6">
                    <h3 class="section-title">Passenger Information</h3>
                    
                    <div class="space-y-0">
                        <div class="info-row">
                            <span class="info-label">Name:</span>
                            <span class="info-value font-semibold">{{ $booking->passenger_name }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Email:</span>
                            <span class="info-value">
                                <a href="mailto:{{ $booking->passenger_email }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $booking->passenger_email }}
                                </a>
                            </span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Phone:</span>
                            <span class="info-value">
                                <a href="tel:{{ $booking->passenger_phone }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $booking->passenger_phone }}
                                </a>
                            </span>
                        </div>
                        
                        @if($booking->user)
                        <div class="info-row">
                            <span class="info-label">Account:</span>
                            <span class="info-value">
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Registered User</span>
                            </span>
                        </div>
                        @else
                        <div class="info-row">
                            <span class="info-label">Account:</span>
                            <span class="info-value">
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-sm">Guest Booking</span>
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Trip Information -->
                <div class="detail-card p-6 mb-6">
                    <h3 class="section-title">Trip Information</h3>
                    
                    <div class="space-y-0">
                        <div class="info-row">
                            <span class="info-label">Route:</span>
                            <span class="info-value font-semibold">{{ $booking->trip->from_location }} → {{ $booking->trip->to_location }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Departure:</span>
                            <span class="info-value">{{ $booking->trip->departure_time->format('M d, Y \a\t g:i A') }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Estimated Arrival:</span>
                            <span class="info-value">{{ $booking->trip->estimated_arrival_time->format('M d, Y \a\t g:i A') }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Driver:</span>
                            <span class="info-value">{{ $booking->trip->driver ? $booking->trip->driver->user->name : 'Not Assigned' }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">SACCO:</span>
                            <span class="info-value">{{ $booking->trip->sacco->name }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Trip Status:</span>
                            <span class="info-value">
                                <span class="status-badge status-{{ $booking->trip->status }}">
                                    {{ ucfirst($booking->trip->status) }}
                                </span>
                            </span>
                        </div>
                        
                        @if($booking->trip->notes)
                        <div class="info-row">
                            <span class="info-label">Notes:</span>
                            <span class="info-value">{{ $booking->trip->notes }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Information -->
                @if($booking->payment)
                <div class="detail-card p-6">
                    <h3 class="section-title">Payment Information</h3>
                    
                    <div class="space-y-0">
                        <div class="info-row">
                            <span class="info-label">Payment Status:</span>
                            <span class="info-value">
                                <span class="status-badge status-{{ $booking->payment->status }}">
                                    {{ ucfirst($booking->payment->status) }}
                                </span>
                            </span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Payment Method:</span>
                            <span class="info-value">{{ ucfirst($booking->payment->payment_method) }}</span>
                        </div>
                        
                        @if($booking->payment->transaction_id)
                        <div class="info-row">
                            <span class="info-label">Transaction ID:</span>
                            <span class="info-value font-mono">{{ $booking->payment->transaction_id }}</span>
                        </div>
                        @endif
                        
                        @if($booking->payment->paid_at)
                        <div class="info-row">
                            <span class="info-label">Paid At:</span>
                            <span class="info-value">{{ $booking->payment->paid_at->format('M d, Y \a\t g:i A') }}</span>
                        </div>
                        @endif
                        
                        <div class="info-row">
                            <span class="info-label">Payment Reference:</span>
                            <span class="info-value font-mono">{{ $booking->payment->payment_reference }}</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Actions Panel -->
            <div class="lg:col-span-1">
                <div class="detail-card p-6 sticky top-24">
                    <h3 class="section-title">Actions</h3>
                    
                    <!-- Status Update Form -->
                    @if($booking->status !== 'cancelled')
                    <form method="POST" action="{{ route('admin.bookings.update-status', $booking) }}" class="mb-6">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Update Status</label>
                            <select name="status" id="status" class="form-input">
                                <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notes (Optional)</label>
                            <textarea name="notes" id="notes" rows="3" class="form-input" placeholder="Add any notes about this status change..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn-primary w-full">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Update Status
                        </button>
                    </form>
                    @endif
                    
                    <!-- Cancel Booking -->
                    @if($booking->status !== 'cancelled')
                    <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}" class="mb-4" onsubmit="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-danger w-full">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel Booking
                        </button>
                    </form>
                    @endif
                    
                    <!-- View Receipt -->
                    @if($booking->payment && $booking->payment->status === 'completed')
                    <a href="{{ route('receipt.view', $booking->booking_reference) }}" target="_blank" class="btn-secondary w-full mb-4">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        View Receipt
                    </a>
                    @endif
                    
                    <!-- Contact Passenger -->
                    <div class="space-y-3">
                        <a href="mailto:{{ $booking->passenger_email }}" class="btn-secondary w-full">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Email Passenger
                        </a>
                        
                        <a href="tel:{{ $booking->passenger_phone }}" class="btn-secondary w-full">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Call Passenger
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
