<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Xeddo Travel link</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

        .bg-primary { background-color: var(--primary-navy); }
        .bg-primary-dark { background-color: var(--primary-navy-dark); }
        .bg-secondary { background-color: var(--secondary-gold); }
        .bg-secondary-dark { background-color: var(--secondary-gold-dark); }
        .text-primary { color: var(--primary-navy); }
        .text-secondary { color: var(--secondary-gold); }
        .border-primary { border-color: var(--primary-navy); }
        .border-secondary { border-color: var(--secondary-gold); }

        .gradient-navy { background: var(--gradient-navy); }
        .gradient-gold { background: var(--gradient-gold); }

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

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 1rem;
            max-width: 90vw;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {
            background: var(--gradient-navy);
            color: white;
            padding: 1.5rem;
            border-radius: 1rem 1rem 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: background 0.3s ease;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .modal-body {
            padding: 2rem;
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

        .trip-table {
            min-width: 600px;
        }

        .trip-table th,
        .trip-table td {
            white-space: nowrap;
        }

        .trip-table .route-cell {
            max-width: 120px;
            white-space: normal;
        }

        .book-btn {
            background: var(--gradient-gold);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(245, 158, 11, 0.3);
            font-size: 0.875rem;
        }

        .book-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(245, 158, 11, 0.4);
        }

        .book-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        .loading.active {
            display: block;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-navy);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .hero-section {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse"><path d="M 50 0 L 0 0 0 50" fill="none" stroke="rgba(30,58,138,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }

        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }

        .feature-card {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(30, 58, 138, 0.1);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .icon-container {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(30, 58, 138, 0.1);
            margin: 0 auto 1rem;
        }

        .icon-container.golden {
            background: rgba(245, 158, 11, 0.1);
        }

        /* Carousel Styles */
        .carousel-container {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .carousel-slide {
            display: none;
            position: relative;
            width: 100%;
            height: 400px;
        }

        .carousel-slide.active {
            display: block;
        }

        .carousel-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .carousel-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .carousel-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-nav:hover {
            background: rgba(0, 0, 0, 0.8);
            transform: translateY(-50%) scale(1.1);
        }

        .carousel-nav.prev {
            left: 1rem;
        }

        .carousel-nav.next {
            right: 1rem;
        }

        .carousel-dots {
            position: absolute;
            bottom: 1rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 0.5rem;
        }

        .carousel-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-dot.active {
            background: white;
            transform: scale(1.2);
        }

        /* Booking Modal Styles */
        .booking-modal {
            display: none;
            position: fixed;
            z-index: 1100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
        }

        .booking-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .booking-modal-content {
            background: white;
            border-radius: 1rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            position: relative;
            animation: modalSlideIn 0.3s ease-out;
        }

        .payment-status {
            text-align: center;
            padding: 2rem;
        }

        .payment-status .icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .payment-status .icon.processing {
            background: rgba(245, 158, 11, 0.1);
        }

        .payment-status .icon.success {
            background: rgba(34, 197, 94, 0.1);
        }

        .payment-status .icon.failed {
            background: rgba(239, 68, 68, 0.1);
        }

        .spinner-payment {
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--secondary-gold);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        .receipt {
            background: #f8fafc;
            border: 2px dashed #e5e7eb;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin: 1rem 0;
        }

        .receipt-header {
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }

        .receipt-row {
            display: flex;
            justify-content: space-between;
            margin: 0.5rem 0;
        }

        .receipt-row.total {
            font-weight: bold;
            font-size: 1.1rem;
            border-top: 1px solid #e5e7eb;
            padding-top: 0.5rem;
            margin-top: 1rem;
        }

        /* Seat Selection Styles */
        .vehicle-layout {
            max-width: 300px;
            margin: 0 auto;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            padding: 20px;
            position: relative;
        }

        .driver-section {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e2e8f0;
        }

        .driver-seat {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #6b7280;
            color: white;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 10px;
            font-weight: 600;
        }

        .passenger-seats {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .seat-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
        }

        .aisle {
            width: 20px;
            height: 2px;
            background: #e2e8f0;
            position: relative;
        }

        .aisle::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 4px;
            height: 4px;
            background: #9ca3af;
            border-radius: 50%;
        }

        .seat {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            user-select: none;
        }

        .seat.available {
            background: #22c55e;
            color: white;
        }

        .seat.available:hover {
            background: #16a34a;
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
        }

        .seat.occupied {
            background: #ef4444;
            color: white;
            cursor: not-allowed;
        }

        .seat.selected {
            background: #f59e0b;
            color: white;
            border-color: #d97706;
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
        }

        .seat.small {
            width: 20px;
            height: 20px;
            font-size: 10px;
        }

        .seat-legend {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 20px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #6b7280;
        }

        .selected-seats-display {
            text-align: center;
            padding: 15px;
            background: white;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            margin-top: 15px;
        }

        @media (max-width: 768px) {
            .modal-content {
                width: 95vw;
                margin: 1rem;
            }
            
            .modal-body {
                padding: 1rem;
            }
            
            .trip-table {
                font-size: 0.875rem;
            }
            
            .book-btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.75rem;
            }

            .booking-modal-content {
                width: 95%;
                margin: 1rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-blue-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <div class="gradient-navy rounded-lg p-2 mr-3">
                            <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-primary">Xeddo Travell Link</h1>
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button id="mobile-menu-button" class="text-primary hover:text-primary-dark p-2 rounded-lg hover:bg-blue-50 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Desktop menu -->
                    <div class="hidden md:flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-primary">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-primary hover:text-primary-dark px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                                Log in
                            </a>
                            <a href="{{ route('register.passenger') }}" class="btn-primary">
                                Register as Passenger
                            </a>
                            <a href="{{ route('register.driver') }}" class="btn-secondary">
                                Register as Driver
                            </a>
                        @endauth
                    </div>
                </div>
                
                <!-- Mobile menu -->
                <div id="mobile-menu" class="md:hidden hidden border-t border-blue-100 bg-white/95 backdrop-blur-md">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="block px-3 py-2 rounded-lg text-primary hover:bg-blue-50 transition-colors font-medium">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-primary hover:bg-blue-50 transition-colors font-medium">
                                Log in
                            </a>
                            <a href="{{ route('register.passenger') }}" class="block px-3 py-2 rounded-lg btn-primary text-center mb-2">
                                Register as Passenger
                            </a>
                            <a href="{{ route('register.driver') }}" class="block px-3 py-2 rounded-lg btn-secondary text-center">
                                Register as Driver
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero-section py-16 md:py-24 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-6xl font-bold text-primary mb-6 leading-tight fade-in">
                        Welcome to 
                        <span class="text-secondary">Xeddo Travel Link</span>
                    </h2>
                    <p class="text-xl md:text-2xl text-gray-600 mb-8 max-w-3xl mx-auto leading-relaxed fade-in stagger-1">
                        Your premium ride-sharing platform connecting passengers with professional drivers across the city
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center fade-in stagger-2">
                        <button onclick="openBookingModal()" class="btn-primary text-lg px-8 py-4 floating-animation">
                            Book Your Ride
                        </button>
                        <a href="{{ route('register.driver') }}" class="btn-secondary text-lg px-8 py-4 floating-animation" style="animation-delay: 0.5s;">
                            Become a Driver
                        </a>
                    </div>
                </div>

                <!-- Carousel -->
                <div class="carousel-container mb-16 fade-in stagger-3">
                    <div class="carousel-slide active">
                        <img src="https://images.pexels.com/photos/1545743/pexels-photo-1545743.jpeg?auto=compress&cs=tinysrgb&w=1200" alt="Safe & Reliable">
                        <div class="carousel-overlay">
                            <h3 class="text-3xl font-bold mb-3">Safe & Reliable</h3>
                            <p class="text-lg opacity-90 max-w-2xl">Experience secure rides with our verified drivers and real-time tracking system. Your safety is our top priority.</p>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="https://images.pexels.com/photos/1104014/pexels-photo-1104014.jpeg?auto=compress&cs=tinysrgb&w=1200" alt="Modern Fleet">
                        <div class="carousel-overlay">
                            <h3 class="text-3xl font-bold mb-3">Modern Fleet</h3>
                            <p class="text-lg opacity-90 max-w-2xl">Travel in comfort with our modern, well-maintained vehicle fleet featuring the latest safety and comfort features.</p>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="https://images.pexels.com/photos/1592384/pexels-photo-1592384.jpeg?auto=compress&cs=tinysrgb&w=1200" alt="Professional Drivers">
                        <div class="carousel-overlay">
                            <h3 class="text-3xl font-bold mb-3">Professional Drivers</h3>
                            <p class="text-lg opacity-90 max-w-2xl">Our skilled and courteous drivers ensure a pleasant journey every time with their professional service.</p>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="https://images.pexels.com/photos/1173777/pexels-photo-1173777.jpeg?auto=compress&cs=tinysrgb&w=1200" alt="City Coverage">
                        <div class="carousel-overlay">
                            <h3 class="text-3xl font-bold mb-3">City Coverage</h3>
                            <p class="text-lg opacity-90 max-w-2xl">Comprehensive coverage across the city with quick pickup times and efficient route planning.</p>
                        </div>
                    </div>
                    <div class="carousel-slide">
                        <img src="https://images.pexels.com/photos/1118448/pexels-photo-1118448.jpeg?auto=compress&cs=tinysrgb&w=1200" alt="Affordable Rates">
                        <div class="carousel-overlay">
                            <h3 class="text-3xl font-bold mb-3">Affordable Rates</h3>
                            <p class="text-lg opacity-90 max-w-2xl">Competitive pricing with transparent fare structure and no hidden costs. Quality service at fair prices.</p>
                        </div>
                    </div>
                    
                    <!-- Navigation -->
                    <button class="carousel-nav prev" onclick="changeSlide(-1)">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button class="carousel-nav next" onclick="changeSlide(1)">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    
                    <!-- Dots -->
                    <div class="carousel-dots">
                        <span class="carousel-dot active" onclick="currentSlide(1)"></span>
                        <span class="carousel-dot" onclick="currentSlide(2)"></span>
                        <span class="carousel-dot" onclick="currentSlide(3)"></span>
                        <span class="carousel-dot" onclick="currentSlide(4)"></span>
                        <span class="carousel-dot" onclick="currentSlide(5)"></span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">
                        Choose Your Experience
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Whether you're looking for a ride or want to start earning, we have the perfect solution for you
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-6xl mx-auto">
                    <!-- Passenger Card -->
                    <div class="feature-card">
                        <div class="text-center">
                            <div class="icon-container">
                                <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-primary mb-3">
                                For Passengers
                            </h3>
                            <p class="text-gray-600 mb-6 leading-relaxed">
                                Experience premium rides with our network of professional drivers. Safe, reliable, and comfortable transportation at your fingertips.
                            </p>
                            <div class="space-y-4">
                                <ul class="text-sm text-gray-600 space-y-3">
                                    <li class="flex items-center justify-center">
                                        <span class="text-green-500 mr-2">✓</span>
                                        Easy booking with real-time tracking
                                    </li>
                                    <li class="flex items-center justify-center">
                                        <span class="text-green-500 mr-2">✓</span>
                                        Verified drivers and secure rides
                                    </li>
                                    <li class="flex items-center justify-center">
                                        <span class="text-green-500 mr-2">✓</span>
                                        Transparent pricing with no hidden fees
                                    </li>
                                    <li class="flex items-center justify-center">
                                        <span class="text-green-500 mr-2">✓</span>
                                        Multiple payment options available
                                    </li>
                                </ul>
                                <button onclick="openBookingModal()" class="btn-primary w-full text-center block">
                                    Get Started as Passenger
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Driver Card -->
                    <div class="feature-card">
                        <div class="text-center">
                            <div class="icon-container golden">
                                <svg class="w-10 h-10 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-primary mb-3">
                                For Drivers
                            </h3>
                            <p class="text-gray-600 mb-6 leading-relaxed">
                                Turn your car into a source of income. Join our platform and start earning with flexible hours and competitive rates.
                            </p>
                            <div class="space-y-4">
                                <ul class="text-sm text-gray-600 space-y-3">
                                    <li class="flex items-center justify-center">
                                        <span class="text-green-500 mr-2">✓</span>
                                        Flexible working hours that fit your schedule
                                    </li>
                                    <li class="flex items-center justify-center">
                                        <span class="text-green-500 mr-2">✓</span>
                                        Competitive earnings with instant payments
                                    </li>
                                    <li class="flex items-center justify-center">
                                        <span class="text-green-500 mr-2">✓</span>
                                        Comprehensive driver support and training
                                    </li>
                                    <li class="flex items-center justify-center">
                                        <span class="text-green-500 mr-2">✓</span>
                                        Easy registration and approval process
                                    </li>
                                </ul>
                                <a href="{{ route('register.driver') }}" class="btn-secondary w-full text-center block">
                                    Start Driving Today
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Us Section -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">
                        Why Choose Xeddo?
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        We're committed to providing the best ride-sharing experience with cutting-edge technology and exceptional service
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center group">
                        <div class="bg-blue-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-primary mb-2">Safety First</h3>
                        <p class="text-gray-600">All drivers are background-checked and vehicles are regularly inspected</p>
                    </div>

                    <div class="text-center group">
                        <div class="bg-yellow-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-10 h-10 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-primary mb-2">Quick & Reliable</h3>
                        <p class="text-gray-600">Fast pickup times and real-time tracking for your peace of mind</p>
                    </div>

                    <div class="text-center group">
                        <div class="bg-green-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-primary mb-2">Affordable Pricing</h3>
                        <p class="text-gray-600">Competitive rates with transparent pricing and no hidden fees</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-primary text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center mb-4">
                            <div class="gradient-gold rounded-lg p-2 mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold">Xeddo</h3>
                        </div>
                        <p class="text-blue-200 mb-4">
                            Your trusted partner for safe, reliable, and comfortable transportation. 
                            Connecting communities through innovative ride-sharing solutions.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-blue-200 hover:text-secondary transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-blue-200 hover:text-secondary transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-blue-200 hover:text-secondary transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.097.118.112.221.083.402-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="border-t border-blue-700 mt-8 pt-8 text-center">
                    <p class="text-blue-200">
                        © 2025 Xeddo. All rights reserved. | Designed with ❤️ from Celertech Tech
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Booking Modal -->
    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="text-2xl font-bold">Find Your Ride</h2>
                <button class="modal-close" onclick="closeBookingModal()">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Search Form -->
                <form id="searchForm" class="space-y-6 mb-8">
                    <div>
                        <label for="modal-sacco" class="block text-sm font-semibold text-primary mb-2">Select SACCO</label>
                        <div class="relative">
                            <select id="modal-sacco" name="sacco_id" class="form-input pr-10" required>
                                <option value="">Choose a SACCO</option>
                                <!-- SACCOs will be populated via JavaScript -->
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="modal-pickup" class="block text-sm font-semibold text-primary mb-2">Pickup Location</label>
                        <div class="relative">
                            <input type="text" id="modal-pickup" name="pickup" class="form-input pr-10" placeholder="Enter pickup location" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="modal-destination" class="block text-sm font-semibold text-primary mb-2">Destination</label>
                        <div class="relative">
                            <input type="text" id="modal-destination" name="destination" class="form-input pr-10" placeholder="Enter destination" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn-secondary w-full">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Find Available Rides
                    </button>
                </form>

                <!-- Loading indicator -->
                <div id="loadingIndicator" class="loading">
                    <div class="spinner"></div>
                    <p class="text-gray-600">Searching for available rides...</p>
                </div>

                <!-- Results Section -->
                <div id="searchResults" style="display: none;">
                    <div class="text-center mb-6">
                        <h3 class="text-2xl font-bold text-primary mb-2">Available Rides</h3>
                        <p id="resultsCount" class="text-gray-600"></p>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="trip-table w-full">
                            <thead>
                                <tr class="bg-gray-50 border-b">
                                    <th class="text-left py-3 px-4 font-semibold text-primary">Driver</th>
                                    <th class="text-left py-3 px-4 font-semibold text-primary">SACCO</th>
                                    <th class="text-left py-3 px-4 font-semibold text-primary route-cell">Route</th>
                                    <th class="text-left py-3 px-4 font-semibold text-primary">Departure</th>
                                    <th class="text-left py-3 px-4 font-semibold text-primary">Price</th>
                                    <th class="text-left py-3 px-4 font-semibold text-primary">Seats</th>
                                    <th class="text-right py-3 px-4 font-semibold text-primary">Action</th>
                                </tr>
                            </thead>
                            <tbody id="resultsTableBody">
                                <!-- Results will be populated here -->
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-gray-600 mb-4">Ready to book? Create an account to proceed with your booking.</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('register.passenger') }}" class="btn-primary">
                                Register as Passenger
                            </a>
                            <a href="{{ route('login') }}" class="btn-secondary">
                                Already have an account? Login
                            </a>
                        </div>
                    </div>
                </div>

                <!-- No Results -->
                <div id="noResults" style="display: none;">
                    <div class="text-center py-8">
                        <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-primary mb-2">No Rides Found</h3>
                        <p class="text-gray-600 mb-4">Sorry, no rides match your search criteria. Try adjusting your pickup location or destination.</p>
                        <button onclick="resetSearch()" class="btn-primary">
                            Try Another Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking/Payment Modal -->
    <div id="bookingPaymentModal" class="booking-modal">
        <div class="booking-modal-content">
            <div class="modal-header">
                <h2 class="text-2xl font-bold">Complete Your Booking</h2>
                <button class="modal-close" onclick="closeBookingPaymentModal()">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Booking Form -->
                <div id="bookingForm" class="space-y-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-primary mb-2">Trip Details</h3>
                        <div id="tripDetails" class="text-sm text-gray-600">
                            <!-- Trip details will be populated here -->
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="passengerName" class="block text-sm font-semibold text-primary mb-2">Full Name</label>
                            <input type="text" id="passengerName" name="passenger_name" class="form-input" placeholder="Enter your full name" required>
                        </div>
                        
                        <div>
                            <label for="passengerEmail" class="block text-sm font-semibold text-primary mb-2">Email Address</label>
                            <input type="email" id="passengerEmail" name="passenger_email" class="form-input" placeholder="Enter your email" required>
                        </div>
                        
                        <div>
                            <label for="passengerPhone" class="block text-sm font-semibold text-primary mb-2">Phone Number</label>
                            <input type="tel" id="passengerPhone" name="passenger_phone" class="form-input" placeholder="254712345678" required>
                            <p class="text-xs text-gray-500 mt-1">Enter your M-Pesa phone number</p>
                        </div>
                        
                        <div>
                            <label for="seatsCount" class="block text-sm font-semibold text-primary mb-2">Number of Seats</label>
                            <select id="seatsCount" name="seats" class="form-input" required>
                                <option value="1">1 Seat</option>
                                <option value="2">2 Seats</option>
                                <option value="3">3 Seats</option>
                                <option value="4">4 Seats</option>
                            </select>
                        </div>
                        
                        <!-- Seat Selection -->
                        <div>
                            <label class="block text-sm font-semibold text-primary mb-2">Select Your Seats</label>
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <!-- Vehicle Layout -->
                                <div class="vehicle-layout max-w-sm mx-auto">
                                    <!-- Driver Area -->
                                    <div class="flex justify-between items-center mb-4">
                                        <div class="driver-seat bg-gray-300 w-12 h-8 rounded flex items-center justify-center text-xs font-medium">
                                            Driver
                                        </div>
                                        <div class="door-indicator text-xs text-gray-500">Door</div>
                                    </div>
                                    
                                    <!-- Passenger Seats -->
                                    <div class="seats-grid space-y-3">
                                        <!-- Row 1 -->
                                        <div class="flex justify-between">
                                            <div class="seat available" data-seat="1">1</div>
                                            <div class="seat available" data-seat="2">2</div>
                                            <div class="aisle w-4"></div>
                                            <div class="seat available" data-seat="3">3</div>
                                        </div>
                                        
                                        <!-- Row 2 -->
                                        <div class="flex justify-between">
                                            <div class="seat available" data-seat="4">4</div>
                                            <div class="seat available" data-seat="5">5</div>
                                            <div class="aisle w-4"></div>
                                            <div class="seat available" data-seat="6">6</div>
                                        </div>
                                        
                                        <!-- Row 3 -->
                                        <div class="flex justify-between">
                                            <div class="seat available" data-seat="7">7</div>
                                            <div class="seat available" data-seat="8">8</div>
                                            <div class="aisle w-4"></div>
                                            <div class="seat available" data-seat="9">9</div>
                                        </div>
                                        
                                        <!-- Row 4 -->
                                        <div class="flex justify-between">
                                            <div class="seat available" data-seat="10">10</div>
                                            <div class="seat available" data-seat="11">11</div>
                                            <div class="aisle w-4"></div>
                                            <div class="seat available" data-seat="12">12</div>
                                        </div>
                                        
                                        <!-- Back Row -->
                                        <div class="flex justify-center space-x-2">
                                            <div class="seat available" data-seat="13">13</div>
                                            <div class="seat available" data-seat="14">14</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Legend -->
                                <div class="flex justify-center space-x-6 mt-6">
                                    <div class="flex items-center">
                                        <div class="seat available w-6 h-6 mr-2"></div>
                                        <span class="text-xs">Available</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="seat occupied w-6 h-6 mr-2"></div>
                                        <span class="text-xs">Occupied</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="seat selected w-6 h-6 mr-2"></div>
                                        <span class="text-xs">Selected</span>
                                    </div>
                                </div>
                                
                                <!-- Selected Seats Display -->
                                <div class="mt-4 text-center">
                                    <p class="text-sm text-gray-600">Selected seats: <span id="selectedSeatsDisplay" class="font-medium text-primary">None</span></p>
                                </div>
                                
                                <!-- Hidden input to store selected seats -->
                                <input type="hidden" id="selectedSeats" name="selected_seats" value="">
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold">Total Amount:</span>
                            <span id="totalAmount" class="text-2xl font-bold text-secondary">KES 0</span>
                        </div>
                        <p class="text-sm text-gray-600">Payment will be processed via M-Pesa STK Push</p>
                    </div>
                    
                    <button id="initiatePaymentBtn" class="btn-primary w-full">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        Proceed to Payment
                    </button>
                </div>
                
                <!-- Payment Processing -->
                <div id="paymentProcessing" class="payment-status" style="display: none;">
                    <div class="icon processing">
                        <div class="spinner-payment"></div>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-2">Processing Payment</h3>
                    <p class="text-gray-600 mb-4">Please complete the payment on your phone. Check your M-Pesa notifications and enter your PIN.</p>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">
                            <strong>Amount:</strong> <span id="processingAmount"></span><br>
                            <strong>Phone:</strong> <span id="processingPhone"></span><br>
                            <strong>Reference:</strong> <span id="processingReference"></span>
                        </p>
                    </div>
                </div>
                
                <!-- Payment Success -->
                <div id="paymentSuccess" class="payment-status" style="display: none;">
                    <div class="icon success">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-green-600 mb-2">Payment Successful!</h3>
                    <p class="text-gray-600 mb-4">Your booking has been confirmed. Here's your receipt:</p>
                    
                    <div id="receiptContainer" class="receipt">
                        <!-- Receipt will be populated here -->
                    </div>
                    
                    <div class="flex gap-3 mt-6">
                        <button onclick="downloadReceipt()" class="btn-secondary flex-1">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download Receipt
                        </button>
                        <button onclick="closeBookingPaymentModal()" class="btn-primary flex-1">
                            Close
                        </button>
                    </div>
                </div>
                
                <!-- Payment Failed -->
                <div id="paymentFailed" class="payment-status" style="display: none;">
                    <div class="icon failed">
                        <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-red-600 mb-2">Payment Failed</h3>
                    <p class="text-gray-600 mb-4" id="paymentErrorMessage">The payment could not be processed. Please try again.</p>
                    
                    <div class="flex gap-3 mt-6">
                        <button onclick="retryPayment()" class="btn-secondary flex-1">
                            Try Again
                        </button>
                        <button onclick="closeBookingPaymentModal()" class="btn-primary flex-1">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Modal functionality
        function openBookingModal() {
            document.getElementById('bookingModal').classList.add('active');
            document.body.style.overflow = 'hidden';
            loadSaccos();
        }

        function closeBookingModal() {
            document.getElementById('bookingModal').classList.remove('active');
            document.body.style.overflow = 'auto';
            resetSearch();
        }

        function resetSearch() {
            document.getElementById('searchForm').reset();
            document.getElementById('searchResults').style.display = 'none';
            document.getElementById('noResults').style.display = 'none';
            document.getElementById('loadingIndicator').classList.remove('active');
        }

        // Load SACCOs for the modal
        async function loadSaccos() {
            try {
                const response = await fetch('/api/saccos');
                const saccos = await response.json();
                
                const select = document.getElementById('modal-sacco');
                select.innerHTML = '<option value="">Choose a SACCO</option>';
                
                saccos.forEach(sacco => {
                    const option = document.createElement('option');
                    option.value = sacco.id;
                    option.textContent = sacco.name + ' - ' + sacco.full_route;
                    select.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading SACCOs:', error);
            }
        }

        // Handle search form submission
        document.getElementById('searchForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const searchData = {
                sacco_id: formData.get('sacco_id'),
                pickup: formData.get('pickup'),
                destination: formData.get('destination')
            };

            // Show loading indicator
            document.getElementById('loadingIndicator').classList.add('active');
            document.getElementById('searchResults').style.display = 'none';
            document.getElementById('noResults').style.display = 'none';

            try {
                const response = await fetch('/api/search-rides', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(searchData)
                });

                const result = await response.json();
                
                // Hide loading indicator
                document.getElementById('loadingIndicator').classList.remove('active');

                if (result.success && result.trips.length > 0) {
                    displayResults(result.trips);
                } else {
                    document.getElementById('noResults').style.display = 'block';
                }
            } catch (error) {
                console.error('Error searching rides:', error);
                document.getElementById('loadingIndicator').classList.remove('active');
                document.getElementById('noResults').style.display = 'block';
            }
        });

        // Display search results
        function displayResults(trips) {
            // Store results globally for booking
            window.lastSearchResults = trips;
            
            const resultsCount = document.getElementById('resultsCount');
            const tableBody = document.getElementById('resultsTableBody');
            
            resultsCount.textContent = trips.length + ' ride(s) found matching your search';
            
            tableBody.innerHTML = '';
            
            trips.forEach(trip => {
                const row = document.createElement('tr');
                row.className = 'border-b hover:bg-gray-50 transition-colors';
                
                const departureDate = new Date(trip.departure_time);
                const formattedDate = departureDate.toLocaleDateString('en-US', { 
                    month: 'short', 
                    day: 'numeric', 
                    year: 'numeric' 
                });
                const formattedTime = departureDate.toLocaleTimeString('en-US', { 
                    hour: 'numeric', 
                    minute: '2-digit',
                    hour12: true 
                });
                
                // Create cells programmatically to avoid template string issues
                const driverCell = document.createElement('td');
                driverCell.className = 'py-4 px-4';
                driverCell.innerHTML = '<div class="flex items-center">' +
                    '<div class="w-10 h-10 bg-gradient-navy rounded-full flex items-center justify-center mr-3">' +
                    '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>' +
                    '</svg></div>' +
                    '<div><div class="font-medium text-primary">' + trip.driver.user.name + '</div>' +
                    '<div class="text-sm text-gray-600">' + trip.driver.license_number + '</div></div></div>';
                
                const saccoCell = document.createElement('td');
                saccoCell.className = 'py-4 px-4';
                saccoCell.innerHTML = '<div class="text-sm font-medium text-primary">' + trip.sacco.name + '</div>' +
                    '<div class="text-xs text-gray-600">' + trip.sacco.route + '</div>';
                
                const routeCell = document.createElement('td');
                routeCell.className = 'py-4 px-4 route-cell';
                routeCell.innerHTML = '<div class="text-sm">' +
                    '<div class="font-medium text-gray-900">' + trip.from_location + '</div>' +
                    '<div class="text-gray-600 text-xs">to</div>' +
                    '<div class="font-medium text-gray-900">' + trip.to_location + '</div></div>';
                
                const timeCell = document.createElement('td');
                timeCell.className = 'py-4 px-4';
                timeCell.innerHTML = '<div class="text-sm">' +
                    '<div class="font-medium text-gray-900">' + formattedDate + '</div>' +
                    '<div class="text-gray-600">' + formattedTime + '</div></div>';
                
                const priceCell = document.createElement('td');
                priceCell.className = 'py-4 px-4';
                priceCell.innerHTML = '<div class="text-lg font-bold text-secondary">' + trip.formatted_amount + '</div>';
                
                const seatsCell = document.createElement('td');
                seatsCell.className = 'py-4 px-4';
                seatsCell.innerHTML = '<div class="text-sm">' +
                    '<div class="font-medium text-gray-900">' + trip.remaining_seats + ' available</div>' +
                    '<div class="text-gray-600 text-xs">of ' + trip.available_seats + ' total</div></div>';
                
                const actionCell = document.createElement('td');
                actionCell.className = 'py-4 px-4 text-right';
                const bookButton = document.createElement('button');
                bookButton.className = 'book-btn';
                bookButton.textContent = 'Book Now';
                bookButton.setAttribute('data-trip-id', trip.id);
                bookButton.onclick = function() { initiateBooking(trip.id); };
                actionCell.appendChild(bookButton);
                
                row.appendChild(driverCell);
                row.appendChild(saccoCell);
                row.appendChild(routeCell);
                row.appendChild(timeCell);
                row.appendChild(priceCell);
                row.appendChild(seatsCell);
                row.appendChild(actionCell);
                
                tableBody.appendChild(row);
            });
            
            document.getElementById('searchResults').style.display = 'block';
        }

        // Global variables for booking
        let selectedTrip = null;
        let bookingData = null;
        let paymentStatusInterval = null;

        // Initiate booking process
        function initiateBooking(tripId) {
            // Find the trip from the last search results
            const tripData = window.lastSearchResults?.find(trip => trip.id === tripId);
            if (!tripData) {
                alert('Trip information not found. Please search again.');
                return;
            }
            
            selectedTrip = tripData;
            openBookingPaymentModal();
        }

        // Open booking/payment modal
        function openBookingPaymentModal() {
            if (!selectedTrip) {
                alert('Please select a trip first.');
                return;
            }

            document.getElementById('bookingPaymentModal').classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Populate trip details
            populateTripDetails(selectedTrip);
            
            // Show booking form
            showBookingForm();
            
            // Initialize seat selection
            initializeSeatSelection();
            
            // Update total amount when seats change
            document.getElementById('seatsCount').addEventListener('change', updateTotalAmount);
            updateTotalAmount();
        }

        // Close booking/payment modal
        function closeBookingPaymentModal() {
            document.getElementById('bookingPaymentModal').classList.remove('active');
            document.body.style.overflow = 'auto';
            
            // Clear any payment status interval
            if (paymentStatusInterval) {
                clearInterval(paymentStatusInterval);
                paymentStatusInterval = null;
            }
            
            // Reset form
            resetBookingForm();
        }

        // Populate trip details
        function populateTripDetails(trip) {
            const departureDate = new Date(trip.departure_time);
            const formattedDate = departureDate.toLocaleDateString('en-US', { 
                weekday: 'long',
                year: 'numeric',
                month: 'long', 
                day: 'numeric' 
            });
            const formattedTime = departureDate.toLocaleTimeString('en-US', { 
                hour: 'numeric', 
                minute: '2-digit',
                hour12: true 
            });
            
            const tripDetailsHtml = '<div class="grid grid-cols-1 md:grid-cols-2 gap-4">' +
                '<div>' +
                '<strong>SACCO:</strong> ' + trip.sacco.name + '<br>' +
                '<strong>Driver:</strong> ' + trip.driver.user.name + '<br>' +
                '<strong>Route:</strong> ' + trip.from_location + ' to ' + trip.to_location +
                '</div>' +
                '<div>' +
                '<strong>Departure:</strong> ' + formattedDate + '<br>' +
                '<strong>Time:</strong> ' + formattedTime + '<br>' +
                '<strong>Price per seat:</strong> ' + trip.formatted_amount +
                '</div>' +
                '</div>';
            
            document.getElementById('tripDetails').innerHTML = tripDetailsHtml;
        }

        // Update total amount
        function updateTotalAmount() {
            const seats = parseInt(document.getElementById('seatsCount').value) || 1;
            const totalAmount = selectedTrip.amount * seats;
            document.getElementById('totalAmount').textContent = 'KES ' + totalAmount.toLocaleString();
        }

        // Show booking form
        function showBookingForm() {
            document.getElementById('bookingForm').style.display = 'block';
            document.getElementById('paymentProcessing').style.display = 'none';
            document.getElementById('paymentSuccess').style.display = 'none';
            document.getElementById('paymentFailed').style.display = 'none';
        }

        // Reset booking form
        function resetBookingForm() {
            document.getElementById('bookingForm').reset();
            selectedTrip = null;
            bookingData = null;
            
            // Reset seat selection
            selectedSeats = [];
            const seats = document.querySelectorAll('.seat');
            seats.forEach(seat => {
                seat.classList.remove('selected');
                if (!seat.classList.contains('occupied')) {
                    seat.classList.add('available');
                }
            });
            
            // Reset seat display
            const selectedSeatsDisplay = document.getElementById('selectedSeatsDisplay');
            const selectedSeatsInput = document.getElementById('selectedSeats');
            if (selectedSeatsDisplay) selectedSeatsDisplay.textContent = 'None';
            if (selectedSeatsInput) selectedSeatsInput.value = '';
            
            showBookingForm();
        }

        // Handle payment initiation
        document.getElementById('initiatePaymentBtn').addEventListener('click', async function() {
            // Validate seat selection first
            if (!validateBookingForm()) {
                return;
            }
            
            const form = document.getElementById('bookingForm');
            const formData = new FormData(form);
            
            // Validate form
            const passengerName = formData.get('passenger_name') || document.getElementById('passengerName').value;
            const passengerEmail = formData.get('passenger_email') || document.getElementById('passengerEmail').value;
            const passengerPhone = formData.get('passenger_phone') || document.getElementById('passengerPhone').value;
            const seats = parseInt(formData.get('seats') || document.getElementById('seatsCount').value);
            
            if (!passengerName || !passengerEmail || !passengerPhone || !seats) {
                alert('Please fill in all required fields.');
                return;
            }
            
            // Format phone number
            let phone = passengerPhone.replace(/\D/g, '');
            if (phone.startsWith('0')) {
                phone = '254' + phone.substring(1);
            } else if (!phone.startsWith('254')) {
                phone = '254' + phone;
            }
            
            const bookingRequest = {
                trip_id: selectedTrip.id,
                passenger_name: passengerName,
                passenger_email: passengerEmail,
                passenger_phone: phone,
                seats: seats
            };
            
            try {
                showPaymentProcessing();
                
                const response = await fetch('/api/initiate-booking', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(bookingRequest)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    bookingData = result;
                    
                    // Update processing details
                    document.getElementById('processingAmount').textContent = 'KES ' + result.amount.toLocaleString();
                    document.getElementById('processingPhone').textContent = phone;
                    document.getElementById('processingReference').textContent = result.booking_reference;
                    
                    // Start checking payment status
                    startPaymentStatusCheck(result.checkout_request_id);
                } else {
                    showPaymentFailed(result.message || 'Failed to initiate payment');
                }
                
            } catch (error) {
                console.error('Booking error:', error);
                showPaymentFailed('An error occurred while processing your booking');
            }
        });

        // Show payment processing
        function showPaymentProcessing() {
            document.getElementById('bookingForm').style.display = 'none';
            document.getElementById('paymentProcessing').style.display = 'block';
            document.getElementById('paymentSuccess').style.display = 'none';
            document.getElementById('paymentFailed').style.display = 'none';
        }

        // Start payment status check
        function startPaymentStatusCheck(checkoutRequestId) {
            let attempts = 0;
            const maxAttempts = 60; // 5 minutes max (5 second intervals)
            
            paymentStatusInterval = setInterval(async () => {
                attempts++;
                
                if (attempts > maxAttempts) {
                    clearInterval(paymentStatusInterval);
                    showPaymentFailed('Payment timeout. Please try again.');
                    return;
                }
                
                try {
                    const response = await fetch('/api/check-payment-status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({
                            checkout_request_id: checkoutRequestId
                        })
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        if (result.payment_status === 'completed') {
                            clearInterval(paymentStatusInterval);
                            showPaymentSuccess(result.receipt_data);
                        } else if (result.payment_status === 'failed') {
                            clearInterval(paymentStatusInterval);
                            showPaymentFailed(result.message || 'Payment failed');
                        }
                        // Continue checking if status is still 'processing'
                    }
                } catch (error) {
                    console.error('Payment status check error:', error);
                    // Continue checking
                }
            }, 5000); // Check every 5 seconds
        }

        // Show payment success
        function showPaymentSuccess(receiptData) {
            document.getElementById('bookingForm').style.display = 'none';
            document.getElementById('paymentProcessing').style.display = 'none';
            document.getElementById('paymentSuccess').style.display = 'block';
            document.getElementById('paymentFailed').style.display = 'none';
            
            // Populate receipt
            if (receiptData) {
                document.getElementById('receiptContainer').innerHTML = receiptData;
            }
        }

        // Show payment failed
        function showPaymentFailed(message) {
            document.getElementById('bookingForm').style.display = 'none';
            document.getElementById('paymentProcessing').style.display = 'none';
            document.getElementById('paymentSuccess').style.display = 'none';
            document.getElementById('paymentFailed').style.display = 'block';
            
            document.getElementById('paymentErrorMessage').textContent = message;
        }

        // Retry payment
        function retryPayment() {
            showBookingForm();
        }

        // Download receipt
        function downloadReceipt() {
            if (bookingData && bookingData.booking_reference) {
                const receiptUrl = '/receipt/' + bookingData.booking_reference + '?print=true';
                window.open(receiptUrl, '_blank');
            } else {
                const receiptContent = document.getElementById('receiptContainer').innerHTML;
                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <html>
                        <head>
                            <title>Booking Receipt</title>
                            <style>
                                body { font-family: Arial, sans-serif; margin: 20px; }
                                .receipt { border: 2px solid #333; padding: 20px; max-width: 600px; }
                                .receipt-header { text-align: center; margin-bottom: 20px; }
                                .receipt-row { display: flex; justify-content: space-between; margin: 10px 0; }
                                .receipt-row.total { font-weight: bold; border-top: 1px solid #333; padding-top: 10px; }
                            </style>
                        </head>
                        <body>
                            <div class="receipt">
                                ${receiptContent}
                            </div>
                        </body>
                    </html>
                `);
                printWindow.document.close();
                printWindow.print();
            }
        }

        // Close modal when clicking outside
        document.getElementById('bookingModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBookingModal();
            }
        });

        // Close booking payment modal when clicking outside
        document.getElementById('bookingPaymentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBookingPaymentModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (document.getElementById('bookingModal').classList.contains('active')) {
                    closeBookingModal();
                } else if (document.getElementById('bookingPaymentModal').classList.contains('active')) {
                    closeBookingPaymentModal();
                }
            }
        });

        // Carousel functionality
        let currentSlideIndex = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        const totalSlides = slides.length;

        function showSlide(index) {
            // Hide all slides
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            
            // Show current slide
            slides[index].classList.add('active');
            dots[index].classList.add('active');
            
            currentSlideIndex = index;
        }

        function changeSlide(direction) {
            currentSlideIndex += direction;
            
            if (currentSlideIndex >= totalSlides) {
                currentSlideIndex = 0;
            } else if (currentSlideIndex < 0) {
                currentSlideIndex = totalSlides - 1;
            }
            
            showSlide(currentSlideIndex);
        }

        function currentSlide(index) {
            showSlide(index - 1);
        }

        // Auto-advance carousel
        setInterval(() => {
            changeSlide(1);
        }, 5000);

        // Pause auto-advance on hover
        const carousel = document.querySelector('.carousel-container');
        let autoAdvance = true;

        carousel.addEventListener('mouseenter', () => {
            autoAdvance = false;
        });

        carousel.addEventListener('mouseleave', () => {
            autoAdvance = true;
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add scroll animation trigger
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                }
            });
        }, observerOptions);

        // Seat selection functionality
        let selectedSeats = [];
        let maxSeats = 1;

        // Initialize seat selection
        function initializeSeatSelection() {
            const seats = document.querySelectorAll('.seat.available');
            const seatsCountSelect = document.getElementById('seatsCount');
            const selectedSeatsInput = document.getElementById('selectedSeats');
            const selectedSeatsDisplay = document.getElementById('selectedSeatsDisplay');

            // Update max seats when dropdown changes
            seatsCountSelect.addEventListener('change', function() {
                maxSeats = parseInt(this.value);
                // Clear selections if exceeding new limit
                if (selectedSeats.length > maxSeats) {
                    selectedSeats = selectedSeats.slice(0, maxSeats);
                    updateSeatDisplay();
                }
            });

            // Handle seat clicks
            seats.forEach(seat => {
                seat.addEventListener('click', function() {
                    const seatNumber = this.getAttribute('data-seat');
                    
                    if (this.classList.contains('occupied')) {
                        return; // Can't select occupied seats
                    }

                    if (this.classList.contains('selected')) {
                        // Deselect seat
                        const index = selectedSeats.indexOf(seatNumber);
                        if (index > -1) {
                            selectedSeats.splice(index, 1);
                        }
                        this.classList.remove('selected');
                        this.classList.add('available');
                    } else {
                        // Select seat
                        if (selectedSeats.length < maxSeats) {
                            selectedSeats.push(seatNumber);
                            this.classList.remove('available');
                            this.classList.add('selected');
                        } else {
                            // Show message if trying to select too many seats
                            alert(`You can only select ${maxSeats} seat(s). Please deselect a seat first.`);
                        }
                    }

                    updateSeatDisplay();
                });
            });

            function updateSeatDisplay() {
                if (selectedSeats.length === 0) {
                    selectedSeatsDisplay.textContent = 'None';
                    selectedSeatsInput.value = '';
                } else {
                    selectedSeatsDisplay.textContent = selectedSeats.sort((a, b) => parseInt(a) - parseInt(b)).join(', ');
                    selectedSeatsInput.value = selectedSeats.join(',');
                }
            }
        }

        // Form validation enhancement
        function validateBookingForm() {
            const selectedSeatsInput = document.getElementById('selectedSeats');
            const seatsCount = parseInt(document.getElementById('seatsCount').value);
            
            if (!selectedSeatsInput.value || selectedSeats.length === 0) {
                alert('Please select your seat(s) before booking.');
                return false;
            }
            
            if (selectedSeats.length !== seatsCount) {
                alert(`Please select exactly ${seatsCount} seat(s).`);
                return false;
            }
            
            return true;
        }

        // Observe elements for animation
        document.querySelectorAll('.feature-card, .carousel-container').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>