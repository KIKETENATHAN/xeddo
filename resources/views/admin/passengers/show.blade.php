<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Passenger Details - {{ $passenger->name }}</title>
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
                        <a href="{{ route('admin.passengers.index') }}" class="text-white hover:text-gray-200 mr-4 font-medium">
                            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Back to Passengers
                        </a>
                        <div class="text-xl font-semibold text-white">
                            <svg class="w-6 h-6 inline mr-2 text-secondary-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Passenger Details - {{ $passenger->name }}
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
                <!-- Passenger Details -->
                <div class="bg-primary-navy shadow-lg rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-600 gradient-gold">
                        <div class="flex items-center justify-between">
                            <h1 class="text-2xl font-bold text-white">
                                {{ $passenger->name }}
                            </h1>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.passengers.edit', $passenger) }}" class="bg-white text-primary-navy px-3 py-1 text-sm font-semibold rounded-full hover:bg-gray-100 transition-colors">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6">
                        <!-- Passenger Information -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-4">Passenger Information</h3>
                                <div class="grid grid-cols-1 gap-4">
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <label class="block text-sm font-medium text-secondary-gold">Full Name</label>
                                        <p class="text-lg font-semibold text-primary-navy mt-1">
                                            {{ $passenger->name }}
                                        </p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <label class="block text-sm font-medium text-secondary-gold">Email</label>
                                        <p class="text-lg font-semibold text-primary-navy mt-1">
                                            {{ $passenger->email }}
                                        </p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <label class="block text-sm font-medium text-secondary-gold">Phone</label>
                                        <p class="text-lg font-semibold text-primary-navy mt-1">
                                            {{ $passenger->phone }}
                                        </p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <label class="block text-sm font-medium text-secondary-gold">Registration Date</label>
                                        <p class="text-lg font-semibold text-primary-navy mt-1">
                                            {{ $passenger->created_at->format('M d, Y H:i A') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Statistics -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-4">Account Statistics</h3>
                                <div class="bg-white p-6 rounded-lg border border-gray-200">
                                    <div class="flex items-center mb-4">
                                        <div class="h-16 w-16 rounded-full bg-secondary-gold flex items-center justify-center mr-4">
                                            <span class="text-xl font-bold text-white">
                                                {{ substr($passenger->name, 0, 2) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-semibold text-primary-navy">
                                                {{ $passenger->name }}
                                            </h4>
                                            <p class="text-secondary-gold">ID: {{ $passenger->id }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 gap-3">
                                        <div class="flex justify-between">
                                            <span class="text-secondary-gold">Total Bookings:</span>
                                            <span class="text-primary-navy font-medium">{{ $passenger->bookings->count() }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-secondary-gold">Member Since:</span>
                                            <span class="text-primary-navy font-medium">
                                                {{ $passenger->created_at->format('M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings -->
                @if($passenger->bookings && $passenger->bookings->count() > 0)
                    <div class="mt-8 bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200 gradient-gold">
                            <h3 class="text-lg font-semibold text-white">Recent Bookings</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-gold uppercase tracking-wider">Booking ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-gold uppercase tracking-wider">Route</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-gold uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-gold uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-gold uppercase tracking-wider">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($passenger->bookings as $booking)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-primary-navy font-medium">
                                                    #{{ $booking->id }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-primary-navy font-medium">
                                                    {{ $booking->trip->from_location ?? 'N/A' }} → {{ $booking->trip->to_location ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-primary-navy font-medium">
                                                    {{ $booking->created_at->format('M d, Y') }}
                                                </div>
                                                <div class="text-sm text-secondary-gold">
                                                    {{ $booking->created_at->format('h:i A') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                                    @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-primary-navy font-medium">
                                                KSH {{ number_format($booking->amount ?? 0, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="mt-8 bg-white shadow-lg rounded-lg border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200 gradient-gold">
                            <h3 class="text-lg font-semibold text-white">Recent Bookings</h3>
                        </div>
                        <div class="p-6 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings</h3>
                            <p class="mt-1 text-sm text-gray-500">This passenger hasn't made any bookings yet.</p>
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
