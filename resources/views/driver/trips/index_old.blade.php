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
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            font-size: 0.875rem;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
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
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
            font-size: 0.875rem;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }

        .btn-edit {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            font-size: 0.875rem;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }

        .btn-delete {
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
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
            font-size: 0.875rem;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .action-buttons .btn-edit,
        .action-buttons .btn-delete {
            min-width: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
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
                    <a href="{{ route('driver.trips.create') }}" class="btn-primary">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Trip
                    </a>
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

            @if($trips->isEmpty())
                <div class="trip-card p-12 text-center">
                    <div class="gradient-navy rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-primary mb-4">No Trips Yet</h3>
                    <p class="text-gray-600 mb-6">You haven't created any trips yet. Start by creating your first trip!</p>
                    <a href="{{ route('driver.trips.create') }}" class="btn-primary">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Your First Trip
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($trips as $trip)
                        <div class="trip-card p-6">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                <div class="flex-1 lg:mr-6">
                                    <div class="flex items-center space-x-3 mb-4">
                                        <span class="status-badge status-{{ $trip->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $trip->status)) }}
                                        </span>
                                        <span class="text-lg font-bold text-primary">{{ $trip->formatted_amount }}</span>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <h3 class="font-semibold text-primary mb-1">Route</h3>
                                            <p class="text-gray-800 flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $trip->from_location }}
                                            </p>
                                            <p class="text-gray-800 flex items-center mt-1">
                                                <svg class="w-4 h-4 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $trip->to_location }}
                                            </p>
                                        </div>
                                        
                                        <div>
                                            <h3 class="font-semibold text-primary mb-1">Schedule</h3>
                                            <p class="text-gray-800 text-sm">
                                                <strong>Departure:</strong> {{ $trip->departure_time->format('M d, Y - g:i A') }}
                                            </p>
                                            <p class="text-gray-800 text-sm">
                                                <strong>Arrival:</strong> {{ $trip->estimated_arrival_time->format('M d, Y - g:i A') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            <span>{{ $trip->booked_seats }}/{{ $trip->available_seats }} seats</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            <span>{{ $trip->sacco->name }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col sm:flex-row gap-2 mt-4 lg:mt-0">
                                    <!-- Edit and Delete buttons -->
                                    @if($trip->status === 'scheduled')
                                        <div class="action-buttons">
                                            <a href="{{ route('driver.trips.edit', $trip) }}" class="btn-edit" title="Edit Trip">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </a>
                                            
                                            @if($trip->booked_seats == 0)
                                                <form method="POST" action="{{ route('driver.trips.destroy', $trip) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this trip? This action cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-delete" title="Delete Trip">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Delete button for completed and cancelled trips -->
                                    @if(in_array($trip->status, ['completed', 'cancelled']))
                                        <div class="action-buttons">
                                            <form method="POST" action="{{ route('driver.trips.destroy', $trip) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this {{ $trip->status }} trip? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete" title="Delete {{ ucfirst($trip->status) }} Trip">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endif

                                    <!-- Status Action buttons -->
                                    @if($trip->status === 'scheduled')
                                        <form method="POST" action="{{ route('driver.trips.update-status', $trip) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="in_progress">
                                            <button type="submit" class="btn-success" title="Start Trip">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h2m3 0h2M12 3v18m-5-5l2.5 2.5L12 16l2.5 2.5L17 16"></path>
                                                </svg>
                                                Start Trip
                                            </button>
                                        </form>
                                    @elseif($trip->status === 'in_progress')
                                        <form method="POST" action="{{ route('driver.trips.update-status', $trip) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn-success" title="Complete Trip">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Complete Trip
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($trip->status === 'scheduled')
                                        <form method="POST" action="{{ route('driver.trips.update-status', $trip) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn-danger" onclick="return confirm('Are you sure you want to cancel this trip?')" title="Cancel Trip">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $trips->links() }}
                </div>
            @endif
        </main>
</body>
</html>
