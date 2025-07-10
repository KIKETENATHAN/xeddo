<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Trip - Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Assets -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-ogBwu_Df.css') }}">
    <script type="module" src="{{ asset('build/assets/app-DaBYqt0m.js') }}"></script>
    <style>
        :root {
            --primary-navy: #1e3a8a;
            --secondary-gold: #f59e0b;
            --gradient-navy: linear-gradient(135deg, #1e3a8a 0%, #3730a3 100%);
        }

        .form-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(30, 58, 138, 0.1);
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
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-navy);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--primary-navy);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-blue-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg p-2 mr-3">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-blue-900">Edit Trip</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.trips.show', $trip) }}" class="text-blue-900 hover:text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                        View Details
                    </a>
                    <a href="{{ route('admin.trips.index') }}" class="text-blue-900 hover:text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                        Back to Trips
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-blue-900 mb-4">Edit Trip</h2>
            <p class="text-gray-600">Update trip details and manage assignments</p>
        </div>

        <div class="form-card p-8">
            <form method="POST" action="{{ route('admin.trips.update', $trip) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Driver Selection -->
                    <div>
                        <label for="driver_id" class="form-label">Driver</label>
                        <select name="driver_id" id="driver_id" class="form-input" required>
                            <option value="">Select a driver</option>
                            @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}" {{ old('driver_id', $trip->driver_id) == $driver->id ? 'selected' : '' }}>
                                    {{ $driver->user->name }} - {{ $driver->sacco->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('driver_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- SACCO Selection -->
                    <div>
                        <label for="sacco_id" class="form-label">SACCO</label>
                        <select name="sacco_id" id="sacco_id" class="form-input" required>
                            <option value="">Select a SACCO</option>
                            @foreach($saccos as $sacco)
                                <option value="{{ $sacco->id }}" {{ old('sacco_id', $trip->sacco_id) == $sacco->id ? 'selected' : '' }}>
                                    {{ $sacco->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('sacco_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- From Location -->
                    <div>
                        <label for="from_location" class="form-label">From Location</label>
                        <input type="text" name="from_location" id="from_location" value="{{ old('from_location', $trip->from_location) }}" 
                               class="form-input" placeholder="e.g., Nairobi CBD" required>
                        @error('from_location')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- To Location -->
                    <div>
                        <label for="to_location" class="form-label">To Location</label>
                        <input type="text" name="to_location" id="to_location" value="{{ old('to_location', $trip->to_location) }}" 
                               class="form-input" placeholder="e.g., Mombasa" required>
                        @error('to_location')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Departure Time -->
                    <div>
                        <label for="departure_time" class="form-label">Departure Time</label>
                        <input type="datetime-local" name="departure_time" id="departure_time" 
                               value="{{ old('departure_time', $trip->departure_time->format('Y-m-d\TH:i')) }}" class="form-input" required>
                        @error('departure_time')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Estimated Arrival Time -->
                    <div>
                        <label for="estimated_arrival_time" class="form-label">Estimated Arrival Time</label>
                        <input type="datetime-local" name="estimated_arrival_time" id="estimated_arrival_time" 
                               value="{{ old('estimated_arrival_time', $trip->estimated_arrival_time->format('Y-m-d\TH:i')) }}" class="form-input" required>
                        @error('estimated_arrival_time')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Amount -->
                    <div>
                        <label for="amount" class="form-label">Amount (KSH)</label>
                        <input type="number" name="amount" id="amount" value="{{ old('amount', $trip->amount) }}" 
                               class="form-input" placeholder="1500" min="0" step="0.01" required>
                        @error('amount')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Available Seats -->
                    <div>
                        <label for="available_seats" class="form-label">Available Seats</label>
                        <input type="number" name="available_seats" id="available_seats" value="{{ old('available_seats', $trip->available_seats) }}" 
                               class="form-input" placeholder="14" min="1" max="50" required>
                        @error('available_seats')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-input" required>
                            <option value="scheduled" {{ old('status', $trip->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="in_progress" {{ old('status', $trip->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status', $trip->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', $trip->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="form-label">Notes (Optional)</label>
                    <textarea name="notes" id="notes" rows="4" class="form-input" 
                              placeholder="Any additional information about the trip...">{{ old('notes', $trip->notes) }}</textarea>
                    @error('notes')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                    <button type="submit" class="btn-primary flex-1 text-center">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Trip
                    </button>
                    <a href="{{ route('admin.trips.show', $trip) }}" class="btn-secondary flex-1 text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Update arrival time minimum when departure time changes
        document.getElementById('departure_time').addEventListener('change', function() {
            document.getElementById('estimated_arrival_time').min = this.value;
        });
    </script>
</body>
</html>
