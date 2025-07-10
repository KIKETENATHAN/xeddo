<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Add New Vehicle - Admin Dashboard</title>
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

        .primary-navy { color: var(--primary-navy); }
        .bg-primary-navy { background-color: var(--primary-navy); }
        .text-primary { color: var(--primary-navy); }
        .bg-secondary { background: var(--gradient-gold); }
        .text-secondary { color: var(--secondary-gold); }
        .gradient-navy { background: var(--gradient-navy); }
        .gradient-gold { background: var(--gradient-gold); }

        .form-input {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.75rem;
            width: 100%;
            focus:ring-2;
            focus:ring-blue-500;
            focus:border-blue-500;
        }

        .form-select {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.75rem;
            width: 100%;
            background-color: white;
            focus:ring-2;
            focus:ring-blue-500;
            focus:border-blue-500;
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
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(30, 58, 138, 0.3);
        }

        .btn-secondary {
            background: var(--gradient-gold);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
        }

        .btn-cancel {
            background: #6b7280;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background: #4b5563;
            transform: translateY(-1px);
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('admin.vehicles.index') }}" class="text-primary hover:text-blue-800 mr-4 btn-cancel">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Back to Vehicle Management
                        </a>
                        <div class="text-xl font-semibold text-primary">
                            <svg class="w-6 h-6 inline mr-2 text-secondary-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add New Vehicle
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">Welcome, {{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-gray-700">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-primary-navy rounded-lg shadow-lg overflow-hidden">
                <div class="gradient-gold p-6 text-center">
                    <div class="bg-white rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Add New Vehicle</h1>
                    <p class="text-gray-100">
                        Register a new vehicle for an approved driver
                    </p>
                </div>
                
                <form method="POST" action="{{ route('admin.vehicles.store') }}" class="p-8 space-y-6">
                    @csrf
                    
                    <!-- Driver Selection -->
                    <div class="border-b border-gray-600 pb-6">
                        <h3 class="text-lg font-medium text-white mb-4">Driver Information</h3>
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-white mb-2">
                                Select Driver *
                            </label>
                            <select id="user_id" name="user_id" class="form-select" required>
                                <option value="">Choose a driver...</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}" {{ old('user_id') == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->name }} ({{ $driver->email }}) 
                                        @if($driver->driverProfile && $driver->driverProfile->sacco)
                                            - {{ $driver->driverProfile->sacco->name }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Vehicle Information -->
                    <div class="border-b border-gray-600 pb-6">
                        <h3 class="text-lg font-medium text-white mb-4">Vehicle Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="vehicle_type" class="block text-sm font-medium text-white mb-2">
                                    Vehicle Type *
                                </label>
                                <select id="vehicle_type" name="vehicle_type" class="form-select" required>
                                    <option value="">Select Vehicle Type</option>
                                    <option value="sedan" {{ old('vehicle_type') == 'sedan' ? 'selected' : '' }}>Sedan</option>
                                    <option value="suv" {{ old('vehicle_type') == 'suv' ? 'selected' : '' }}>SUV</option>
                                    <option value="hatchback" {{ old('vehicle_type') == 'hatchback' ? 'selected' : '' }}>Hatchback</option>
                                    <option value="minivan" {{ old('vehicle_type') == 'minivan' ? 'selected' : '' }}>Minivan</option>
                                    <option value="pickup" {{ old('vehicle_type') == 'pickup' ? 'selected' : '' }}>Pickup Truck</option>
                                    <option value="matatu" {{ old('vehicle_type') == 'matatu' ? 'selected' : '' }}>Matatu</option>
                                    <option value="bus" {{ old('vehicle_type') == 'bus' ? 'selected' : '' }}>Bus</option>
                                    <option value="van" {{ old('vehicle_type') == 'van' ? 'selected' : '' }}>Van</option>
                                    <option value="other" {{ old('vehicle_type') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('vehicle_type')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="vehicle_make" class="block text-sm font-medium text-gray-700 mb-2">
                                    Vehicle Make *
                                </label>
                                <input type="text" id="vehicle_make" name="vehicle_make" 
                                       value="{{ old('vehicle_make') }}" 
                                       class="form-input" placeholder="e.g., Toyota, Honda, Nissan" required>
                                @error('vehicle_make')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="vehicle_model" class="block text-sm font-medium text-gray-700 mb-2">
                                    Vehicle Model *
                                </label>
                                <input type="text" id="vehicle_model" name="vehicle_model" 
                                       value="{{ old('vehicle_model') }}" 
                                       class="form-input" placeholder="e.g., Camry, Civic, Altima" required>
                                @error('vehicle_model')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="vehicle_year" class="block text-sm font-medium text-gray-700 mb-2">
                                    Vehicle Year *
                                </label>
                                <input type="number" id="vehicle_year" name="vehicle_year" 
                                       value="{{ old('vehicle_year') }}" 
                                       class="form-input" min="1980" max="{{ date('Y') + 1 }}" required>
                                @error('vehicle_year')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="vehicle_plate_number" class="block text-sm font-medium text-gray-700 mb-2">
                                    License Plate Number *
                                </label>
                                <input type="text" id="vehicle_plate_number" name="vehicle_plate_number" 
                                       value="{{ old('vehicle_plate_number') }}" 
                                       class="form-input" placeholder="e.g., KAA 123A" required>
                                @error('vehicle_plate_number')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="vehicle_color" class="block text-sm font-medium text-gray-700 mb-2">
                                    Vehicle Color *
                                </label>
                                <input type="text" id="vehicle_color" name="vehicle_color" 
                                       value="{{ old('vehicle_color') }}" 
                                       class="form-input" placeholder="e.g., White, Black, Silver" required>
                                @error('vehicle_color')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="vehicle_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Vehicle Description (Optional)
                            </label>
                            <textarea id="vehicle_description" name="vehicle_description" rows="3" 
                                      class="form-input" 
                                      placeholder="Any additional details about the vehicle...">{{ old('vehicle_description') }}</textarea>
                            @error('vehicle_description')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- SACCO Assignment -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-primary mb-4">SACCO Assignment</h3>
                        <div>
                            <label for="sacco_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Assign to SACCO (Optional)
                            </label>
                            <select id="sacco_id" name="sacco_id" class="form-select">
                                <option value="">No SACCO assignment</option>
                                @foreach($saccos as $sacco)
                                    <option value="{{ $sacco->id }}" {{ old('sacco_id') == $sacco->id ? 'selected' : '' }}>
                                        {{ $sacco->name }} ({{ $sacco->location }})
                                    </option>
                                @endforeach
                            </select>
                            @error('sacco_id')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('admin.vehicles.index') }}" class="btn-cancel">
                            Cancel
                        </a>
                        <button type="submit" class="btn-secondary">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Vehicle
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
