<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Passenger Dashboard - Xeddo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            width: 100%;
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
            width: 100%;
            text-align: center;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        }

        .form-input {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem;
            transition: all 0.3s ease;
            background: white;
            color: #374151;
        }

        .form-input:focus {
            border-color: var(--secondary-gold);
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
            outline: none;
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

        .hero-section {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            position: relative;
            overflow-x: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse"><path d="M 50 0 L 0 0 0 50" fill="none" stroke="rgba(30,58,138,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
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
        
        /* Debug scrolling */
        .hero-section {
            min-height: 100vh;
        }
        
        .debug-height {
            min-height: 200vh;
            background: linear-gradient(to bottom, transparent, rgba(255,0,0,0.1));
        }

        .trip-table {
            min-width: 800px;
        }

        .trip-table th,
        .trip-table td {
            white-space: nowrap;
        }

        .trip-table .route-cell {
            max-width: 150px;
            white-space: normal;
        }

        .book-btn {
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
            box-shadow: 0 2px 10px rgba(245, 158, 11, 0.3);
            font-size: 0.875rem;
        }

        .book-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(245, 158, 11, 0.4);
        }

        .book-btn:active {
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .trip-table {
                font-size: 0.875rem;
            }
            
            .book-btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body class="hero-section">
    <div class="relative z-10">
        <!-- Navigation -->
        <nav class="bg-white/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-blue-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="gradient-navy rounded-lg p-2 mr-3">
                            <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h1 class="text-xl font-bold text-primary">Passenger Dashboard</h1>
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
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-gold rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span class="text-primary font-medium">Welcome, {{ auth()->user()->name }}</span>
                        </div>
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
                        <div class="flex items-center space-x-3 px-3 py-2">
                            <div class="w-8 h-8 bg-gradient-gold rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span class="text-primary font-medium">Welcome, {{ auth()->user()->name }}</span>
                        </div>
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
        <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 relative z-10 debug-height">
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

            @if(session('error'))
                <div class="mb-6 bg-red-500 text-white p-4 rounded-lg shadow-lg fade-in">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-500 text-white p-4 rounded-lg shadow-lg fade-in">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        Please fix the following errors:
                    </div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Welcome Section -->
            <div class="text-center mb-8 fade-in">
                <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">
                    Welcome Back, <span class="text-secondary">{{ auth()->user()->name }}</span>
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Ready for your next journey? Book a ride or manage your profile below.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Stats Cards -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Statistics -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 fade-in stagger-1">
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-sm font-medium text-blue-200">Your Rating</h3>
                                        <p class="text-3xl font-bold text-white">{{ number_format($stats['rating'], 1) }}/5.0</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Book a Ride -->
                    <div class="dashboard-card fade-in stagger-2">
                        <div class="p-8">
                            <div class="text-center mb-6">
                                <div class="gradient-gold rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-primary mb-2">Book Your Next Ride</h3>
                                <p class="text-gray-600">Enter your pickup and destination to find available drivers</p>
                            </div>
                            <form method="POST" action="{{ route('passenger.search.rides') }}" class="space-y-6">
                                @csrf
                                <div>
                                    <label for="sacco" class="block text-sm font-semibold text-primary mb-2">Select SACCO</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <select id="sacco" name="sacco_id" class="form-input pl-10" required>
                                            <option value="">Choose a SACCO</option>
                                            @foreach($saccos as $sacco)
                                                <option value="{{ $sacco->id }}" {{ (old('sacco_id', $searchParams['sacco_id'] ?? '') == $sacco->id) ? 'selected' : '' }}>
                                                    {{ $sacco->name }} - {{ $sacco->full_route }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label for="pickup" class="block text-sm font-semibold text-primary mb-2">Pickup Location</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        <input type="text" id="pickup" name="pickup" value="{{ old('pickup', $searchParams['pickup'] ?? '') }}" class="form-input w-full pl-10" placeholder="Enter pickup location" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="destination" class="block text-sm font-semibold text-primary mb-2">Destination</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                            </svg>
                                        </div>
                                        <input type="text" id="destination" name="destination" value="{{ old('destination', $searchParams['destination'] ?? '') }}" class="form-input w-full pl-10" placeholder="Enter destination" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn-secondary">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Find Available Rides
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Search Results -->
                    @if(isset($trips) && $trips->count() > 0)
                        <div class="dashboard-card fade-in stagger-3">
                            <div class="p-8">
                                <div class="text-center mb-6">
                                    <div class="gradient-gold rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-primary mb-2">Available Rides</h3>
                                    <p class="text-gray-600">{{ $trips->count() }} ride(s) found matching your search</p>
                                </div>
                                
                                <div class="overflow-x-auto">
                                    <table class="trip-table w-full">
                                        <thead>
                                            <tr class="bg-gray-50 border-b">
                                                <th class="text-left py-3 px-4 font-semibold text-primary">Driver</th>
                                                <th class="text-left py-3 px-4 font-semibold text-primary">SACCO</th>
                                                <th class="text-left py-3 px-4 font-semibold text-primary route-cell">Route</th>
                                                <th class="text-left py-3 px-4 font-semibold text-primary">Departure</th>
                                                <th class="text-left py-3 px-4 font-semibold text-primary">Price</th>
                                                <th class="text-left py-3 px-4 font-semibold text-primary">Seats</th>
                                                <th class="text-right py-3 px-4 font-semibold text-primary">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($trips as $trip)
                                                <tr class="border-b hover:bg-gray-50 transition-colors">
                                                    <td class="py-4 px-4">
                                                        <div class="flex items-center">
                                                            <div class="w-10 h-10 bg-gradient-navy rounded-full flex items-center justify-center mr-3">
                                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <div class="font-medium text-primary">{{ $trip->driver->user->name }}</div>
                                                                <div class="text-sm text-gray-600">{{ $trip->driver->license_number }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-4">
                                                        <div class="text-sm font-medium text-primary">{{ $trip->sacco->name }}</div>
                                                        <div class="text-xs text-gray-600">{{ $trip->sacco->route }}</div>
                                                    </td>
                                                    <td class="py-4 px-4 route-cell">
                                                        <div class="text-sm">
                                                            <div class="font-medium text-gray-900">{{ $trip->from_location }}</div>
                                                            <div class="text-gray-600 text-xs">to</div>
                                                            <div class="font-medium text-gray-900">{{ $trip->to_location }}</div>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-4">
                                                        <div class="text-sm">
                                                            <div class="font-medium text-gray-900">{{ $trip->departure_time->format('M j, Y') }}</div>
                                                            <div class="text-gray-600">{{ $trip->departure_time->format('g:i A') }}</div>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-4">
                                                        <div class="text-lg font-bold text-secondary">{{ $trip->formatted_amount }}</div>
                                                    </td>
                                                    <td class="py-4 px-4">
                                                        <div class="text-sm">
                                                            <div class="font-medium text-gray-900">{{ $trip->remaining_seats }} available</div>
                                                            <div class="text-gray-600 text-xs">of {{ $trip->available_seats }} total</div>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-4 text-right">
                                                        <form method="POST" action="{{ route('passenger.book.ride', $trip) }}" class="inline">
                                                            @csrf
                                                            <button type="submit" class="book-btn">
                                                                Book Now
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @elseif(isset($trips) && $trips->count() == 0)
                        <div class="dashboard-card fade-in stagger-3">
                            <div class="p-8 text-center">
                                <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-primary mb-2">No Rides Found</h3>
                                <p class="text-gray-600">Sorry, no rides match your search criteria. Try adjusting your pickup location or destination.</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Profile Section -->
                <div class="dashboard-card fade-in stagger-3">
                    <div class="p-8">
                        <div class="text-center mb-6">
                            <div class="gradient-navy rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-primary mb-2">Profile Settings</h3>
                            <p class="text-gray-600">Update your emergency contacts and preferences</p>
                        </div>
                        <form method="POST" action="{{ route('passenger.profile.update') }}" class="space-y-6">
                            @csrf
                            @method('PATCH')
                            <div>
                                <label for="emergency_contact_name" class="block text-sm font-semibold text-primary mb-2">Emergency Contact Name</label>
                                <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="{{ $passengerProfile->emergency_contact_name }}" class="form-input w-full" placeholder="Emergency contact name">
                            </div>
                            <div>
                                <label for="emergency_contact_phone" class="block text-sm font-semibold text-primary mb-2">Emergency Contact Phone</label>
                                <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" value="{{ $passengerProfile->emergency_contact_phone }}" class="form-input w-full" placeholder="Emergency contact phone">
                            </div>
                            <div>
                                <label for="preferences" class="block text-sm font-semibold text-primary mb-2">Ride Preferences</label>
                                <textarea id="preferences" name="preferences" rows="4" class="form-input w-full" placeholder="Your ride preferences (music, temperature, etc.)">{{ $passengerProfile->preferences }}</textarea>
                            </div>
                            <button type="submit" class="btn-primary">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Update Profile
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 fade-in stagger-4">
                <div class="dashboard-card text-center p-6 group cursor-pointer">
                    <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-primary mb-2">Trip History</h4>
                    <p class="text-gray-600 text-sm">View your past rides and receipts</p>
                </div>

                <div class="dashboard-card text-center p-6 group cursor-pointer">
                    <div class="bg-yellow-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-primary mb-2">Payment Methods</h4>
                    <p class="text-gray-600 text-sm">Manage your payment options</p>
                </div>

                <div class="dashboard-card text-center p-6 group cursor-pointer">
                    <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-primary mb-2">Support</h4>
                    <p class="text-gray-600 text-sm">Get help with your account</p>
                </div>
            </div>
        </main>
    </div>
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

        // Form validation and enhancement
        const form = document.querySelector('form');
        const inputs = document.querySelectorAll('.form-input');
        
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
        
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