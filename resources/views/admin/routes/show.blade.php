<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Route Details - Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary-navy: #1e3a8a;
            --primary-navy-dark: #1e40af;
            --secondary-gold: #f59e0b;
            --secondary-gold-dark: #d97706;
            --accent-gold: #fbbf24;
            --gradient-navy: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            --gradient-gold: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-primary {
            background: var(--gradient-navy);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.4);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }

        .admin-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(30, 58, 138, 0.1);
        }

        .navigation-link {
            color: #6366f1;
            font-weight: 500;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .navigation-link:hover {
            background-color: #f0f9ff;
            color: #1e40af;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-active {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-inactive {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-item {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
        }

        .info-label {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1.125rem;
            color: #1f2937;
            font-weight: 600;
        }

        .route-header {
            text-align: center;
            padding: 2rem;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: 1rem;
            margin-bottom: 2rem;
        }

        .route-title {
            font-size: 2rem;
            font-weight: 700;
            color: #0369a1;
            margin-bottom: 0.5rem;
        }

        .route-arrow {
            font-size: 1.5rem;
            color: #0ea5e9;
            margin: 0 1rem;
        }

        .table-container {
            overflow-x: auto;
            border-radius: 0.5rem;
            border: 1px solid rgba(229, 231, 235, 0.8);
        }

        .table {
            width: 100%;
            background: white;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        .table tr:hover {
            background-color: #f9fafb;
        }

        .no-trips {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
        }

        .no-trips svg {
            width: 4rem;
            height: 4rem;
            margin: 0 auto 1rem;
            color: #d1d5db;
        }

        .success-alert {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border: 1px solid #10b981;
            color: #065f46;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .error-alert {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border: 1px solid #ef4444;
            color: #991b1b;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="admin-header shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-primary">Admin Dashboard</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('admin.routes.index') }}" class="text-gray-600 hover:text-primary">Routes</a>
                        <span class="text-gray-500">/</span>
                        <span class="text-gray-700 font-medium">Route Details</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">Welcome, {{ auth()->user()->name }}</span>
                        <a href="{{ route('admin.routes.index') }}" class="navigation-link">
                            ← Back to Routes
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="navigation-link">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="success-alert">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="error-alert">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Route Header -->
            <div class="route-header">
                <div class="route-title">
                    {{ $route->from_location }}
                    <span class="route-arrow">→</span>
                    {{ $route->to_location }}
                </div>
                <div class="flex justify-center items-center space-x-4">
                    <span class="status-badge {{ $route->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $route->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    <span class="text-blue-600 font-medium">
                        Created {{ $route->created_at->format('M j, Y') }}
                    </span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-center space-x-4 mb-8">
                <a href="{{ route('admin.routes.edit', $route) }}" class="btn-warning">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Route
                </a>
                
                <form method="POST" action="{{ route('admin.routes.toggle-status', $route) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="{{ $route->is_active ? 'btn-warning' : 'btn-success' }}"
                            onclick="return confirm('Are you sure you want to {{ $route->is_active ? 'deactivate' : 'activate' }} this route?')">
                        @if($route->is_active)
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"></path>
                            </svg>
                            Deactivate Route
                        @else
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Activate Route
                        @endif
                    </button>
                </form>

                @if($route->trips->count() == 0)
                    <form method="POST" action="{{ route('admin.routes.destroy', $route) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn-danger"
                                onclick="return confirm('Are you sure you want to delete this route? This action cannot be undone.')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Route
                        </button>
                    </form>
                @endif
            </div>

            <!-- Route Information -->
            <div class="card p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Route Information</h2>
                
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Estimated Fare</div>
                        <div class="info-value">
                            @if($route->estimated_fare)
                                KSh {{ number_format($route->estimated_fare, 2) }}
                            @else
                                <span class="text-gray-400">Not set</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Estimated Duration</div>
                        <div class="info-value">
                            @if($route->estimated_duration_minutes)
                                {{ $route->estimated_duration_minutes }} minutes
                            @else
                                <span class="text-gray-400">Not set</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Total Trips</div>
                        <div class="info-value">{{ $route->trips->count() }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <span class="status-badge {{ $route->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $route->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($route->description)
                    <div class="mt-6">
                        <div class="info-label">Description</div>
                        <div class="bg-gray-50 p-4 rounded-lg mt-2">
                            <p class="text-gray-700">{{ $route->description }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Recent Trips -->
            <div class="card">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900">Recent Trips</h2>
                    <p class="text-gray-600 mt-1">Trips using this route</p>
                </div>

                @if($route->trips->count() > 0)
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Driver</th>
                                    <th>SACCO</th>
                                    <th>Departure</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Seats</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($route->trips as $trip)
                                    <tr>
                                        <td>
                                            <div class="font-medium text-gray-900">{{ $trip->driver->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $trip->driver->user->email }}</div>
                                        </td>
                                        <td>
                                            <span class="font-medium text-gray-900">{{ $trip->sacco->name }}</span>
                                        </td>
                                        <td>
                                            <div class="text-gray-900">{{ $trip->departure_time->format('M j, Y') }}</div>
                                            <div class="text-sm text-gray-500">{{ $trip->departure_time->format('g:i A') }}</div>
                                        </td>
                                        <td>
                                            <span class="text-green-600 font-medium">KSh {{ number_format($trip->amount, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                @if($trip->status === 'completed') bg-green-100 text-green-800
                                                @elseif($trip->status === 'in_progress') bg-blue-100 text-blue-800
                                                @elseif($trip->status === 'scheduled') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($trip->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-gray-900">{{ $trip->booked_seats }}/{{ $trip->available_seats }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="no-trips">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No trips found</h3>
                        <p class="text-gray-500">No trips have been created for this route yet.</p>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
