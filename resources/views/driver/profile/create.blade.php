<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complete Driver Profile - Xeddo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Assets -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-ogBwu_Df.css') }}">
    <script type="module" src="{{ asset('build/assets/app-DaBYqt0m.js') }}"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-2xl w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                    Complete Your Driver Profile
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                    Please provide your vehicle and license information to start driving
                </p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <form method="POST" action="{{ route('driver.profile.store') }}" class="space-y-6">
                    @csrf
                    
                    <!-- License Information -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">License Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="license_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">License Number</label>
                                <input type="text" id="license_number" name="license_number" required 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                       value="{{ old('license_number') }}">
                                @error('license_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="license_expiry" class="block text-sm font-medium text-gray-700 dark:text-gray-300">License Expiry Date</label>
                                <input type="date" id="license_expiry" name="license_expiry" required 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                       value="{{ old('license_expiry') }}">
                                @error('license_expiry')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Vehicle Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="vehicle_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Vehicle Type</label>
                                <select id="vehicle_type" name="vehicle_type" required 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Select vehicle type</option>
                                    <option value="sedan" {{ old('vehicle_type') === 'sedan' ? 'selected' : '' }}>Sedan</option>
                                    <option value="suv" {{ old('vehicle_type') === 'suv' ? 'selected' : '' }}>SUV</option>
                                    <option value="hatchback" {{ old('vehicle_type') === 'hatchback' ? 'selected' : '' }}>Hatchback</option>
                                    <option value="truck" {{ old('vehicle_type') === 'truck' ? 'selected' : '' }}>Truck</option>
                                    <option value="van" {{ old('vehicle_type') === 'van' ? 'selected' : '' }}>Van</option>
                                    <option value="other" {{ old('vehicle_type') === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('vehicle_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="vehicle_make" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Vehicle Make</label>
                                <input type="text" id="vehicle_make" name="vehicle_make" required 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                       placeholder="e.g., Toyota, Ford, Honda" value="{{ old('vehicle_make') }}">
                                @error('vehicle_make')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="vehicle_model" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Vehicle Model</label>
                                <input type="text" id="vehicle_model" name="vehicle_model" required 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                       placeholder="e.g., Camry, F-150, Civic" value="{{ old('vehicle_model') }}">
                                @error('vehicle_model')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="vehicle_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Vehicle Year</label>
                                <input type="number" id="vehicle_year" name="vehicle_year" required min="1980" max="{{ date('Y') + 1 }}" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                       value="{{ old('vehicle_year') }}">
                                @error('vehicle_year')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="vehicle_plate_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">License Plate Number</label>
                                <input type="text" id="vehicle_plate_number" name="vehicle_plate_number" required 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                       value="{{ old('vehicle_plate_number') }}">
                                @error('vehicle_plate_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="vehicle_color" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Vehicle Color</label>
                                <input type="text" id="vehicle_color" name="vehicle_color" required 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                       placeholder="e.g., White, Black, Silver" value="{{ old('vehicle_color') }}">
                                @error('vehicle_color')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="vehicle_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Vehicle Description (Optional)</label>
                                <textarea id="vehicle_description" name="vehicle_description" rows="3" 
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                          placeholder="Any additional details about your vehicle...">{{ old('vehicle_description') }}</textarea>
                                @error('vehicle_description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" 
                                class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Submit for Approval
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
