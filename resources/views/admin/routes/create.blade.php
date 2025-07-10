<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add New Route - Admin Dashboard</title>
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

        .btn-secondary {
            background: #6b7280;
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
            box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(107, 114, 128, 0.4);
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

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            background-color: #ffffff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            background-color: #ffffff;
            font-size: 1rem;
            transition: all 0.3s ease;
            resize: vertical;
            min-height: 100px;
        }

        .form-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            background-color: #ffffff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-checkbox {
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.25rem;
            background-color: #ffffff;
            transition: all 0.3s ease;
        }

        .form-checkbox:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .error-text {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
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

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .help-text {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.25rem;
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
                        <span class="text-gray-700 font-medium">Add New Route</span>
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
        <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
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

            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white">Add New Route</h1>
                <p class="text-blue-100 mt-2">Create a new travel route between two locations</p>
            </div>

            <!-- Create Form -->
            <div class="card p-8">
                <form method="POST" action="{{ route('admin.routes.store') }}">
                    @csrf
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="from_location" class="form-label">From Location *</label>
                            <input type="text" 
                                   id="from_location" 
                                   name="from_location" 
                                   class="form-input @error('from_location') border-red-500 @enderror" 
                                   value="{{ old('from_location') }}"
                                   placeholder="e.g., Nairobi CBD"
                                   required>
                            @error('from_location')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                            <p class="help-text">Enter the starting location of the route</p>
                        </div>

                        <div class="form-group">
                            <label for="to_location" class="form-label">To Location *</label>
                            <input type="text" 
                                   id="to_location" 
                                   name="to_location" 
                                   class="form-input @error('to_location') border-red-500 @enderror" 
                                   value="{{ old('to_location') }}"
                                   placeholder="e.g., Mombasa"
                                   required>
                            @error('to_location')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                            <p class="help-text">Enter the destination location of the route</p>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="estimated_fare" class="form-label">Estimated Fare (KSh)</label>
                            <input type="number" 
                                   id="estimated_fare" 
                                   name="estimated_fare" 
                                   class="form-input @error('estimated_fare') border-red-500 @enderror" 
                                   value="{{ old('estimated_fare') }}"
                                   placeholder="0.00"
                                   step="0.01"
                                   min="0">
                            @error('estimated_fare')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                            <p class="help-text">Optional: Set an estimated fare for this route</p>
                        </div>

                        <div class="form-group">
                            <label for="estimated_duration_minutes" class="form-label">Estimated Duration (Minutes)</label>
                            <input type="number" 
                                   id="estimated_duration_minutes" 
                                   name="estimated_duration_minutes" 
                                   class="form-input @error('estimated_duration_minutes') border-red-500 @enderror" 
                                   value="{{ old('estimated_duration_minutes') }}"
                                   placeholder="120"
                                   min="1">
                            @error('estimated_duration_minutes')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                            <p class="help-text">Optional: Estimated travel time in minutes</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" 
                                  name="description" 
                                  class="form-textarea @error('description') border-red-500 @enderror" 
                                  placeholder="Enter route description, notes, or special instructions...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                        <p class="help-text">Optional: Add any additional information about this route</p>
                    </div>

                    <div class="form-group">
                        <div class="checkbox-container">
                            <input type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   class="form-checkbox" 
                                   value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" class="form-label mb-0">Active Route</label>
                        </div>
                        <p class="help-text">Check this box to make the route immediately available for trips</p>
                    </div>

                    <div class="flex justify-end space-x-4 mt-8">
                        <a href="{{ route('admin.routes.index') }}" class="btn-secondary">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Route
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Auto-capitalize first letter of location inputs
        document.getElementById('from_location').addEventListener('input', function(e) {
            this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
        });

        document.getElementById('to_location').addEventListener('input', function(e) {
            this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
        });

        // Validate that from and to locations are different
        function validateLocations() {
            const fromLocation = document.getElementById('from_location').value.trim().toLowerCase();
            const toLocation = document.getElementById('to_location').value.trim().toLowerCase();
            
            if (fromLocation && toLocation && fromLocation === toLocation) {
                document.getElementById('to_location').setCustomValidity('Destination must be different from origin');
            } else {
                document.getElementById('to_location').setCustomValidity('');
            }
        }

        document.getElementById('from_location').addEventListener('input', validateLocations);
        document.getElementById('to_location').addEventListener('input', validateLocations);
    </script>
</body>
</html>
