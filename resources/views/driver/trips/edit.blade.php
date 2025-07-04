<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Trip - Xeddo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            box-sizing: border-box;
        }
        
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }
        :root {
            --primary-navy: #1e3a8a;
            --primary-navy-dark: #1e40af;
            --secondary-gold: #f59e0b;
            --secondary-gold-dark: #d97706;
            --accent-gold: #fbbf24;
            --gradient-navy: linear-gradient(135deg, #1e3a8a 0%, #3730a3 100%);
            --gradient-gold: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .bg-primary { background-color: var(--primary-navy); }
        .text-primary { color: var(--primary-navy); }
        .text-secondary { color: var(--secondary-gold); }
        .gradient-navy { background: var(--gradient-navy); }
        .gradient-gold { background: var(--gradient-gold); }

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
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-navy);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        .form-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
            resize: vertical;
            min-height: 100px;
        }

        .form-textarea:focus {
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
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .hero-section {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            position: relative;
        }

        body {
            overflow-x: hidden;
            overflow-y: auto;
        }

        main {
            padding-bottom: 3rem;
            position: relative;
            z-index: 1;
        }

        .form-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(30, 58, 138, 0.1);
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body class="hero-section">
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
                    <h1 class="text-xl font-bold text-primary">Edit Trip</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('driver.trips.index') }}" class="text-primary hover:text-primary-dark px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                        Back to Trips
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="form-card p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-primary mb-4">Edit Trip</h2>
                    <p class="text-gray-600">Update your trip details</p>
                </div>

                <!-- SACCO Info Banner -->
                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 p-6 rounded-lg border-2 border-yellow-200 mb-8">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-yellow-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $trip->sacco->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $trip->sacco->full_route }}</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('driver.trips.update', $trip) }}">
                    @csrf
                    @method('PATCH')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- From Location -->
                        <div>
                            <label for="from_location" class="form-label">From Location</label>
                            <input type="text" 
                                   id="from_location" 
                                   name="from_location" 
                                   class="form-input @error('from_location') border-red-500 @enderror" 
                                   value="{{ old('from_location', $trip->from_location) }}" 
                                   placeholder="e.g., Nairobi CBD"
                                   required>
                            @error('from_location')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- To Location -->
                        <div>
                            <label for="to_location" class="form-label">To Location</label>
                            <input type="text" 
                                   id="to_location" 
                                   name="to_location" 
                                   class="form-input @error('to_location') border-red-500 @enderror" 
                                   value="{{ old('to_location', $trip->to_location) }}" 
                                   placeholder="e.g., Kiambu"
                                   required>
                            @error('to_location')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Departure Time -->
                        <div>
                            <label for="departure_time" class="form-label">Departure Time</label>
                            <input type="datetime-local" 
                                   id="departure_time" 
                                   name="departure_time" 
                                   class="form-input @error('departure_time') border-red-500 @enderror" 
                                   value="{{ old('departure_time', $trip->departure_time->format('Y-m-d\TH:i')) }}" 
                                   min="{{ now()->format('Y-m-d\TH:i') }}"
                                   required>
                            @error('departure_time')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estimated Arrival Time -->
                        <div>
                            <label for="estimated_arrival_time" class="form-label">Estimated Arrival Time</label>
                            <input type="datetime-local" 
                                   id="estimated_arrival_time" 
                                   name="estimated_arrival_time" 
                                   class="form-input @error('estimated_arrival_time') border-red-500 @enderror" 
                                   value="{{ old('estimated_arrival_time', $trip->estimated_arrival_time->format('Y-m-d\TH:i')) }}" 
                                   min="{{ now()->format('Y-m-d\TH:i') }}"
                                   required>
                            @error('estimated_arrival_time')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount" class="form-label">Amount (KSH)</label>
                            <input type="number" 
                                   id="amount" 
                                   name="amount" 
                                   class="form-input @error('amount') border-red-500 @enderror" 
                                   value="{{ old('amount', $trip->amount) }}" 
                                   placeholder="e.g., 150"
                                   min="0"
                                   step="0.01"
                                   required>
                            @error('amount')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Available Seats -->
                        <div>
                            <label for="available_seats" class="form-label">Available Seats</label>
                            <input type="number" 
                                   id="available_seats" 
                                   name="available_seats" 
                                   class="form-input @error('available_seats') border-red-500 @enderror" 
                                   value="{{ old('available_seats', $trip->available_seats) }}" 
                                   placeholder="e.g., 14"
                                   min="{{ $trip->booked_seats }}"
                                   max="50"
                                   required>
                            @error('available_seats')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                            @if($trip->booked_seats > 0)
                                <p class="text-sm text-gray-600 mt-1">
                                    Note: {{ $trip->booked_seats }} seats are already booked. You can only increase the available seats.
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mt-6">
                        <label for="notes" class="form-label">Trip Notes (Optional)</label>
                        <textarea id="notes" 
                                  name="notes" 
                                  class="form-textarea @error('notes') border-red-500 @enderror" 
                                  placeholder="Any additional information about the trip...">{{ old('notes', $trip->notes) }}</textarea>
                        @error('notes')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-between mt-8">
                        <a href="{{ route('driver.trips.index') }}" class="btn-secondary">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Trip
                        </button>
                    </div>
                </form>
            </div>
        </main>

    <script>
        // Automatically set minimum arrival time when departure time changes
        document.getElementById('departure_time').addEventListener('change', function() {
            const departureTime = new Date(this.value);
            const arrivalInput = document.getElementById('estimated_arrival_time');
            
            if (departureTime) {
                // Set minimum arrival time to 30 minutes after departure
                const minArrival = new Date(departureTime.getTime() + 30 * 60000);
                arrivalInput.min = minArrival.toISOString().slice(0, 16);
                
                // If current arrival time is before new minimum, update it
                if (arrivalInput.value && new Date(arrivalInput.value) <= departureTime) {
                    arrivalInput.value = minArrival.toISOString().slice(0, 16);
                }
            }
        });
    </script>
</body>
</html>
