<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Trip - Xeddo</title>
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
            --primary-color: #f97316;
            --primary-hover: #ea580c;
            --secondary-color: #1f2937;
            --accent-color: #3b82f6;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --error-color: #ef4444;
            --light-gray: #f8fafc;
            --border-color: #e5e7eb;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .form-container {
            max-width: 800px;
            margin: 2rem auto;
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        
        .form-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .form-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
        }
        
        .form-body {
            padding: 2rem;
            max-height: 70vh;
            overflow-y: auto;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fff;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }
        
        .form-input[readonly] {
            background: #f8fafc;
            color: var(--text-secondary);
        }
        
        .form-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            resize: vertical;
            min-height: 80px;
            transition: all 0.3s ease;
        }
        
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }
        
        .amount-input-container {
            position: relative;
        }
        
        .amount-currency {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-weight: 600;
        }
        
        .amount-input {
            padding-left: 3rem;
        }
        
        .error-message {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background: var(--text-secondary);
            color: white;
        }
        
        .btn-secondary:hover {
            background: var(--secondary-color);
            transform: translateY(-1px);
        }
        
        .info-text {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .required {
            color: var(--error-color);
        }
        
        .navigation {
            background: var(--primary-color);
            color: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .nav-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }
        
        .nav-links {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .nav-link {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: background 0.3s ease;
        }
        
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
        @media (max-width: 768px) {
            .form-container {
                margin: 1rem;
                border-radius: 8px;
            }
            
            .form-header {
                padding: 1.5rem;
            }
            
            .form-header h1 {
                font-size: 1.5rem;
            }
            
            .form-body {
                padding: 1.5rem;
                max-height: 60vh;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="navigation">
        <div class="nav-container">
            <a href="{{ route('driver.dashboard') }}" class="nav-brand">Xeddo</a>
            <div class="nav-links">
                <a href="{{ route('driver.dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('driver.trips.index') }}" class="nav-link">My Trips</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-link" style="background: none; border: none; color: white; cursor: pointer;">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen" style="padding: 2rem 1rem;">
        <div class="form-container">
            <!-- Form Header -->
            <div class="form-header">
                <h1>Create New Trip</h1>
                <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Plan your next journey</p>
            </div>

            <!-- Form Body -->
            <div class="form-body">
                <form action="{{ route('driver.trips.store') }}" method="POST" id="tripForm">
                    @csrf

                    <!-- From Location -->
                    <div class="form-group">
                        <label for="from_location" class="form-label">
                            From Location <span class="required">*</span>
                        </label>
                        <input type="text" 
                               name="from_location" 
                               id="from_location" 
                               value="{{ old('from_location') }}"
                               class="form-input"
                               placeholder="Enter departure location (e.g., Nairobi CBD)"
                               required>
                        @error('from_location')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- To Location -->
                    <div class="form-group">
                        <label for="to_location" class="form-label">
                            To Location <span class="required">*</span>
                        </label>
                        <input type="text" 
                               name="to_location" 
                               id="to_location" 
                               value="{{ old('to_location') }}"
                               class="form-input"
                               placeholder="Enter destination (e.g., Mombasa)"
                               required>
                        @error('to_location')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Departure Time -->
                    <div class="form-group">
                        <label for="departure_time" class="form-label">
                            Departure Time <span class="required">*</span>
                        </label>
                        <input type="datetime-local" 
                               name="departure_time" 
                               id="departure_time" 
                               value="{{ old('departure_time') }}"
                               class="form-input"
                               required>
                        @error('departure_time')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Estimated Arrival Time -->
                    <div class="form-group">
                        <label for="estimated_arrival_time" class="form-label">
                            Estimated Arrival Time <span class="required">*</span>
                        </label>
                        <input type="datetime-local" 
                               name="estimated_arrival_time" 
                               id="estimated_arrival_time" 
                               value="{{ old('estimated_arrival_time') }}"
                               class="form-input"
                               required>
                        @error('estimated_arrival_time')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div class="form-group">
                        <label for="amount" class="form-label">
                            Amount (KSH) <span class="required">*</span>
                        </label>
                        <div class="amount-input-container">
                            <span class="amount-currency">KSH</span>
                            <input type="number" 
                                   name="amount" 
                                   id="amount" 
                                   value="{{ old('amount') }}"
                                   class="form-input amount-input"
                                   placeholder="0.00"
                                   step="0.01"
                                   min="0"
                                   required>
                        </div>
                        @error('amount')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sacco Name (Read-only) -->
                    <div class="form-group">
                        <label for="sacco_name" class="form-label">
                            Sacco
                        </label>
                        <input type="text" 
                               name="sacco_name" 
                               id="sacco_name" 
                               value="{{ $sacco->name ?? 'Not assigned to any Sacco' }}"
                               class="form-input"
                               readonly>
                        <div class="info-text">Your Sacco is automatically assigned to this trip</div>
                    </div>

                    <!-- Available Seats -->
                    <div class="form-group">
                        <label for="available_seats" class="form-label">
                            Available Seats
                        </label>
                        <input type="number" 
                               name="available_seats" 
                               id="available_seats" 
                               value="{{ old('available_seats', 4) }}"
                               class="form-input"
                               min="1"
                               max="50"
                               placeholder="4">
                        @error('available_seats')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Additional Notes -->
                    <div class="form-group">
                        <label for="notes" class="form-label">
                            Additional Notes
                        </label>
                        <textarea name="notes" 
                                  id="notes" 
                                  class="form-textarea"
                                  placeholder="Any additional information for passengers (e.g., pick-up points, special requirements)...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('driver.dashboard') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Create Trip
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-calculate estimated arrival time based on departure time
        const departureInput = document.getElementById('departure_time');
        const arrivalInput = document.getElementById('estimated_arrival_time');
        
        departureInput.addEventListener('change', function() {
            if (this.value) {
                // Add 2 hours to departure time as default
                const departureTime = new Date(this.value);
                departureTime.setHours(departureTime.getHours() + 2);
                
                // Format for datetime-local input
                const year = departureTime.getFullYear();
                const month = String(departureTime.getMonth() + 1).padStart(2, '0');
                const day = String(departureTime.getDate()).padStart(2, '0');
                const hours = String(departureTime.getHours()).padStart(2, '0');
                const minutes = String(departureTime.getMinutes()).padStart(2, '0');
                
                arrivalInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
            }
        });
        
        // Set minimum date to today
        const today = new Date();
        const minDate = today.toISOString().slice(0, 16);
        departureInput.min = minDate;
        arrivalInput.min = minDate;
        
        // Form validation
        const form = document.getElementById('tripForm');
        form.addEventListener('submit', function(e) {
            const departure = new Date(departureInput.value);
            const arrival = new Date(arrivalInput.value);
            
            if (departure >= arrival) {
                e.preventDefault();
                alert('Arrival time must be after departure time');
                return false;
            }
        });
    });
    </script>
</body>
</html>
