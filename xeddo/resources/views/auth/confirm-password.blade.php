<x-guest-layout>
    <div class="text-center mb-4">
        <h2 class="text-lg font-bold text-primary mb-1">Confirm Password</h2>
        <p class="text-gray-600 text-xs">This is a secure area of the application. Please confirm your password before continuing.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-3">
        @csrf

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold text-primary mb-1">Password</label>
            <div class="relative">
                <input id="password" 
                       class="form-input text-xs"
                       type="password"
                       name="password"
                       required 
                       autocomplete="current-password" 
                       placeholder="Enter your password" />
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="space-y-2 mt-4">
            <button type="submit" class="btn-primary text-xs">
                <svg class="w-3 h-3 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Confirm
            </button>

            <div class="text-center">
                <div class="text-xs text-gray-600">
                    <a href="{{ route('login') }}" class="link-secondary">Back to login</a>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
