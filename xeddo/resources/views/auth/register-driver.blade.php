<x-guest-layout>
    <div class="text-center mb-4">
        <h2 class="text-lg font-bold text-primary mb-1">Register as Driver</h2>
        <p class="text-gray-600 text-xs">Join Xeddo and start earning by driving passengers</p>
    </div>

    <form class="space-y-3" action="{{ route('register.driver.store') }}" method="POST">
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
                <label for="address" class="block text-xs font-semibold text-primary mb-1">Address</label>
                <div class="relative">
                    <textarea id="address" 
                              name="address" 
                              required 
                              class="form-input text-xs" 
                              placeholder="Enter your address" 
                              rows="2">{{ old('address') }}</textarea>
                    <div class="absolute top-3 right-0 pr-3 flex items-start pointer-events-none">
                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('address')" class="mt-1" />
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                </svg>
                Create Driver Account
            </button>

            <div class="text-center space-y-1">
                <div class="text-xs text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="link-secondary">Sign in here</a>
                </div>
                <div class="text-xs text-gray-600">
                    Want to be a passenger? 
                    <a href="{{ route('register.passenger') }}" class="link-secondary">Register as Passenger</a>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
