<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vehicle Details - {{ $vehicle->vehicle_plate_number }}</title>
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

        .bg-primary-navy { background-color: var(--primary-navy); }
        .text-primary-navy { color: var(--primary-navy); }
        .bg-secondary-gold { background-color: var(--secondary-gold); }
        .text-secondary-gold { color: var(--secondary-gold); }
        .gradient-navy { background: var(--gradient-navy); }
        .gradient-gold { background: var(--gradient-gold); }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="gradient-navy shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('admin.vehicles.index') }}" class="text-white hover:text-gray-200 mr-4 font-medium">
                            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Back to Vehicles
                        </a>
                        <div class="text-xl font-semibold text-white">
                            <svg class="w-6 h-6 inline mr-2 text-secondary-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Vehicle Details - {{ $vehicle->vehicle_plate_number }}
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-white">Welcome, {{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-200 hover:text-white transition-colors">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <!-- Vehicle Details -->
                <div class="bg-primary-navy shadow-lg rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-600 gradient-gold">
                        <div class="flex items-center justify-between">
                            <h1 class="text-2xl font-bold text-white">
                                {{ $vehicle->vehicle_year }} {{ $vehicle->vehicle_make }} {{ $vehicle->vehicle_model }}
                            </h1>
                            <div class="flex space-x-2">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                    @if($vehicle->status === 'approved') bg-green-100 text-green-800 
                                    @elseif($vehicle->status === 'pending') bg-yellow-100 text-yellow-800 
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($vehicle->status) }}
                                </span>
                                @if($vehicle->status === 'approved')
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                        {{ $vehicle->is_available ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $vehicle->is_available ? 'Available' : 'Unavailable' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6">
                        <!-- Vehicle Information -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-4">Vehicle Information</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <label class="block text-sm font-medium text-secondary-gold">Plate Number</label>
                                        <p class="text-lg font-bold text-white bg-secondary-gold px-3 py-2 rounded-md mt-1">
                                            {{ $vehicle->vehicle_plate_number }}
                                        </p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <label class="block text-sm font-medium text-secondary-gold">Type</label>
                                        <p class="text-lg font-semibold text-primary-navy mt-1">
                                            {{ ucfirst($vehicle->vehicle_type) }}
                                        </p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <label class="block text-sm font-medium text-secondary-gold">Make</label>
                                        <p class="text-lg font-semibold text-primary-navy mt-1">
                                            {{ $vehicle->vehicle_make }}
                                        </p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <label class="block text-sm font-medium text-secondary-gold">Model</label>
                                        <p class="text-lg font-semibold text-primary-navy mt-1">
                                            {{ $vehicle->vehicle_model }}
                                        </p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <label class="block text-sm font-medium text-secondary-gold">Year</label>
                                        <p class="text-lg font-semibold text-primary-navy mt-1">
                                            {{ $vehicle->vehicle_year }}
                                        </p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <label class="block text-sm font-medium text-secondary-gold">Color</label>
                                        <p class="text-lg font-semibold text-primary-navy mt-1">
                                            {{ $vehicle->vehicle_color }}
                                        </p>
                                    </div>
                                </div>

                                @if($vehicle->vehicle_description)
                                    <div class="mt-4 bg-white p-4 rounded-lg border border-secondary-gold">
                                        <label class="block text-sm font-medium text-secondary-gold">Description</label>
                                        <p class="text-primary-navy mt-1">
                                            {{ $vehicle->vehicle_description }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Driver Information -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-4">Driver Information</h3>
                                <div class="bg-white p-6 rounded-lg border border-gray-200">
                                    <div class="flex items-center mb-4">
                                        <div class="h-16 w-16 rounded-full bg-secondary-gold flex items-center justify-center mr-4">
                                            <span class="text-xl font-bold text-white">
                                                {{ substr($vehicle->user->name, 0, 2) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-semibold text-primary-navy">
                                                {{ $vehicle->user->name }}
                                            </h4>
                                            <p class="text-secondary-gold">{{ $vehicle->user->email }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 gap-3">
                                        <div class="flex justify-between">
                                            <span class="text-secondary-gold">Phone:</span>
                                            <span class="text-primary-navy font-medium">{{ $vehicle->user->phone }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-secondary-gold">License Number:</span>
                                            <span class="text-primary-navy font-medium">{{ $vehicle->license_number }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-secondary-gold">License Expiry:</span>
                                            <span class="text-primary-navy font-medium">
                                                {{ $vehicle->license_expiry->format('M d, Y') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-secondary-gold">Total Trips:</span>
                                            <span class="text-primary-navy font-medium">{{ $vehicle->total_trips }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-secondary-gold">Rating:</span>
                                            <span class="text-primary-navy font-medium">
                                                {{ number_format($vehicle->rating, 1) }}/5.0
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SACCO Information -->
                            @if($vehicle->sacco)
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-4">SACCO Information</h3>
                                    <div class="bg-white p-6 rounded-lg border border-gray-200">
                                        <h4 class="text-lg font-semibold text-primary-navy mb-2">
                                            {{ $vehicle->sacco->name }}
                                        </h4>
                                        <div class="space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-secondary-gold">Location:</span>
                                                <span class="text-primary-navy font-medium">{{ $vehicle->sacco->location }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-secondary-gold">Route:</span>
                                                <span class="text-primary-navy font-medium">
                                                    {{ $vehicle->sacco->route_from }} → {{ $vehicle->sacco->route_to }}
                                                </span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-secondary-gold">Phone:</span>
                                                <span class="text-primary-navy font-medium">{{ $vehicle->sacco->phone_number }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Trips -->
                @if($vehicle->trips->count() > 0)
                    <div class="mt-8 bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200 gradient-gold">
                            <h3 class="text-lg font-semibold text-white">Recent Trips</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-gold uppercase tracking-wider">Route</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-gold uppercase tracking-wider">Date & Time</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-gold uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-gold uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-gold uppercase tracking-wider">Seats</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($vehicle->trips as $trip)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-primary-navy font-medium">
                                                    {{ $trip->from_location }} → {{ $trip->to_location }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-primary-navy font-medium">
                                                    {{ $trip->departure_time->format('M d, Y') }}
                                                </div>
                                                <div class="text-sm text-secondary-gold">
                                                    {{ $trip->departure_time->format('h:i A') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($trip->status === 'completed') bg-green-100 text-green-800
                                                    @elseif($trip->status === 'in_progress') bg-blue-100 text-blue-800
                                                    @elseif($trip->status === 'scheduled') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    {{ ucfirst($trip->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-primary-navy font-medium">
                                                KSH {{ number_format($trip->amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-primary-navy font-medium">
                                                {{ $trip->booked_seats }}/{{ $trip->available_seats }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
