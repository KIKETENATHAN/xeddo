<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Passenger Management - Xeddo Travel Link</title>
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
                        <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-gray-200 mr-4 font-medium">
                            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Back to Dashboard
                        </a>
                        <div class="text-xl font-semibold text-white">
                            <svg class="w-6 h-6 inline mr-2 text-secondary-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Passenger Management
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
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-primary-navy text-white p-6 rounded-lg shadow-lg">
                        <div class="flex items-center">
                            <div class="bg-secondary-gold rounded-full p-3 mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-200">Total Passengers</p>
                                <p class="text-2xl font-bold">{{ $totalPassengers }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white text-primary-navy p-6 rounded-lg shadow-lg border border-secondary-gold">
                        <div class="flex items-center">
                            <div class="bg-green-500 rounded-full p-3 mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-secondary-gold">Active Passengers</p>
                                <p class="text-2xl font-bold">{{ $activePassengers }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white text-primary-navy p-6 rounded-lg shadow-lg border border-secondary-gold">
                        <div class="flex items-center">
                            <div class="bg-yellow-500 rounded-full p-3 mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-secondary-gold">Inactive Passengers</p>
                                <p class="text-2xl font-bold">{{ $inactivePassengers }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions and Filters -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 gradient-gold">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <h3 class="text-lg font-semibold text-white mb-4 md:mb-0">Passenger List</h3>
                            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                                <a href="{{ route('admin.passengers.create') }}" class="bg-white text-primary-navy px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors text-center">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Passenger
                                </a>
                                <a href="{{ route('admin.passengers.export-pdf', request()->query()) }}" class="bg-white text-primary-navy px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors text-center">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    Export PDF
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-secondary-gold mb-1">Search</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, or phone..." 
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-navy">
                            </div>
                            <div class="flex items-end space-x-2">
                                <button type="submit" class="bg-primary-navy text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                    Filter
                                </button>
                                <a href="{{ route('admin.passengers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-600 transition-colors">
                                    Clear
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Passengers Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-gold uppercase tracking-wider">Passenger</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-gold uppercase tracking-wider">Contact</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-gold uppercase tracking-wider">Registration Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-gold uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($passengers as $passenger)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-full bg-secondary-gold flex items-center justify-center mr-3">
                                                    <span class="text-sm font-bold text-white">
                                                        {{ substr($passenger->name, 0, 2) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-primary-navy">{{ $passenger->name }}</div>
                                                    <div class="text-sm text-gray-500">ID: {{ $passenger->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-primary-navy">{{ $passenger->email }}</div>
                                            <div class="text-sm text-gray-500">{{ $passenger->phone }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-primary-navy">
                                            {{ $passenger->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('admin.passengers.show', $passenger) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                            <a href="{{ route('admin.passengers.edit', $passenger) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            
                                            <form method="POST" action="{{ route('admin.passengers.destroy', $passenger) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" 
                                                        onclick="return confirm('Are you sure you want to delete this passenger?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No passengers found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($passengers->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200">
                            {{ $passengers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>
