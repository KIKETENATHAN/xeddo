<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trip Details - Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary-navy: #1e3a8a;
            --secondary-gold: #f59e0b;
            --gradient-navy: linear-gradient(135deg, #1e3a8a 0%, #3730a3 100%);
        }

        .detail-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(30, 58, 138, 0.1);
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-scheduled { background: #dbeafe; color: #1e40af; }
        .status-in_progress { background: #fef3c7; color: #d97706; }
        .status-completed { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #dc2626; }

        .btn-primary {
            background: var(--gradient-navy);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-blue-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg p-2 mr-3">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-blue-900">Trip Details</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.trips.edit', $trip) }}" class="btn-primary">
                        Edit Trip
                    </a>
                    <a href="{{ route('admin.trips.index') }}" class="text-blue-900 hover:text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                        Back to Trips
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="detail-card p-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-blue-900 mb-4">Trip Details</h2>
                <div class="flex items-center justify-center space-x-4">
                    <span class="status-badge status-{{ $trip->status }}">
                        {{ ucfirst(str_replace('_', ' ', $trip->status)) }}
                    </span>
                    <span class="text-2xl font-bold text-blue-900">{{ $trip->formatted_amount }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Trip Information -->
                <div>
                    <h3 class="text-xl font-bold text-blue-900 mb-4">Trip Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Route</label>
                            <p class="text-gray-900">{{ $trip->from_location }} → {{ $trip->to_location }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Departure Time</label>
                            <p class="text-gray-900">{{ $trip->departure_time->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Arrival</label>
                            <p class="text-gray-900">{{ $trip->estimated_arrival_time->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Seats</label>
                            <p class="text-gray-900">{{ $trip->booked_seats }}/{{ $trip->available_seats }} booked</p>
                        </div>
                    </div>
                </div>

                <!-- Driver & SACCO Information -->
                <div>
                    <h3 class="text-xl font-bold text-blue-900 mb-4">Driver & SACCO</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Driver</label>
                            @if($trip->driver)
                                <p class="text-gray-900">{{ $trip->driver->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $trip->driver->user->email }}</p>
                            @else
                                <p class="text-gray-500">No driver assigned</p>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">SACCO</label>
                            <p class="text-gray-900">{{ $trip->sacco->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                            <p class="text-gray-900">{{ $trip->formatted_amount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($trip->notes)
            <div class="mb-8">
                <h3 class="text-xl font-bold text-blue-900 mb-4">Notes</h3>
                <p class="text-gray-700 bg-gray-50 p-4 rounded-lg">{{ $trip->notes }}</p>
            </div>
            @endif

            <!-- Bookings (if any) -->
            @if($trip->bookings && $trip->bookings->count() > 0)
            <div>
                <h3 class="text-xl font-bold text-blue-900 mb-4">Bookings ({{ $trip->bookings->count() }})</h3>
                <div class="space-y-4">
                    @foreach($trip->bookings as $booking)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $booking->passenger->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $booking->passenger->user->email }}</p>
                                    <p class="text-sm text-gray-600">{{ $booking->seats_booked }} seat(s)</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-gray-900">{{ $booking->formatted_amount }}</p>
                                    <p class="text-sm text-gray-600">{{ $booking->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </main>
</body>
</html>
