<x-guest-layout>
    <div class="text-center mb-4">
        <h2 class="text-lg font-bold text-primary mb-1">Reset Password</h2>
        <p class="text-gray-600 text-xs">Please enter your new password</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-3">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold text-primary mb-1">Email Address</label>
            <div class="relative">
                <input id="email" 
                       class="form-input text-xs" 
                       type="email" 
                       name="email" 
                       value="{{ old('email', $request->email) }}" 
                       required 
                       autofocus 
                       autocomplete="username" 
                       placeholder="Enter your email address" />
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-primary mb-1">New Password</label>
            <div class="relative">
                <input id="password" 
                       class="form-input text-xs" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="new-password" 
                       placeholder="Enter new password" />
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-primary mb-1">Confirm Password</label>
            <div class="relative">
                <input id="password_confirmation" 
                       class="form-input text-xs"
                       type="password"
                       name="password_confirmation" 
                       required 
                       autocomplete="new-password" 
                       placeholder="Confirm new password" />
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="space-y-2 mt-4">
            <button type="submit" class="btn-primary text-xs">
                <svg class="w-3 h-3 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
                Reset Password
            </button>

            <div class="text-center">
                <div class="text-xs text-gray-600">
                    Remember your password? 
                    <a href="{{ route('login') }}" class="link-secondary">Sign in here</a>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
