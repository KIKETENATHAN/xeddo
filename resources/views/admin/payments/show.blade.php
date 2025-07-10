<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Payment Details - Xeddo Travel Link</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.jpg') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary-navy: #1e3a8a;
            --primary-navy-dark: #1e40af;
            --secondary-gold: #f59e0b;
            --secondary-gold-dark: #d97706;
            --accent-gold: #fbbf24;
        }

        .bg-primary { background-color: var(--primary-navy); }
        .bg-secondary { background-color: var(--secondary-gold); }
        .text-primary { color: var(--primary-navy); }
        .text-secondary { color: var(--secondary-gold); }

        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(30, 58, 138, 0.1);
        }

        .status-pending { 
            background-color: #fef3c7; 
            color: #92400e; 
            border: 1px solid #f59e0b;
        }
        .status-completed { 
            background-color: #d1fae5; 
            color: #065f46; 
            border: 1px solid #10b981;
        }
        .status-failed { 
            background-color: #fee2e2; 
            color: #991b1b; 
            border: 1px solid #ef4444;
        }
        .status-refunded { 
            background-color: #e0e7ff; 
            color: #3730a3; 
            border: 1px solid #6366f1;
        }

        .action-button {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .action-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background-color: var(--primary-navy);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-navy-dark);
        }

        .btn-secondary {
            background-color: var(--secondary-gold);
            color: white;
        }

        .btn-secondary:hover {
            background-color: var(--secondary-gold-dark);
        }

        .btn-danger {
            background-color: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 500;
            color: #374151;
            width: 150px;
            flex-shrink: 0;
        }

        .detail-value {
            color: #111827;
            text-align: right;
            flex-grow: 1;
        }

        .timeline-item {
            position: relative;
            padding-left: 2rem;
            margin-bottom: 1.5rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0.375rem;
            top: 0.375rem;
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
            background-color: var(--primary-navy);
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            left: 0.5rem;
            top: 1rem;
            width: 1px;
            height: calc(100% - 0.5rem);
            background-color: #e5e7eb;
        }

        .timeline-item:last-child::after {
            display: none;
        }
    </style>
