<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vehicle Management - Admin Dashboard</title>
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
        
        .btn-primary {
            background: var(--gradient-navy);
            color: white;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(30, 58, 138, 0.3);
        }
        
        .btn-secondary {
            background: var(--gradient-gold);
            color: white;
            transition: all 0.3s;
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="gradient-navy shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="text-xl font-semibold text-white">
                            <svg class="w-6 h-6 inline mr-2 text-secondary-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Vehicle Management
                        </a>
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
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded shadow">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="px-4 py-6 sm:px-0">
                <!-- Header -->
                <div class="border-b border-gray-200 pb-6 mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <div class="flex items-center mb-2">
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="inline-flex items-center text-primary-navy hover:text-blue-800 mr-4 font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    Back to Dashboard
                                </a>
                            </div>
                            <h1 class="text-3xl font-bold text-primary-navy mb-2">Vehicle Management</h1>
                            <p class="text-gray-600">Manage all registered vehicles and their details</p>
                        </div>
                        <div class="mt-4 sm:mt-0 flex space-x-3">
                            <a href="{{ route('admin.vehicles.create') }}" 
                               class="inline-flex items-center px-4 py-2 rounded-md font-semibold btn-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add New Vehicle
                            </a>
                            <a href="{{ route('admin.vehicles.export', request()->query()) }}" 
                               class="inline-flex items-center px-4 py-2 rounded-md font-semibold btn-secondary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Export CSV
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <form method="GET" action="{{ route('admin.vehicles.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-primary-navy mb-1">Search</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" 
                                   placeholder="Search vehicles, drivers..." 
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-primary-navy focus:border-primary-navy">
                        </div>

                        <div>
                            <label for="vehicle_type" class="block text-sm font-medium text-primary-navy mb-1">Vehicle Type</label>
                            <select id="vehicle_type" name="vehicle_type" 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-primary-navy focus:border-primary-navy">
                                <option value="">All Types</option>
                                @foreach($vehicleTypes as $type)
                                    <option value="{{ $type }}" {{ request('vehicle_type') == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-primary-navy mb-1">Driver Status</label>
                            <select id="status" name="status" 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-primary-navy focus:border-primary-navy">
                                <option value="">All Statuses</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div>
                            <label for="sacco_id" class="block text-sm font-medium text-primary-navy mb-1">SACCO</label>
                            <select id="sacco_id" name="sacco_id" 
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-primary-navy focus:border-primary-navy">
                                <option value="">All SACCOs</option>
                                @foreach($saccos as $sacco)
                                    <option value="{{ $sacco->id }}" {{ request('sacco_id') == $sacco->id ? 'selected' : '' }}>
                                        {{ $sacco->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-4 flex justify-end space-x-3">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 rounded-md font-semibold btn-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Filter
                            </button>
                            <a href="{{ route('admin.vehicles.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors font-semibold">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-primary-navy rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center">
                            <div class="bg-secondary-gold rounded-full p-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-200">Total Vehicles</p>
                                <p class="text-2xl font-bold text-white">{{ $vehicles->total() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-primary-navy rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center">
                            <div class="bg-green-500 rounded-full p-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-200">Approved</p>
                                <p class="text-2xl font-bold text-white">
                                    {{ $vehicles->where('status', 'approved')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-primary-navy rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center">
                            <div class="bg-yellow-500 rounded-full p-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-200">Pending</p>
                                <p class="text-2xl font-bold text-white">
                                    {{ $vehicles->where('status', 'pending')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-primary-navy rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center">
                            <div class="bg-blue-500 rounded-full p-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-200">Available</p>
                                <p class="text-2xl font-bold text-white">
                                    {{ $vehicles->where('is_available', true)->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vehicles Table -->
                <div class="bg-primary-navy shadow-lg overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-600">
                        <h3 class="text-lg leading-6 font-medium text-white">Registered Vehicles</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-200">
                            Complete list of all vehicles registered in the system
                        </p>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-600">
                            <thead class="bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Driver</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Vehicle Details</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Plate Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">SACCO</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-primary-navy divide-y divide-gray-600">
                                @forelse($vehicles as $vehicle)
                                    <tr class="hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-secondary-gold flex items-center justify-center">
                                                        <span class="text-sm font-medium text-white">
                                                            {{ substr($vehicle->user->name, 0, 2) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-white">
                                                        {{ $vehicle->user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-300">
                                                        {{ $vehicle->user->email }}
                                                    </div>
                                                    <div class="text-sm text-gray-300">
                                                        {{ $vehicle->user->phone }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-white">
                                                {{ $vehicle->vehicle_year }} {{ $vehicle->vehicle_make }} {{ $vehicle->vehicle_model }}
                                            </div>
                                            <div class="text-sm text-gray-300">
                                                {{ ucfirst($vehicle->vehicle_type) }} • {{ $vehicle->vehicle_color }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-primary-navy bg-secondary-gold px-3 py-1 rounded-md inline-block">
                                                {{ $vehicle->vehicle_plate_number }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($vehicle->sacco)
                                                <div class="text-sm text-white">{{ $vehicle->sacco->name }}</div>
                                                <div class="text-sm text-gray-300">{{ $vehicle->sacco->location }}</div>
                                            @else
                                                <span class="text-sm text-gray-500 dark:text-gray-400">No SACCO assigned</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col space-y-1">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($vehicle->status === 'approved') bg-green-100 text-green-800 
                                                    @elseif($vehicle->status === 'pending') bg-yellow-100 text-yellow-800 
                                                    @else bg-red-100 text-red-800 @endif">
                                                    {{ ucfirst($vehicle->status) }}
                                                </span>
                                                @if($vehicle->status === 'approved')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ $vehicle->is_available ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                                        {{ $vehicle->is_available ? 'Available' : 'Unavailable' }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('admin.vehicles.show', $vehicle) }}" 
                                               class="text-blue-600 hover:text-blue-900 bg-blue-100 px-3 py-1 rounded">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            <p class="text-lg font-medium">No vehicles found</p>
                                            <p class="text-sm">Try adjusting your search criteria or check back later.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($vehicles->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                            {{ $vehicles->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>
