<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Xeddo - Ride Sharing Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-primary">Xeddo</h1>
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
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-secondary-dark transition">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-primary hover:text-accent">
                                Log in
                            </a>
                            <a href="{{ route('register.passenger') }}" class="bg-secondary text-white px-4 py-2 rounded-md hover:bg-secondary-dark transition">
                                Register as Passenger
                            </a>
                            <a href="{{ route('register.driver') }}" class="bg-accent text-white px-4 py-2 rounded-md hover:bg-accent-dark transition">
                                Register as Driver
                            </a>
                        @endauth
                    </div>
                </div>
                <!-- Mobile menu -->
                <div id="mobile-menu" class="md:hidden hidden">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-200">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-primary hover:text-accent">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-primary hover:text-accent">
                                Log in
                            </a>
                            <a href="{{ route('register.passenger') }}" class="block px-3 py-2 rounded-md text-base font-medium bg-secondary text-white hover:bg-secondary-dark">
                                Register as Passenger
                            </a>
                            <a href="{{ route('register.driver') }}" class="block px-3 py-2 rounded-md text-base font-medium bg-accent text-white hover:bg-accent-dark">
                                Register as Driver
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-4xl font-bold text-primary mb-4">
                        Welcome to Xeddo Travel Link
                    </h2>
                    <p class="text-xl text-gray-600 mb-8">
                        Your reliable ride-sharing platform connecting passengers with drivers
                    </p>
                </div>

                <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Passenger Section -->
                    <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-200">
                        <div class="text-center">
                            <div class="bg-secondary/20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-semibold text-primary mb-2">
                                For Passengers
                            </h3>
                            <p class="text-gray-600 mb-6">
                                Book rides quickly and safely with verified drivers in your area
                            </p>
                            <div class="space-y-4">
                                <ul class="text-sm text-gray-600 space-y-2">
                                    <li>✓ Easy booking process</li>
                                    <li>✓ Real-time tracking</li>
                                    <li>✓ Safe and secure rides</li>
                                    <li>✓ Affordable pricing</li>
                                </ul>
                                <a href="{{ route('register.passenger') }}" class="w-full bg-secondary text-white px-4 py-2 rounded-md hover:bg-secondary-dark transition inline-block text-center">
                                    Get Started as Passenger
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Driver Section -->
                    <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-200">
                        <div class="text-center">
                            <div class="bg-accent/20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-semibold text-primary mb-2">
                                For Drivers
                            </h3>
                            <p class="text-gray-600 mb-6">
                                Earn money by providing rides to passengers in your area
                            </p>
                            <div class="space-y-4">
                                <ul class="text-sm text-gray-600 space-y-2">
                                    <li>✓ Flexible working hours</li>
                                    <li>✓ Competitive earnings</li>
                                    <li>✓ Driver support</li>
                                    <li>✓ Easy registration</li>
                                </ul>
                                <a href="{{ route('register.driver') }}" class="w-full bg-accent text-white px-4 py-2 rounded-md hover:bg-accent-dark transition inline-block text-center">
                                    Start Driving
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center">
                    <p class="text-gray-500">
                        © 2025 Xeddo. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
