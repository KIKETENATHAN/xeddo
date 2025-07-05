<x-guest-layout>
    <div class="text-center mb-4">
        <h2 class="text-lg font-bold text-primary mb-1">Register as Passenger</h2>
        <p class="text-gray-600 text-xs">Join thousands of passengers who travel comfortably with Xeddo</p>
    </div>

    <form class="space-y-3" action="{{ route('register.passenger.store') }}" method="POST">
        @csrf
        
        <div class="form-grid">
            <div>
                <label for="name" class="block text-xs font-semibold text-primary mb-1">Full Name</label>
                <div class="relative">
                    <input id="name" 
                           name="name" 
                           type="text" 
                           required 
                           class="form-input text-xs" 
                           placeholder="Enter your full name" 
                           value="{{ old('name') }}">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold text-primary mb-1">Email Address</label>
                <div class="relative">
                    <input id="email" 
                           name="email" 
                           type="email" 
                           required 
                           class="form-input text-xs" 
                           placeholder="Enter your email address" 
                           value="{{ old('email') }}">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div>
                <label for="phone" class="block text-xs font-semibold text-primary mb-1">Phone Number</label>
                <div class="relative">
                    <input id="phone" 
                           name="phone" 
                           type="tel" 
                           required 
                           class="form-input text-xs" 
                           placeholder="0712345678" 
                           value="{{ old('phone') }}">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('phone')" class="mt-1" />
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-primary mb-1">Password</label>
                <div class="relative">
                    <input id="password" 
                           name="password" 
                           type="password" 
                           required 
                           class="form-input text-xs" 
                           placeholder="Enter a secure password">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <div class="form-grid-full">
                <label for="password_confirmation" class="block text-xs font-semibold text-primary mb-1">Confirm Password</label>
                <div class="relative">
                    <input id="password_confirmation" 
                           name="password_confirmation" 
                           type="password" 
                           required 
                           class="form-input text-xs" 
                           placeholder="Confirm your password">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>
        </div>

        <div class="space-y-2 mt-4">
            <button type="submit" class="btn-primary text-xs">
                <svg class="w-3 h-3 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Create Passenger Account
            </button>

            <div class="text-center space-y-1">
                <div class="text-xs text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="link-secondary">Sign in here</a>
                </div>
                <div class="text-xs text-gray-600">
                    Want to drive instead? 
                    <a href="{{ route('register.driver') }}" class="link-secondary">Register as Driver</a>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
