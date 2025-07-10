<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Passenger Dashboard - Xeddo Travel Link</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
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

        /* Modal Styles */
        .booking-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .booking-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .booking-modal-content {
            background: white;
            border-radius: 1rem;
            max-width: 90vw;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: modalSlideIn 0.3s ease-out;
            width: 100%;
            max-width: 500px;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
            padding: 0.5rem;
            margin-left: auto;
        }

        .modal-close:hover {
            color: #374151;
        }

        .modal-body {
            padding: 2rem;
        }

        .payment-status {
            text-align: center;
            padding: 2rem;
        }

        .payment-status .icon {
            margin: 0 auto 1rem;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .payment-status .icon.processing {
            background: rgba(59, 130, 246, 0.1);
        }

        .payment-status .icon.success {
            background: rgba(34, 197, 94, 0.1);
        }

        .payment-status .icon.failed {
            background: rgba(239, 68, 68, 0.1);
        }

        .spinner-payment {
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-navy);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .receipt {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1.5rem;
            text-align: left;
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
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
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
                        <x-application-logo type="icon" size="small" class="mr-3" />
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
                                <p class="text-gray-600">Enter your pickup, destination, and travel time to find available trips from all SACCOs</p>
                            </div>
                            <form method="POST" action="{{ route('passenger.search.rides') }}" class="space-y-6">
                                @csrf
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
                                <div>
                                    <label for="travel_time" class="block text-sm font-semibold text-primary mb-2">Travel Time</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <input type="datetime-local" id="travel_time" name="travel_time" value="{{ old('travel_time', $searchParams['travel_time'] ?? '') }}" class="form-input w-full pl-10" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn-secondary">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Find Available Rides from All SACCOs
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
                                                        <button onclick="initiateBooking({{ $trip->id }})" class="book-btn" data-trip='@json($trip->load(['driver.user', 'sacco']))'>
                                                            Book Now
                                                        </button>
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
                                <p class="text-gray-600">Sorry, no rides match your search criteria. Try adjusting your pickup location, destination, or travel time.</p>
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

    <!-- Booking/Payment Modal -->
    <div id="bookingPaymentModal" class="booking-modal">
        <div class="booking-modal-content">
            <div class="modal-header">
                <h2 class="text-2xl font-bold">Complete Your Booking</h2>
                <button class="modal-close" onclick="closeBookingPaymentModal()">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Booking Form -->
                <div id="bookingForm" class="space-y-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-primary mb-2">Trip Details</h3>
                        <div id="tripDetails" class="text-sm text-gray-600">
                            <!-- Trip details will be populated here -->
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="passengerName" class="block text-sm font-semibold text-primary mb-2">Full Name</label>
                            <input type="text" id="passengerName" name="passenger_name" class="form-input" placeholder="{{ Auth::user()->name }}" value="{{ Auth::user()->name }}" required>
                        </div>
                        
                        <div>
                            <label for="passengerEmail" class="block text-sm font-semibold text-primary mb-2">Email Address</label>
                            <input type="email" id="passengerEmail" name="passenger_email" class="form-input" placeholder="{{ Auth::user()->email }}" value="{{ Auth::user()->email }}" required>
                        </div>
                        
                        <div>
                            <label for="passengerPhone" class="block text-sm font-semibold text-primary mb-2">Phone Number</label>
                            <input type="tel" id="passengerPhone" name="passenger_phone" class="form-input" placeholder="254712345678" required>
                            <p class="text-xs text-gray-500 mt-1">Enter your M-Pesa phone number</p>
                        </div>
                        
                        <div>
                            <label for="seatsCount" class="block text-sm font-semibold text-primary mb-2">Number of Seats</label>
                            <select id="seatsCount" name="seats" class="form-input" required>
                                <option value="1">1 Seat</option>
                                <option value="2">2 Seats</option>
                                <option value="3">3 Seats</option>
                                <option value="4">4 Seats</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold">Total Amount:</span>
                            <span id="totalAmount" class="text-2xl font-bold text-secondary">KES 0</span>
                        </div>
                        <p class="text-sm text-gray-600">Payment will be processed via M-Pesa STK Push</p>
                    </div>
                    
                    <button id="initiatePaymentBtn" class="btn-primary w-full">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        Proceed to Payment
                    </button>
                </div>
                
                <!-- Payment Processing -->
                <div id="paymentProcessing" class="payment-status" style="display: none;">
                    <div class="icon processing">
                        <div class="spinner-payment"></div>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-2">Processing Payment</h3>
                    <p class="text-gray-600 mb-4">Please complete the payment on your phone. Check your M-Pesa notifications and enter your PIN.</p>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">
                            <strong>Amount:</strong> <span id="processingAmount"></span><br>
                            <strong>Phone:</strong> <span id="processingPhone"></span><br>
                            <strong>Reference:</strong> <span id="processingReference"></span>
                        </p>
                    </div>
                </div>
                
                <!-- Payment Success -->
                <div id="paymentSuccess" class="payment-status" style="display: none;">
                    <div class="icon success">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-green-600 mb-2">Payment Successful!</h3>
                    <p class="text-gray-600 mb-4">Your booking has been confirmed. Here's your receipt:</p>
                    
                    <div id="receiptContainer" class="receipt">
                        <!-- Receipt will be populated here -->
                    </div>
                    
                    <div class="flex gap-3 mt-6">
                        <button onclick="downloadReceipt()" class="btn-secondary flex-1">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download Receipt
                        </button>
                        <button onclick="closeBookingPaymentModal()" class="btn-primary flex-1">
                            Close
                        </button>
                    </div>
                </div>
                
                <!-- Payment Failed -->
                <div id="paymentFailed" class="payment-status" style="display: none;">
                    <div class="icon failed">
                        <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-red-600 mb-2">Payment Failed</h3>
                    <p class="text-gray-600 mb-4" id="paymentErrorMessage">The payment could not be processed. Please try again.</p>
                    
                    <div class="flex gap-3 mt-6">
                        <button onclick="retryPayment()" class="btn-secondary flex-1">
                            Try Again
                        </button>
                        <button onclick="closeBookingPaymentModal()" class="btn-primary flex-1">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables for booking
        let selectedTrip = null;
        let bookingData = null;
        let paymentStatusInterval = null;

        // Initiate booking process
        function initiateBooking(tripId) {
            // Find the button that was clicked to get trip data
            const button = document.querySelector(`button[onclick="initiateBooking(${tripId})"]`);
            if (!button) {
                alert('Trip information not found. Please try again.');
                return;
            }
            
            selectedTrip = JSON.parse(button.getAttribute('data-trip'));
            selectedTrip.formatted_amount = 'KSH ' + parseFloat(selectedTrip.amount).toLocaleString();
            selectedTrip.remaining_seats = selectedTrip.available_seats - selectedTrip.booked_seats;
            
            openBookingPaymentModal();
        }

        // Open booking/payment modal
        function openBookingPaymentModal() {
            if (!selectedTrip) {
                alert('Please select a trip first.');
                return;
            }

            document.getElementById('bookingPaymentModal').classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Populate trip details
            populateTripDetails(selectedTrip);
            
            // Show booking form
            showBookingForm();
            
            // Update total amount when seats change
            document.getElementById('seatsCount').addEventListener('change', updateTotalAmount);
            updateTotalAmount();
        }

        // Close booking/payment modal
        function closeBookingPaymentModal() {
            document.getElementById('bookingPaymentModal').classList.remove('active');
            document.body.style.overflow = 'auto';
            
            // Clear any payment status interval
            if (paymentStatusInterval) {
                clearInterval(paymentStatusInterval);
                paymentStatusInterval = null;
            }
            
            // Reset form
            resetBookingForm();
        }

        // Populate trip details
        function populateTripDetails(trip) {
            const departureDate = new Date(trip.departure_time);
            const formattedDate = departureDate.toLocaleDateString('en-US', { 
                weekday: 'long',
                year: 'numeric',
                month: 'long', 
                day: 'numeric' 
            });
            const formattedTime = departureDate.toLocaleTimeString('en-US', { 
                hour: 'numeric', 
                minute: '2-digit',
                hour12: true 
            });
            
            const tripDetailsHtml = '<div class="grid grid-cols-1 md:grid-cols-2 gap-4">' +
                '<div>' +
                '<strong>SACCO:</strong> ' + trip.sacco.name + '<br>' +
                '<strong>Driver:</strong> ' + trip.driver.user.name + '<br>' +
                '<strong>Route:</strong> ' + trip.from_location + ' to ' + trip.to_location +
                '</div>' +
                '<div>' +
                '<strong>Departure:</strong> ' + formattedDate + '<br>' +
                '<strong>Time:</strong> ' + formattedTime + '<br>' +
                '<strong>Price per seat:</strong> ' + trip.formatted_amount +
                '</div>' +
                '</div>';
            
            document.getElementById('tripDetails').innerHTML = tripDetailsHtml;
        }

        // Update total amount
        function updateTotalAmount() {
            const seats = parseInt(document.getElementById('seatsCount').value) || 1;
            const totalAmount = selectedTrip.amount * seats;
            document.getElementById('totalAmount').textContent = 'KES ' + totalAmount.toLocaleString();
        }

        // Show booking form
        function showBookingForm() {
            document.getElementById('bookingForm').style.display = 'block';
            document.getElementById('paymentProcessing').style.display = 'none';
            document.getElementById('paymentSuccess').style.display = 'none';
            document.getElementById('paymentFailed').style.display = 'none';
        }

        // Reset booking form
        function resetBookingForm() {
            document.getElementById('bookingForm').reset();
            selectedTrip = null;
            bookingData = null;
            showBookingForm();
        }

        // Handle payment initiation
        document.getElementById('initiatePaymentBtn').addEventListener('click', async function() {
            const form = document.getElementById('bookingForm');
            const formData = new FormData(form);
            
            // Validate form
            const passengerName = formData.get('passenger_name') || document.getElementById('passengerName').value;
            const passengerEmail = formData.get('passenger_email') || document.getElementById('passengerEmail').value;
            const passengerPhone = formData.get('passenger_phone') || document.getElementById('passengerPhone').value;
            const seats = parseInt(formData.get('seats') || document.getElementById('seatsCount').value);
            
            if (!passengerName || !passengerEmail || !passengerPhone || !seats) {
                alert('Please fill in all required fields.');
                return;
            }
            
            // Format phone number
            let phone = passengerPhone.replace(/\D/g, '');
            if (phone.startsWith('0')) {
                phone = '254' + phone.substring(1);
            } else if (!phone.startsWith('254')) {
                phone = '254' + phone;
            }
            
            const bookingRequest = {
                trip_id: selectedTrip.id,
                passenger_name: passengerName,
                passenger_email: passengerEmail,
                passenger_phone: phone,
                seats: seats
            };
            
            try {
                showPaymentProcessing();
                
                const response = await fetch('/api/initiate-booking', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(bookingRequest)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    bookingData = result;
                    
                    // Update processing details
                    document.getElementById('processingAmount').textContent = 'KES ' + result.amount.toLocaleString();
                    document.getElementById('processingPhone').textContent = phone;
                    document.getElementById('processingReference').textContent = result.booking_reference;
                    
                    // Start checking payment status
                    startPaymentStatusCheck(result.checkout_request_id);
                } else {
                    showPaymentFailed(result.message || 'Failed to initiate payment');
                }
                
            } catch (error) {
                console.error('Booking error:', error);
                showPaymentFailed('An error occurred while processing your booking');
            }
        });

        // Show payment processing
        function showPaymentProcessing() {
            document.getElementById('bookingForm').style.display = 'none';
            document.getElementById('paymentProcessing').style.display = 'block';
            document.getElementById('paymentSuccess').style.display = 'none';
            document.getElementById('paymentFailed').style.display = 'none';
        }

        // Start payment status check
        function startPaymentStatusCheck(checkoutRequestId) {
            let attempts = 0;
            const maxAttempts = 60; // 5 minutes max (5 second intervals)
            
            paymentStatusInterval = setInterval(async () => {
                attempts++;
                
                if (attempts > maxAttempts) {
                    clearInterval(paymentStatusInterval);
                    showPaymentFailed('Payment timeout. Please try again.');
                    return;
                }
                
                try {
                    const response = await fetch('/api/check-payment-status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({
                            checkout_request_id: checkoutRequestId
                        })
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        if (result.payment_status === 'completed') {
                            clearInterval(paymentStatusInterval);
                            showPaymentSuccess(result.receipt_data);
                        } else if (result.payment_status === 'failed') {
                            clearInterval(paymentStatusInterval);
                            showPaymentFailed(result.message || 'Payment failed');
                        }
                        // Continue checking if status is still 'processing'
                    }
                } catch (error) {
                    console.error('Payment status check error:', error);
                    // Continue checking
                }
            }, 5000); // Check every 5 seconds
        }

        // Show payment success
        function showPaymentSuccess(receiptData) {
            document.getElementById('bookingForm').style.display = 'none';
            document.getElementById('paymentProcessing').style.display = 'none';
            document.getElementById('paymentSuccess').style.display = 'block';
            document.getElementById('paymentFailed').style.display = 'none';
            
            // Populate receipt
            if (receiptData) {
                document.getElementById('receiptContainer').innerHTML = receiptData;
            }
        }

        // Show payment failed
        function showPaymentFailed(message) {
            document.getElementById('bookingForm').style.display = 'none';
            document.getElementById('paymentProcessing').style.display = 'none';
            document.getElementById('paymentSuccess').style.display = 'none';
            document.getElementById('paymentFailed').style.display = 'block';
            
            document.getElementById('paymentErrorMessage').textContent = message;
        }

        // Retry payment
        function retryPayment() {
            showBookingForm();
        }

        // Download receipt
        function downloadReceipt() {
            // Implementation for receipt download
            window.print();
        }

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
            
            // Set minimum time for travel_time input to current date and time
            const travelTimeInput = document.getElementById('travel_time');
            if (travelTimeInput) {
                const now = new Date();
                now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                travelTimeInput.min = now.toISOString().slice(0, 16);
            }
        });
    </script>
</body>
</html>