</head>
<body class="font-sans bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation Header -->
        <nav class="bg-primary shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                            <img src="{{ asset('images/xeddo-logo.png') }}" alt="Xeddo" class="h-8 w-auto">
                            <span class="text-white font-bold text-xl">Admin Panel</span>
                        </a>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.payments.index') }}" class="text-white hover:text-secondary transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-secondary transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <nav class="text-sm breadcrumbs mb-2">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-primary">Admin</a>
                            <span class="text-gray-400 mx-2">/</span>
                            <a href="{{ route('admin.payments.index') }}" class="text-gray-500 hover:text-primary">Payments</a>
                            <span class="text-gray-400 mx-2">/</span>
                            <span class="text-primary">Payment #{{ $payment->id ?? 'N/A' }}</span>
                        </nav>
                        <h1 class="text-3xl font-bold text-primary">Payment Details</h1>
                        <p class="text-gray-600 mt-2">View and manage payment information</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.payments.index') }}" class="action-button btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Payments
                        </a>
                        @if(isset($payment) && $payment->status === 'completed')
                            <button onclick="confirmRefund()" class="action-button btn-danger">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8"></path>
                                </svg>
                                Process Refund
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Payment Information -->
                <div class="lg:col-span-2">
                    <div class="card p-6 mb-6">
                        <h3 class="text-xl font-semibold text-primary mb-6">Payment Information</h3>
                        
                        <div class="space-y-0">
                            <div class="detail-row">
                                <span class="detail-label">Payment ID:</span>
                                <span class="detail-value font-mono">#{{ $payment->id ?? 'N/A' }}</span>
                            </div>
                            
                            <div class="detail-row">
                                <span class="detail-label">Status:</span>
                                <span class="detail-value">
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full status-{{ $payment->status ?? 'pending' }}">
                                        {{ ucfirst($payment->status ?? 'Pending') }}
                                    </span>
                                </span>
                            </div>
                            
                            <div class="detail-row">
                                <span class="detail-label">Amount:</span>
                                <span class="detail-value text-2xl font-bold text-primary">
                                    KSh {{ number_format($payment->amount ?? 0) }}
                                </span>
                            </div>
                            
                            <div class="detail-row">
                                <span class="detail-label">Payment Method:</span>
                                <span class="detail-value">
                                    <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-800">
                                        {{ ucfirst($payment->payment_method ?? 'Unknown') }}
                                    </span>
                                </span>
                            </div>
                            
                            <div class="detail-row">
                                <span class="detail-label">Transaction Reference:</span>
                                <span class="detail-value font-mono text-sm">{{ $payment->transaction_id ?? 'N/A' }}</span>
                            </div>
                            
                            <div class="detail-row">
                                <span class="detail-label">Payment Date:</span>
                                <span class="detail-value">{{ optional($payment->created_at)->format('M j, Y g:i A') ?? 'N/A' }}</span>
                            </div>
                            
                            @if(isset($payment->updated_at) && $payment->updated_at != $payment->created_at)
                            <div class="detail-row">
                                <span class="detail-label">Last Updated:</span>
                                <span class="detail-value">{{ $payment->updated_at->format('M j, Y g:i A') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Passenger Information -->
                    <div class="card p-6 mb-6">
                        <h3 class="text-xl font-semibold text-primary mb-6">Passenger Information</h3>
                        
                        @if(isset($payment->user))
                        <div class="space-y-0">
                            <div class="detail-row">
                                <span class="detail-label">Name:</span>
                                <span class="detail-value">{{ $payment->user->name }}</span>
                            </div>
                            
                            <div class="detail-row">
                                <span class="detail-label">Email:</span>
                                <span class="detail-value">{{ $payment->user->email }}</span>
                            </div>
                            
                            <div class="detail-row">
                                <span class="detail-label">Phone:</span>
                                <span class="detail-value">{{ $payment->user->phone ?? 'N/A' }}</span>
                            </div>
                            
                            <div class="detail-row">
                                <span class="detail-label">User ID:</span>
                                <span class="detail-value font-mono">#{{ $payment->user->id }}</span>
                            </div>
                        </div>
                        @else
                        <p class="text-gray-500">No passenger information available.</p>
                        @endif
                    </div>

                    <!-- Booking Information -->
                    @if(isset($payment->booking))
                    <div class="card p-6">
                        <h3 class="text-xl font-semibold text-primary mb-6">Related Booking</h3>
                        
                        <div class="space-y-0">
                            <div class="detail-row">
                                <span class="detail-label">Booking ID:</span>
                                <span class="detail-value">
                                    <a href="{{ route('admin.bookings.show', $payment->booking->id) }}" 
                                       class="font-mono text-primary hover:underline">#{{ $payment->booking->id }}</a>
                                </span>
                            </div>
                            
                            <div class="detail-row">
                                <span class="detail-label">Route:</span>
                                <span class="detail-value">{{ $payment->booking->trip->route ?? 'N/A' }}</span>
                            </div>
                            
                            <div class="detail-row">
                                <span class="detail-label">Travel Date:</span>
                                <span class="detail-value">{{ optional($payment->booking->trip->departure_time)->format('M j, Y g:i A') ?? 'N/A' }}</span>
                            </div>
                            
                            <div class="detail-row">
                                <span class="detail-label">Seats:</span>
                                <span class="detail-value">{{ $payment->booking->seats_booked ?? 'N/A' }}</span>
                            </div>
                            
                            <div class="detail-row">
                                <span class="detail-label">Booking Status:</span>
                                <span class="detail-value">
                                    <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full 
                                           {{ $payment->booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                              ($payment->booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($payment->booking->status ?? 'Unknown') }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Payment Timeline & Actions -->
                <div class="lg:col-span-1">
                    <!-- Quick Actions -->
                    <div class="card p-6 mb-6">
                        <h3 class="text-lg font-semibold text-primary mb-4">Quick Actions</h3>
                        
                        <div class="space-y-3">
                            @if(isset($payment))
                                @if($payment->status === 'pending')
                                    <form method="POST" action="{{ route('admin.payments.update-status', $payment->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="w-full action-button bg-green-600 text-white justify-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Mark as Completed
                                        </button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('admin.payments.update-status', $payment->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="failed">
                                        <button type="submit" class="w-full action-button bg-red-600 text-white justify-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Mark as Failed
                                        </button>
                                    </form>
                                @endif
                                
                                @if($payment->status === 'completed')
                                    <button onclick="confirmRefund()" class="w-full action-button btn-danger justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8"></path>
                                        </svg>
                                        Process Refund
                                    </button>
                                @endif
                            @endif
                            
                            <a href="{{ route('admin.payments.index') }}" class="w-full action-button btn-primary justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                                View All Payments
                            </a>
                        </div>
                    </div>

                    <!-- Payment Timeline -->
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-primary mb-4">Payment Timeline</h3>
                        
                        <div class="space-y-0">
                            @if(isset($payment))
                                <div class="timeline-item">
                                    <div class="text-sm font-medium text-gray-900">Payment Created</div>
                                    <div class="text-xs text-gray-500">{{ $payment->created_at->format('M j, Y g:i A') }}</div>
                                    <div class="text-xs text-gray-600 mt-1">Payment initiated by {{ $payment->user->name ?? 'Unknown' }}</div>
                                </div>
                                
                                @if($payment->status === 'completed')
                                <div class="timeline-item">
                                    <div class="text-sm font-medium text-green-700">Payment Completed</div>
                                    <div class="text-xs text-gray-500">{{ $payment->updated_at->format('M j, Y g:i A') }}</div>
                                    <div class="text-xs text-gray-600 mt-1">Payment successfully processed</div>
                                </div>
                                @elseif($payment->status === 'failed')
                                <div class="timeline-item">
                                    <div class="text-sm font-medium text-red-700">Payment Failed</div>
                                    <div class="text-xs text-gray-500">{{ $payment->updated_at->format('M j, Y g:i A') }}</div>
                                    <div class="text-xs text-gray-600 mt-1">Payment could not be processed</div>
                                </div>
                                @elseif($payment->status === 'refunded')
                                <div class="timeline-item">
                                    <div class="text-sm font-medium text-blue-700">Payment Refunded</div>
                                    <div class="text-xs text-gray-500">{{ $payment->updated_at->format('M j, Y g:i A') }}</div>
                                    <div class="text-xs text-gray-600 mt-1">Payment refunded to customer</div>
                                </div>
                                @endif
                            @else
                                <p class="text-gray-500 text-sm">No timeline available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Refund Confirmation Modal -->
    <div id="refundModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Confirm Refund</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Are you sure you want to process a refund for this payment of 
                        <strong>KSh {{ number_format($payment->amount ?? 0) }}</strong>? 
                        This action cannot be undone.
                    </p>
                </div>
                <div class="flex justify-center space-x-4 pt-2">
                    <button onclick="closeRefundModal()" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400">
                        Cancel
                    </button>
                    <button onclick="processRefund()" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700">
                        Process Refund
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmRefund() {
            document.getElementById('refundModal').classList.remove('hidden');
        }

        function closeRefundModal() {
            document.getElementById('refundModal').classList.add('hidden');
        }

        function processRefund() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.payments.refund", $payment->id ?? 0) }}';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PATCH';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }

        // Close modal when clicking outside
        document.getElementById('refundModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRefundModal();
            }
        });
    </script>
</body>
</html>
