<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Xeddo Travel Link') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.jpg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
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

            .auth-bg {
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                position: relative;
                overflow: hidden;
            }

            .auth-bg::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse"><path d="M 50 0 L 0 0 0 50" fill="none" stroke="rgba(30,58,138,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
                opacity: 0.3;
            }

            .auth-card {
                background: white;
                border-radius: 1rem;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                border: 1px solid rgba(30, 58, 138, 0.1);
                position: relative;
                z-index: 10;
            }

            .logo-container {
                background: var(--gradient-navy);
                border-radius: 0.75rem;
                padding: 0.75rem;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1rem;
                box-shadow: 0 6px 20px rgba(30, 58, 138, 0.25);
            }

            .form-input {
                border: 2px solid #e5e7eb;
                border-radius: 0.375rem;
                padding: 0.375rem 2.25rem 0.375rem 0.75rem;
                transition: all 0.3s ease;
                background: white;
                color: #374151;
                width: 100%;
                font-size: 0.75rem;
                line-height: 1rem;
                min-height: 2.25rem;
            }

            .form-input:focus {
                border-color: var(--secondary-gold);
                box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
                outline: none;
            }

            .btn-primary {
                background: var(--gradient-navy);
                color: white;
                padding: 0.375rem 1.25rem;
                border-radius: 0.375rem;
                font-weight: 600;
                text-decoration: none;
                display: inline-block;
                transition: all 0.3s ease;
                border: none;
                cursor: pointer;
                box-shadow: 0 3px 12px rgba(30, 58, 138, 0.25);
                width: 100%;
                font-size: 0.75rem;
                min-height: 2.25rem;
            }

            /* Responsive grid for forms */
            .form-grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }
            
            @media (min-width: 640px) {
                .form-grid {
                    grid-template-columns: 1fr 1fr;
                    gap: 1rem;
                }
                .form-grid-full {
                    grid-column: 1 / -1;
                }
            }

            @media (min-width: 768px) {
                .form-grid {
                    gap: 1.25rem;
                }
                
                .form-input {
                    font-size: 0.875rem;
                    line-height: 1.25rem;
                    min-height: 2.5rem;
                    padding: 0.5rem 2.5rem 0.5rem 0.875rem;
                }
                
                .btn-primary {
                    font-size: 0.875rem;
                    min-height: 2.5rem;
                    padding: 0.5rem 1.5rem;
                }
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(30, 58, 138, 0.4);
            }

            .link-secondary {
                color: var(--secondary-gold);
                text-decoration: none;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .link-secondary:hover {
                color: var(--secondary-gold-dark);
                text-decoration: underline;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased auth-bg">
        <div class="min-h-screen flex flex-col justify-center items-center py-1 px-1">
            <div class="text-center mb-3">
                <div class="logo-container mb-3">
                    <x-application-logo type="full" size="large" class="mx-auto" />
                </div>
                <p class="text-gray-600 text-xs">Your premium ride-sharing platform</p>
            </div>

            <div class="w-full max-w-2xl auth-card px-3 py-3">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
