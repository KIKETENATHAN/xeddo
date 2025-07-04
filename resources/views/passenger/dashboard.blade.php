<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Passenger Dashboard - Xeddo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold text-primary">Passenger Dashboard</h1>
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
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
                    </div>

                    <!-- Book a Ride -->
                    <div class="bg-primary overflow-hidden shadow rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-white mb-4">Book a Ride</h3>
                            <form class="space-y-4">
                                <div>
                                    <label for="pickup" class="block text-sm font-medium text-gray-300">Pickup Location</label>
                                    <input type="text" id="pickup" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-secondary focus:border-secondary bg-white text-gray-900" placeholder="Enter pickup location">
                                </div>
                                <div>
                                    <label for="destination" class="block text-sm font-medium text-gray-300">Destination</label>
                                    <input type="text" id="destination" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-secondary focus:border-secondary bg-white text-gray-900" placeholder="Enter destination">
                                </div>
                                <button type="submit" class="w-full bg-secondary text-white py-2 px-4 rounded-md hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-secondary">
                                    Find Rides
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Profile Section -->
                <div class="bg-primary overflow-hidden shadow rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-white mb-4">Profile Information</h3>
                        <form method="POST" action="{{ route('passenger.profile.update') }}" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            <div>
                                <label for="emergency_contact_name" class="block text-sm font-medium text-gray-300">Emergency Contact Name</label>
                                <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="{{ $passengerProfile->emergency_contact_name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-secondary focus:border-secondary bg-white text-gray-900" placeholder="Emergency contact name">
                            </div>
                            <div>
                                <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-300">Emergency Contact Phone</label>
                                <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" value="{{ $passengerProfile->emergency_contact_phone }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-secondary focus:border-secondary bg-white text-gray-900" placeholder="Emergency contact phone">
                            </div>
                            <div>
                                <label for="preferences" class="block text-sm font-medium text-gray-300">Preferences</label>
                                <textarea id="preferences" name="preferences" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-secondary focus:border-secondary bg-white text-gray-900" placeholder="Your preferences...">{{ $passengerProfile->preferences }}</textarea>
                            </div>
                            <button type="submit" class="w-full bg-secondary text-white py-2 px-4 rounded-md hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-secondary">
                                Update Profile
                            </button>
                        </form>
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
