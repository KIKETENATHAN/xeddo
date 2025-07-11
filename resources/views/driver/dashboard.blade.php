<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Driver Dashboard - Xeddo Travel Link</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.jpg') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Assets -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-ogBwu_Df.css') }}">
    <script type="module" src="{{ asset('build/assets/app-DaBYqt0m.js') }}"></script>
    <style>
        * {
            box-sizing: border-box;
        }
        
        html, body {
            margin: 0;
            padding: 0;
            scroll-behavior: smooth;
            overflow-x: hidden;
            height: auto;
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
        .bg-primary-dark { background-color: var(--primary-navy-dark); }
        .bg-secondary { background-color: var(--secondary-gold); }
        .bg-secondary-dark { background-color: var(--secondary-gold-dark); }
        .text-primary { color: var(--primary-navy); }
        .text-secondary { color: var(--secondary-gold); }
        .border-primary { border-color: var(--primary-navy); }
        .border-secondary { border-color: var(--secondary-gold); }

        .gradient-navy { background: var(--gradient-navy); }
        .gradient-gold { background: var(--gradient-gold); }

        .dashboard-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(30, 58, 138, 0.1);
        }

        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-card {
            background: var(--gradient-navy);
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(30, 58, 138, 0.3);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(245, 158, 11, 0.1);
            border-radius: 50%;
            transform: translate(30px, -30px);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 25px 50px rgba(30, 58, 138, 0.4);
        }

        .stat-card.approved {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .stat-card.pending {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .stat-card.rejected {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

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
            text-align: center;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.4);
        }

        .btn-secondary {
            background: var(--gradient-gold);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
            text-align: center;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        }

        .btn-available {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-available:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }

        .btn-unavailable {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
        }

        .btn-unavailable:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(107, 114, 128, 0.4);
        }

        .icon-container {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(245, 158, 11, 0.2);
            margin-bottom: 1rem;
        }

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }

        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }

        .success-alert {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            border: none;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-approved {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .status-pending {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .status-rejected {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .vehicle-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .vehicle-info-item {
            background: rgba(30, 58, 138, 0.05);
            padding: 1.5rem;
            border-radius: 0.75rem;
            border: 1px solid rgba(30, 58, 138, 0.1);
            transition: all 0.3s ease;
        }

        .vehicle-info-item:hover {
            background: rgba(30, 58, 138, 0.1);
            transform: translateY(-2px);
        }

        .alert-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #f59e0b;
            color: #92400e;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.2);
        }

        .alert-error {
            background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
            border: 1px solid #ef4444;
            color: #991b1b;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
        }
        
        /* Debug scrolling */
        .hero-section {
            min-height: 100vh;
        }
        
        .debug-height {
            min-height: 200vh;
            background: linear-gradient(to bottom, transparent, rgba(255,0,0,0.1));
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-blue-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <x-application-logo type="icon" size="small" class="mr-3" />
                        <h1 class="text-xl font-bold text-primary">Driver Dashboard</h1>
                    </div>
                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button id="mobile-menu-button" class="text-primary hover:text-primary-dark p-2 rounded-lg hover:bg-blue-50 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Desktop menu -->
                    <div class="hidden md:flex items-center space-x-4">
                        <!-- Notification Bell -->
                        <div class="notification-bell relative mr-4" onclick="toggleNotifications()">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            @if($newNotificationsCount > 0)
                            <span class="notification-badge">{{ $newNotificationsCount }}</span>
                            @endif
                            
                            <!-- Notification Dropdown -->
                            <div id="notifications-dropdown" class="notification-dropdown hidden">
                                <div class="p-4 border-b border-gray-200">
                                    <h3 class="font-semibold text-gray-900">New Trip Assignments</h3>
                                </div>
                                @if($pendingTrips->count() > 0)
                                    @foreach($pendingTrips as $trip)
                                    <div class="p-3 border-b border-gray-100 hover:bg-gray-50">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900">{{ $trip->from_location }} → {{ $trip->to_location }}</p>
                                                <p class="text-xs text-gray-500">{{ $trip->departure_time->format('M d, Y H:i') }}</p>
                                                <p class="text-xs text-blue-600">{{ $trip->formatted_amount }}</p>
                                            </div>
                                            <div class="flex space-x-1">
                                                <button onclick="acceptTrip({{ $trip->id }})" class="btn-accept">Accept</button>
                                                <button onclick="rejectTrip({{ $trip->id }})" class="btn-reject">Reject</button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="p-4 text-center text-gray-500">
                                        <p>No new trip assignments</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-gold rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <span class="text-primary font-medium">Welcome, {{ auth()->user()->name }}</span>
                        </div>
                        <a href="{{ route('driver.trips.index') }}" class="text-primary hover:text-primary-dark px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                            My Trips
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-primary hover:text-primary-dark px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Mobile menu -->
                <div id="mobile-menu" class="md:hidden hidden border-t border-blue-100 bg-white/95 backdrop-blur-md">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        <!-- Mobile Notification Bell -->
                        <div class="flex items-center justify-between px-3 py-2">
                            <span class="text-primary font-medium">Notifications</span>
                            <div class="notification-bell relative" onclick="toggleNotifications()">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                @if($newNotificationsCount > 0)
                                <span class="notification-badge">{{ $newNotificationsCount }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3 px-3 py-2">
                            <div class="w-8 h-8 bg-gradient-gold rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <span class="text-primary font-medium">Welcome, {{ auth()->user()->name }}</span>
                        </div>
                        <a href="{{ route('driver.trips.index') }}" class="block px-3 py-2 rounded-lg text-primary hover:bg-blue-50 transition-colors font-medium">
                            My Trips
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-primary hover:bg-blue-50 transition-colors font-medium">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 debug-height">
            @if(session('success'))
                <div class="mb-6 success-alert fade-in">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Welcome Section -->
            <div class="text-center mb-8 fade-in">
                <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">
                    Welcome Back, <span class="text-secondary">{{ auth()->user()->name }}</span>
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Ready to start earning? Manage your availability and track your performance below.
                </p>
                <div class="mt-4">
                    <span class="status-badge status-{{ $stats['status'] }}">
                        {{ ucfirst($stats['status']) }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Stats and Controls -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Statistics -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 fade-in stagger-1">
                        <div class="stat-card floating-animation">
                            <div class="p-6 relative z-10">
                                <div class="flex items-center">
                                    <div class="icon-container">
                                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-sm font-medium text-blue-200">Total Trips</h3>
                                        <p class="text-3xl font-bold text-white">{{ $stats['total_trips'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="stat-card floating-animation" style="animation-delay: 0.2s;">
                            <div class="p-6 relative z-10">
                                <div class="flex items-center">
                                    <div class="icon-container">
                                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-sm font-medium text-blue-200">Active Trips</h3>
                                        <p class="text-3xl font-bold text-white">{{ $stats['active_trips'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="stat-card floating-animation" style="animation-delay: 0.4s;">
                            <div class="p-6 relative z-10">
                                <div class="flex items-center">
                                    <div class="icon-container">
                                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-sm font-medium text-blue-200">Total Earnings</h3>
                                        <p class="text-3xl font-bold text-white">KSH {{ number_format($stats['total_earnings'], 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Availability Toggle -->
                    @if($stats['status'] === 'approved')
                        <div class="dashboard-card fade-in stagger-2">
                            <div class="p-8">
                                <div class="text-center mb-6">
                                    <div class="gradient-gold rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-primary mb-2">Availability Control</h3>
                                    <p class="text-gray-600">Toggle your availability to start receiving ride requests</p>
                                </div>
                                <div class="text-center">
                                    <form method="POST" action="{{ route('driver.toggle.availability') }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="{{ $stats['is_available'] ? 'btn-available' : 'btn-unavailable' }} px-8 py-4 text-lg">
                                            <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($stats['is_available'])
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                @endif
                                            </svg>
                                            {{ $stats['is_available'] ? 'Currently Available' : 'Currently Unavailable' }}
                                        </button>
                                    </form>
                                    <p class="text-sm text-gray-500 mt-3">
                                        {{ $stats['is_available'] ? 'You are ready to receive ride requests' : 'You will not receive ride requests while unavailable' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Vehicle Information -->
                    <div class="dashboard-card fade-in stagger-3">
                        <div class="p-8">
                            <div class="text-center mb-6">
                                <div class="gradient-navy rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-primary mb-2">Vehicle Information</h3>
                                <p class="text-gray-600">Your registered vehicle details</p>
                            </div>
                            <div class="vehicle-info-grid">
                                <div class="vehicle-info-item">
                                    <h4 class="text-sm font-semibold text-primary mb-1">Vehicle</h4>
                                    <p class="text-lg font-medium text-gray-800">{{ $driverProfile->vehicle_year }} {{ $driverProfile->vehicle_make }} {{ $driverProfile->vehicle_model }}</p>
                                </div>
                                <div class="vehicle-info-item">
                                    <h4 class="text-sm font-semibold text-primary mb-1">Plate Number</h4>
                                    <p class="text-lg font-medium text-gray-800">{{ $driverProfile->vehicle_plate_number }}</p>
                                </div>
                                <div class="vehicle-info-item">
                                    <h4 class="text-sm font-semibold text-primary mb-1">Color</h4>
                                    <p class="text-lg font-medium text-gray-800">{{ $driverProfile->vehicle_color }}</p>
                                </div>
                                <div class="vehicle-info-item">
                                    <h4 class="text-sm font-semibold text-primary mb-1">Type</h4>
                                    <p class="text-lg font-medium text-gray-800">{{ $driverProfile->vehicle_type }}</p>
                                </div>
                            </div>
                            @if($driverProfile->vehicle_description)
                                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                                    <h4 class="text-sm font-semibold text-primary mb-2">Vehicle Description</h4>
                                    <p class="text-gray-700">{{ $driverProfile->vehicle_description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Profile Section -->
                <div class="dashboard-card fade-in stagger-4">
                    <div class="p-8">
                        <div class="text-center mb-6">
                            <div class="gradient-navy rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-primary mb-2">Driver Profile</h3>
                            <p class="text-gray-600">Your license and certification details</p>
                            <div class="mt-4">
                                <a href="{{ route('driver.profile.edit') }}" class="btn-secondary">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Profile
                                </a>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <h4 class="text-sm font-semibold text-primary mb-1">License Number</h4>
                                <p class="text-lg font-medium text-gray-800">{{ $driverProfile->license_number }}</p>
                            </div>
                            @if($driverProfile->license_expiry)
                                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                    <h4 class="text-sm font-semibold text-primary mb-1">License Expiry</h4>
                                    <p class="text-lg font-medium text-gray-800">{{ $driverProfile->license_expiry->format('M d, Y') }}</p>
                                </div>
                            @endif
                            
                            <!-- SACCO Information Section -->
                            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 p-6 rounded-lg border-2 border-yellow-200 relative">
                                <div class="absolute top-2 right-2">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-primary mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    SACCO Membership
                                </h4>
                                @if($driverProfile->sacco)
                                    <div class="space-y-2">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <p class="text-xl font-bold text-gray-800">{{ $driverProfile->sacco->name }}</p>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    Route: {{ $driverProfile->sacco->full_route }}
                                                </p>
                                                <p class="text-sm text-gray-600">
                                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    Location: {{ $driverProfile->sacco->location }}
                                                </p>
                                            </div>
                                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                                Active Member
                                            </span>
                                        </div>
                                        @if($driverProfile->sacco->phone_number)
                                            <div class="mt-3 p-3 bg-white/50 rounded-lg">
                                                <p class="text-sm text-gray-600">
                                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                    </svg>
                                                    Contact: {{ $driverProfile->sacco->phone_number }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <div class="text-gray-400 mb-2">
                                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <h5 class="text-lg font-semibold text-gray-600 mb-1">No SACCO Assigned</h5>
                                        <p class="text-sm text-gray-500 mb-3">Join a SACCO to operate on specific routes and connect with other drivers</p>
                                        <a href="{{ route('driver.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded-lg hover:bg-yellow-600 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Join a SACCO
                                        </a>
                                    </div>
                                @endif
                            </div>
                            
                            @if($stats['status'] === 'pending')
                                <div class="alert-warning">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <h4 class="font-semibold mb-1">Profile Under Review</h4>
                                            <p class="text-sm">Your driver profile is currently being reviewed by our team. You'll be notified once it's approved and you can start accepting rides.</p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($stats['status'] === 'rejected')
                                <div class="alert-error">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <h4 class="font-semibold mb-1">Profile Rejected</h4>
                                            <p class="text-sm">Your driver profile has been rejected. Please contact our support team for more information and assistance with resubmission.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 fade-in stagger-4">
                <div class="dashboard-card text-center p-6 group cursor-pointer">
                    <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-primary mb-2">Earnings Report</h4>
                    <p class="text-gray-600 text-sm">View your daily and weekly earnings</p>
                </div>

                <a href="{{ route('driver.trips.index') }}" class="dashboard-card text-center p-6 group cursor-pointer hover:no-underline">
                    <div class="bg-yellow-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-primary mb-2">My Trips</h4>
                    <p class="text-gray-600 text-sm">View and manage assigned trips</p>
                </a>

                <div class="dashboard-card text-center p-6 group cursor-pointer">
                    <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-primary mb-2">Support</h4>
                    <p class="text-gray-600 text-sm">Contact admin for help</p>
                </div>
            </div>

            <!-- Completed Trips Modal -->
            <div id="completedTripsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
                <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
                    <!-- Modal Header -->
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-xl font-bold text-white">Completed Trips</h3>
                        </div>
                        <button id="closeModal" class="text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Content -->
                    <div class="p-6 overflow-y-auto max-h-[70vh]">
                        <div id="completedTripsContent">
                            <!-- Loading state -->
                            <div id="loadingSpinner" class="flex items-center justify-center py-12">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-600"></div>
                                <span class="ml-3 text-gray-600">Loading completed trips...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 fade-in stagger-4">
                <div class="dashboard-card text-center p-6 group cursor-pointer">
                    <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-primary mb-2">Earnings Report</h4>
                    <p class="text-gray-600 text-sm">View your daily and weekly earnings</p>
                </div>

                <a href="{{ route('driver.trips.index') }}" class="dashboard-card text-center p-6 group cursor-pointer hover:no-underline">
                    <div class="bg-yellow-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-primary mb-2">My Trips</h4>
                    <p class="text-gray-600 text-sm">View and manage assigned trips</p>
                </a>

                <div class="dashboard-card text-center p-6 group cursor-pointer">
                    <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-primary mb-2">Support</h4>
                    <p class="text-gray-600 text-sm">Contact admin for help</p>
                </div>
            </div>
        </main>

    <script>
        // Debug scrolling issue
        console.log('Page height:', document.body.scrollHeight);
        console.log('Viewport height:', window.innerHeight);
        console.log('Can scroll:', document.body.scrollHeight > window.innerHeight);
        
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Add smooth scrolling and enhanced interactions
        document.querySelectorAll('.dashboard-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Enhanced availability toggle feedback
        const availabilityForm = document.querySelector('form[action*="toggle.availability"]');
        if (availabilityForm) {
            availabilityForm.addEventListener('submit', function(e) {
                const button = this.querySelector('button');
                button.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    button.style.transform = 'scale(1)';
                }, 150);
            });
        }

        // Modal functionality for completed trips
        const completedTripsBtn = document.getElementById('completedTripsBtn');
        const completedTripsModal = document.getElementById('completedTripsModal');
        const closeModal = document.getElementById('closeModal');
        const completedTripsContent = document.getElementById('completedTripsContent');
        const loadingSpinner = document.getElementById('loadingSpinner');

        // Open modal and fetch completed trips
        completedTripsBtn.addEventListener('click', function() {
            completedTripsModal.classList.remove('hidden');
            fetchCompletedTrips();
        });

        // Close modal
        closeModal.addEventListener('click', function() {
            completedTripsModal.classList.add('hidden');
        });

        // Close modal when clicking outside
        completedTripsModal.addEventListener('click', function(e) {
            if (e.target === completedTripsModal) {
                completedTripsModal.classList.add('hidden');
            }
        });

        // Fetch completed trips via AJAX
        function fetchCompletedTrips() {
            loadingSpinner.style.display = 'flex';
            
            fetch('{{ route("driver.completed.trips") }}')
                .then(response => response.json())
                .then(data => {
                    loadingSpinner.style.display = 'none';
                    displayCompletedTrips(data);
                })
                .catch(error => {
                    loadingSpinner.style.display = 'none';
                    completedTripsContent.innerHTML = `
                        <div class="text-center py-8">
                            <div class="text-red-500 text-lg font-semibold mb-2">Error loading trips</div>
                            <p class="text-gray-600">Please try again later.</p>
                        </div>
                    `;
                    console.error('Error:', error);
                });
        }

        // Display completed trips
        function displayCompletedTrips(trips) {
            if (trips.length === 0) {
                completedTripsContent.innerHTML = `
                    <div class="text-center py-12">
                        <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">No Completed Trips</h3>
                        <p class="text-gray-500">You haven't completed any trips yet.</p>
                    </div>
                `;
                return;
            }

            let html = '<div class="space-y-4">';
            
            trips.forEach(trip => {
                html += `
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-3">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                    <span class="text-lg font-bold text-green-600">${trip.amount}</span>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">Route:</p>
                                        <p class="font-medium text-gray-800">${trip.from_location} → ${trip.to_location}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">Departure:</p>
                                        <p class="font-medium text-gray-800">${trip.departure_time}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-4 text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        ${trip.booked_seats}/${trip.available_seats} seats
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        ${trip.sacco_name}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 md:mt-0">
                                <form method="POST" action="${trip.delete_url}" class="inline" onsubmit="return confirm('Are you sure you want to delete this completed trip? This action cannot be undone.')">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-red-500 to-red-600 rounded-lg hover:from-red-600 hover:to-red-700 transition-all transform hover:-translate-y-1 shadow-lg hover:shadow-xl">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            html += '</div>';
            completedTripsContent.innerHTML = html;
        }
        
        // Notification bell functionality
        function toggleNotifications() {
            const dropdown = document.getElementById('notifications-dropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close notifications when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('notifications-dropdown');
            const bell = document.querySelector('.notification-bell');
            
            if (!bell.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        function acceptTrip(tripId) {
            if (!confirm('Are you sure you want to accept this trip?')) {
                return;
            }

            fetch(`/driver/trips/${tripId}/accept`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.error || 'Failed to accept trip');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while accepting the trip');
            });
        }

        function rejectTrip(tripId) {
            if (!confirm('Are you sure you want to reject this trip? The admin will be notified to reassign it.')) {
                return;
            }

            fetch(`/driver/trips/${tripId}/reject`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.error || 'Failed to reject trip');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while rejecting the trip');
            });
        }
        
        // Add some test content to ensure scrolling works
        window.addEventListener('load', function() {
            console.log('Page loaded, checking scroll...');
            if (document.body.scrollHeight <= window.innerHeight) {
                console.log('Page too short, adding test content...');
                const testDiv = document.createElement('div');
                testDiv.style.height = '100vh';
                testDiv.style.background = 'rgba(255,0,0,0.1)';
                testDiv.innerHTML = '<p style="padding: 20px;">Test content to enable scrolling</p>';
                document.body.appendChild(testDiv);
            }
        });
    </script>
</body>
</html>