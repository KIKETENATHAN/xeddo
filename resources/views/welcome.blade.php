<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Xeddo - Premium Ride Sharing Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                        <h1 class="text-2xl font-bold text-primary">Xeddo</h1>
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
                        <a href="{{ route('register.passenger') }}" class="btn-primary text-lg px-8 py-4 floating-animation">
                            Book Your Ride
                        </a>
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
                                <a href="{{ route('register.passenger') }}" class="btn-primary w-full text-center block">
                                    Get Started as Passenger
                                </a>
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
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                        <ul class="space-y-2 text-blue-200">
                            <li><a href="#" class="hover:text-secondary transition-colors">About Us</a></li>
                            <li><a href="#" class="hover:text-secondary transition-colors">How It Works</a></li>
                            <li><a href="#" class="hover:text-secondary transition-colors">Safety</a></li>
                            <li><a href="#" class="hover:text-secondary transition-colors">Support</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Legal</h4>
                        <ul class="space-y-2 text-blue-200">
                            <li><a href="#" class="hover:text-secondary transition-colors">Terms of Service</a></li>
                            <li><a href="#" class="hover:text-secondary transition-colors">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-secondary transition-colors">Cookie Policy</a></li>
                            <li><a href="#" class="hover:text-secondary transition-colors">Accessibility</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-blue-700 mt-8 pt-8 text-center">
                    <p class="text-blue-200">
                        © 2025 Xeddo. All rights reserved. | Designed with ❤️ for better transportation
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
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

        // Observe elements for animation
        document.querySelectorAll('.feature-card, .carousel-container').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>