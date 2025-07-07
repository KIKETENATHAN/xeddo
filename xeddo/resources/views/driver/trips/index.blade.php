<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Trips - Xeddo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            box-sizing: border-box;
        }
        
        html, body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }
        
        body {
            overflow-y: auto;
            min-height: 100vh;
        }
        :root {
            --primary-navy: #1e3a8a;
            --primary-navy-dark: #1e40af;
            --secondary-gold: #f59e0b;
            --secondary-gold-dark: #d97706;
            --accent-gold: #fbbf24;
            --gradient-navy: linear-gradient(135deg, #1e3a8a 0%, #3730a3 100%);
            --gradient-gold: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .bg-primary { background-color: var(--primary-navy); }
        .text-primary { color: var(--primary-navy); }
        .text-secondary { color: var(--secondary-gold); }
        .gradient-navy { background: var(--gradient-navy); }
        .gradient-gold { background: var(--gradient-gold); }

        .trip-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(30, 58, 138, 0.1);
            transition: all 0.3s ease;
        }

        .trip-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
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
        .status-available { background: #e0f2fe; color: #0277bd; }

        .btn-primary {
            background: var(--gradient-navy);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.4);
        }

        .btn-secondary {
            background: var(--gradient-gold);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
            font-size: 0.875rem;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .btn-success:hover {
            transform: translateY(-2px);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
        }

        .hero-section {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            position: relative;
            overflow-y: auto;
        }

        main {
            padding-bottom: 3rem;
            position: relative;
            z-index: 1;
            min-height: calc(100vh - 4rem);
        }

        .success-alert {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            border: none;
        }
    </style>
</head>
<body class="hero-section">
    <!-- Navigation -->
    <nav class="bg-white/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-blue-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="gradient-navy rounded-lg p-2 mr-3">
                        <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-primary">My Trips</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('driver.dashboard') }}" class="text-primary hover:text-primary-dark px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 success-alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-primary mb-4">My Trips</h2>
                <p class="text-gray-600">Manage your scheduled trips and track your earnings</p>
            </div>

            @if($assignedTrips->isEmpty() && $availableTrips->isEmpty())
                <div class="trip-card p-12 text-center">
                    <div class="gradient-navy rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-primary mb-4">No Trips Assigned</h3>
                    <p class="text-gray-600 mb-6">You don't have any trips assigned yet. Check back later or contact your admin for trip assignments.</p>
                </div>
            @else
                <!-- Assigned Trips Section -->
                @if($assignedTrips->isNotEmpty())
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-primary mb-4">My Assigned Trips</h2>
                        <div class="space-y-6">
                            @foreach($assignedTrips as $trip)
                                <div class="trip-card p-6">
                                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                        <div class="flex-1 lg:mr-6">
                                            <div class="flex items-center space-x-3 mb-4">
                                                <span class="status-badge status-{{ $trip->status }}">
                                                    {{ ucfirst(str_replace('_', ' ', $trip->status)) }}
                                                </span>
                                                <span class="text-secondary font-semibold">{{ $trip->sacco->name }}</span>
                                            </div>
                                            
                                            <div class="grid md:grid-cols-2 gap-4 mb-4">
                                                <div class="flex items-center space-x-3">
                                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    <div>
                                                        <p class="text-sm text-gray-500">From</p>
                                                        <p class="font-medium text-primary">{{ $trip->from_location }}</p>
                                                    </div>
                                                </div>
                                                
                                                <div class="flex items-center space-x-3">
                                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    <div>
                                                        <p class="text-sm text-gray-500">To</p>
                                                        <p class="font-medium text-primary">{{ $trip->to_location }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="grid md:grid-cols-3 gap-4 text-sm">
                                                <div>
                                                    <p class="text-gray-500">Departure</p>
                                                    <p class="font-medium">{{ \Carbon\Carbon::parse($trip->departure_time)->format('M j, Y g:i A') }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500">Amount</p>
                                                    <p class="font-medium text-secondary">KSh {{ number_format($trip->amount, 2) }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500">Seats</p>
                                                    <p class="font-medium">{{ $trip->booked_seats }}/{{ $trip->available_seats }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex flex-col space-y-2 mt-4 lg:mt-0">
                                            @if($trip->status === 'scheduled')
                                                <button onclick="startTrip({{ $trip->id }})" class="btn-secondary">
                                                    Start Trip
                                                </button>
                                            @elseif($trip->status === 'in_progress')
                                                <button onclick="completeTrip({{ $trip->id }})" class="btn-primary">
                                                    Complete Trip
                                                </button>
                                            @endif
                                            <a href="{{ route('driver.trips.show', $trip) }}" class="btn-outline">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Available Trips Section -->
                @if($availableTrips->isNotEmpty())
                    <div>
                        <h2 class="text-xl font-bold text-primary mb-4">Available Trips</h2>
                        <div class="space-y-6">
                            @foreach($availableTrips as $trip)
                                <div class="trip-card p-6 border-l-4 border-blue-500">
                                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                        <div class="flex-1 lg:mr-6">
                                            <div class="flex items-center space-x-3 mb-4">
                                                <span class="status-badge status-available">Available</span>
                                                <span class="text-secondary font-semibold">{{ $trip->sacco->name }}</span>
                                            </div>
                                            
                                            <div class="grid md:grid-cols-2 gap-4 mb-4">
                                                <div class="flex items-center space-x-3">
                                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    <div>
                                                        <p class="text-sm text-gray-500">From</p>
                                                        <p class="font-medium text-primary">{{ $trip->from_location }}</p>
                                                    </div>
                                                </div>
                                                
                                                <div class="flex items-center space-x-3">
                                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    <div>
                                                        <p class="text-sm text-gray-500">To</p>
                                                        <p class="font-medium text-primary">{{ $trip->to_location }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="grid md:grid-cols-3 gap-4 text-sm">
                                                <div>
                                                    <p class="text-gray-500">Departure</p>
                                                    <p class="font-medium">{{ \Carbon\Carbon::parse($trip->departure_time)->format('M j, Y g:i A') }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500">Amount</p>
                                                    <p class="font-medium text-secondary">KSh {{ number_format($trip->amount, 2) }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500">Seats</p>
                                                    <p class="font-medium">{{ $trip->available_seats }} available</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex flex-col space-y-2 mt-4 lg:mt-0">
                                            <button onclick="acceptTrip({{ $trip->id }})" class="btn-primary">
                                                Accept Trip
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        </main>

        <script>
        function acceptTrip(tripId) {
            if (confirm('Do you want to accept this trip?')) {
                fetch(`/driver/trips/${tripId}/accept`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.error || 'Error accepting trip');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error accepting trip');
                });
            }
        }

        function startTrip(tripId) {
            if (confirm('Do you want to start this trip?')) {
                fetch(`/driver/trips/${tripId}/start`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.error || 'Error starting trip');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error starting trip');
                });
            }
        }

        function completeTrip(tripId) {
            if (confirm('Do you want to complete this trip?')) {
                fetch(`/driver/trips/${tripId}/complete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.error || 'Error completing trip');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error completing trip');
                });
            }
        }
        </script>
    </body>
</html>
