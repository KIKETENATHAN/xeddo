<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Driver Dashboard - Xeddo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold text-primary">Driver Dashboard</h1>
                    </div>
                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button id="mobile-menu-button" class="text-primary hover:text-accent focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Desktop menu -->
                    <div class="hidden md:flex items-center space-x-4">
                        <span class="text-gray-700">Welcome, {{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-accent">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Mobile menu -->
                <div id="mobile-menu" class="md:hidden hidden">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-200">
                        <div class="block px-3 py-2 rounded-md text-base font-medium text-gray-700">
                            Welcome, {{ auth()->user()->name }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-500 hover:text-accent">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Stats Cards -->
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-primary overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-300 truncate">Total Trips</dt>
                                            <dd class="text-lg font-medium text-white">{{ $stats['total_trips'] }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-primary overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-300 truncate">Rating</dt>
                                            <dd class="text-lg font-medium text-white">{{ number_format($stats['rating'], 1) }}/5.0</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-primary overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        @if($stats['status'] === 'approved')
                                            <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @elseif($stats['status'] === 'pending')
                                            <svg class="h-6 w-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else
                                            <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-300 truncate">Status</dt>
                                            <dd class="text-lg font-medium text-white capitalize">{{ $stats['status'] }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Availability Toggle -->
                    @if($stats['status'] === 'approved')
                        <div class="bg-primary overflow-hidden shadow rounded-lg mb-6">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium text-white">Availability Status</h3>
                                        <p class="text-sm text-gray-300">Toggle your availability to receive ride requests</p>
                                    </div>
                                    <form method="POST" action="{{ route('driver.toggle.availability') }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="relative inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white {{ $stats['is_available'] ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-600 hover:bg-gray-700' }}">
                                            {{ $stats['is_available'] ? 'Available' : 'Unavailable' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Vehicle Information -->
                    <div class="bg-primary overflow-hidden shadow rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-white mb-4">Vehicle Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-300">Vehicle</p>
                                    <p class="text-lg font-medium text-white">{{ $driverProfile->vehicle_year }} {{ $driverProfile->vehicle_make }} {{ $driverProfile->vehicle_model }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-300">Plate Number</p>
                                    <p class="text-lg font-medium text-white">{{ $driverProfile->vehicle_plate_number }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-300">Color</p>
                                    <p class="text-lg font-medium text-white">{{ $driverProfile->vehicle_color }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-300">Type</p>
                                    <p class="text-lg font-medium text-white">{{ $driverProfile->vehicle_type }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Section -->
                <div class="bg-primary overflow-hidden shadow rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-white mb-4">Driver Profile</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-300">License Number</p>
                                <p class="text-lg font-medium text-white">{{ $driverProfile->license_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-300">License Expiry</p>
                                <p class="text-lg font-medium text-white">{{ $driverProfile->license_expiry->format('M d, Y') }}</p>
                            </div>
                            @if($driverProfile->vehicle_description)
                                <div>
                                    <p class="text-sm text-gray-300">Vehicle Description</p>
                                    <p class="text-lg font-medium text-white">{{ $driverProfile->vehicle_description }}</p>
                                </div>
                            @endif
                            
                            @if($stats['status'] === 'pending')
                                <div class="mt-4 p-4 bg-yellow-50 rounded-lg">
                                    <p class="text-sm text-yellow-800">
                                        Your driver profile is under review. You'll be notified once it's approved.
                                    </p>
                                </div>
                            @elseif($stats['status'] === 'rejected')
                                <div class="mt-4 p-4 bg-red-50 rounded-lg">
                                    <p class="text-sm text-red-800">
                                        Your driver profile has been rejected. Please contact support for more information.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
