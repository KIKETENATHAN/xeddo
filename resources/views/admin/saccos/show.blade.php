<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View SACCO - Xeddo Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Assets -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-ogBwu_Df.css') }}">
    <script type="module" src="{{ asset('build/assets/app-DaBYqt0m.js') }}"></script>
    <style>
        :root {
            --primary-navy: #1e3a8a;
            --primary-navy-dark: #1e40af;
            --secondary-gold: #f59e0b;
            --secondary-gold-dark: #d97706;
            --accent-gold: #fbbf24;
            --gradient-navy: linear-gradient(135deg, #1e3a8a 0%, #3730a3 100%);
            --gradient-gold: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

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

        .bg-primary { background-color: var(--primary-navy); }
        .bg-secondary { background-color: var(--secondary-gold); }
        .text-primary { color: var(--primary-navy); }
        .text-secondary { color: var(--secondary-gold); }
        .gradient-navy { background: var(--gradient-navy); }
        .gradient-gold { background: var(--gradient-gold); }

        .hero-section {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            position: relative;
            overflow-x: hidden;
            min-height: 100vh;
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

        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(30, 58, 138, 0.1);
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

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-active {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .status-inactive {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
        }

        .info-item {
            background: rgba(30, 58, 138, 0.05);
            padding: 1.5rem;
            border-radius: 0.75rem;
            border: 1px solid rgba(30, 58, 138, 0.1);
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background: rgba(30, 58, 138, 0.1);
            transform: translateY(-2px);
        }

        .driver-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(30, 58, 138, 0.1);
        }

        .driver-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h1 class="text-xl font-bold text-primary">SACCO Details</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.saccos.index') }}" class="text-primary hover:text-primary-dark px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                            ← Back to SACCOs
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-primary hover:text-primary-dark px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Header -->
            <div class="mb-8 flex justify-between items-start">
                <div>
                    <h2 class="text-3xl font-bold text-primary">{{ $sacco->name }}</h2>
                    <p class="text-gray-600 mt-2">Transportation Cooperative Details</p>
                </div>
                <div class="flex space-x-3">
                    <span class="status-badge status-{{ $sacco->is_active ? 'active' : 'inactive' }}">
                        {{ $sacco->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    <a href="{{ route('admin.saccos.edit', $sacco) }}" class="btn-secondary">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit SACCO
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- SACCO Information -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Basic Information -->
                    <div class="card p-8">
                        <h3 class="text-2xl font-bold text-primary mb-6">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="info-item">
                                <h4 class="text-sm font-semibold text-primary mb-1">SACCO Name</h4>
                                <p class="text-lg font-medium text-gray-800">{{ $sacco->name }}</p>
                            </div>
                            <div class="info-item">
                                <h4 class="text-sm font-semibold text-primary mb-1">Phone Number</h4>
                                <p class="text-lg font-medium text-gray-800">{{ $sacco->phone_number }}</p>
                            </div>
                            <div class="info-item">
                                <h4 class="text-sm font-semibold text-primary mb-1">Location</h4>
                                <p class="text-lg font-medium text-gray-800">{{ $sacco->location }}</p>
                            </div>
                            <div class="info-item">
                                <h4 class="text-sm font-semibold text-primary mb-1">Route</h4>
                                <p class="text-lg font-medium text-gray-800">{{ $sacco->full_route }}</p>
                            </div>
                        </div>
                        @if($sacco->description)
                            <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <h4 class="text-sm font-semibold text-primary mb-2">Description</h4>
                                <p class="text-gray-700">{{ $sacco->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Registered Drivers -->
                    <div class="card p-8">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-2xl font-bold text-primary">Registered Drivers</h3>
                            <span class="text-sm text-gray-500">{{ $sacco->drivers->count() }} total drivers</span>
                        </div>
                        
                        @if($sacco->drivers->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($sacco->drivers as $driver)
                                    <div class="driver-card p-4">
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 bg-gradient-navy rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="text-lg font-semibold text-gray-900">{{ $driver->user->name }}</h4>
                                                <p class="text-sm text-gray-500">{{ $driver->user->email }}</p>
                                                <div class="mt-2 flex items-center space-x-4">
                                                    <span class="status-badge status-{{ $driver->status === 'approved' ? 'active' : 'inactive' }}">
                                                        {{ ucfirst($driver->status) }}
                                                    </span>
                                                    @if($driver->is_available)
                                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Available</span>
                                                    @else
                                                        <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded-full">Unavailable</span>
                                                    @endif
                                                </div>
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-600">
                                                        {{ $driver->vehicle_year }} {{ $driver->vehicle_make }} {{ $driver->vehicle_model }}
                                                    </p>
                                                    <p class="text-sm text-gray-600">{{ $driver->vehicle_plate_number }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No Drivers Registered</h3>
                                <p class="text-gray-500">This SACCO doesn't have any registered drivers yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Statistics Sidebar -->
                <div class="space-y-6">
                    <!-- Driver Statistics -->
                    <div class="stat-card">
                        <div class="p-6 relative z-10">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-medium text-blue-200 mb-2">Total Drivers</h3>
                                <p class="text-4xl font-bold text-white">{{ $sacco->drivers->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Active Drivers -->
                    <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <div class="p-6 relative z-10">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-medium text-green-200 mb-2">Active Drivers</h3>
                                <p class="text-4xl font-bold text-white">{{ $sacco->drivers->where('status', 'approved')->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Available Drivers -->
                    <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <div class="p-6 relative z-10">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-medium text-yellow-200 mb-2">Available Now</h3>
                                <p class="text-4xl font-bold text-white">{{ $sacco->drivers->where('is_available', true)->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- SACCO Info Card -->
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold text-primary mb-4">SACCO Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Created:</span>
                                <span class="text-sm font-medium">{{ $sacco->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Last Updated:</span>
                                <span class="text-sm font-medium">{{ $sacco->updated_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Status:</span>
                                <span class="status-badge status-{{ $sacco->is_active ? 'active' : 'inactive' }}">
                                    {{ $sacco->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
