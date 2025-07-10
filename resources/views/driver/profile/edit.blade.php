<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Driver Profile - Xeddo</title>
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

        .form-input {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem;
            transition: all 0.3s ease;
            background: white;
            color: #374151;
            width: 100%;
        }

        .form-input:focus {
            border-color: var(--secondary-gold);
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
            outline: none;
        }

        .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem;
            transition: all 0.3s ease;
            background: white;
            color: #374151;
            width: 100%;
        }

        .form-select:focus {
            border-color: var(--secondary-gold);
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
            outline: none;
        }

        .form-textarea {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem;
            transition: all 0.3s ease;
            background: white;
            color: #374151;
            width: 100%;
            resize: vertical;
        }

        .form-textarea:focus {
            border-color: var(--secondary-gold);
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
            outline: none;
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

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(30, 58, 138, 0.1);
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <h1 class="text-xl font-bold text-primary">Edit Driver Profile</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('driver.dashboard') }}" class="text-primary hover:text-primary-dark px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                            ← Back to Dashboard
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
        <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="card p-8">
                <div class="text-center mb-8">
                    <div class="gradient-gold rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-primary mb-2">Edit Your Driver Profile</h2>
                    <p class="text-gray-600">Update your information and SACCO membership</p>
                </div>

                <form method="POST" action="{{ route('driver.profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Personal Information -->
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                        <h3 class="text-xl font-bold text-primary mb-4">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="license_number" class="block text-sm font-medium text-gray-700 mb-2">
                                    License Number *
                                </label>
                                <input type="text" id="license_number" name="license_number" 
                                       value="{{ old('license_number', $driverProfile->license_number) }}" 
                                       class="form-input" required>
                                @error('license_number')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="license_expiry" class="block text-sm font-medium text-gray-700 mb-2">
                                    License Expiry Date *
                                </label>
                                <input type="date" id="license_expiry" name="license_expiry" 
                                       value="{{ old('license_expiry', $driverProfile->license_expiry?->format('Y-m-d')) }}" 
                                       class="form-input" required>
                                @error('license_expiry')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- SACCO Membership -->
                    <div class="bg-yellow-50 p-6 rounded-lg border-2 border-yellow-200">
                        <h3 class="text-xl font-bold text-primary mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            SACCO Membership
                        </h3>
                        <div>
                            <label for="sacco_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Select SACCO (Optional)
                            </label>
                            <select id="sacco_id" name="sacco_id" class="form-select">
                                <option value="">-- No SACCO --</option>
                                @foreach($saccos as $sacco)
                                    <option value="{{ $sacco->id }}" 
                                            {{ old('sacco_id', $driverProfile->sacco_id) == $sacco->id ? 'selected' : '' }}>
                                        {{ $sacco->name }} - {{ $sacco->full_route }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sacco_id')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                            <p class="text-sm text-gray-600 mt-2">
                                Choose a SACCO to operate on specific routes and connect with other drivers in your area.
                            </p>
                        </div>
                    </div>

                    <!-- Vehicle Information -->
                    <div class="bg-green-50 p-6 rounded-lg border border-green-200">
                        <h3 class="text-xl font-bold text-primary mb-4">Vehicle Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="vehicle_type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Vehicle Type *
                                </label>
                                <select id="vehicle_type" name="vehicle_type" class="form-select" required>
                                    <option value="">Select Vehicle Type</option>
                                    <option value="sedan" {{ old('vehicle_type', $driverProfile->vehicle_type) == 'sedan' ? 'selected' : '' }}>Sedan</option>
                                    <option value="suv" {{ old('vehicle_type', $driverProfile->vehicle_type) == 'suv' ? 'selected' : '' }}>SUV</option>
                                    <option value="hatchback" {{ old('vehicle_type', $driverProfile->vehicle_type) == 'hatchback' ? 'selected' : '' }}>Hatchback</option>
                                    <option value="minivan" {{ old('vehicle_type', $driverProfile->vehicle_type) == 'minivan' ? 'selected' : '' }}>Minivan</option>
                                    <option value="pickup" {{ old('vehicle_type', $driverProfile->vehicle_type) == 'pickup' ? 'selected' : '' }}>Pickup Truck</option>
                                    <option value="matatu" {{ old('vehicle_type', $driverProfile->vehicle_type) == 'matatu' ? 'selected' : '' }}>Matatu</option>
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
                                       value="{{ old('vehicle_make', $driverProfile->vehicle_make) }}" 
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
                                       value="{{ old('vehicle_model', $driverProfile->vehicle_model) }}" 
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
                                       value="{{ old('vehicle_year', $driverProfile->vehicle_year) }}" 
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
                                       value="{{ old('vehicle_plate_number', $driverProfile->vehicle_plate_number) }}" 
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
                                       value="{{ old('vehicle_color', $driverProfile->vehicle_color) }}" 
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
                                      class="form-textarea" 
                                      placeholder="Any additional details about your vehicle...">{{ old('vehicle_description', $driverProfile->vehicle_description) }}</textarea>
                            @error('vehicle_description')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('driver.dashboard') }}" 
                           class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="btn-secondary">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
