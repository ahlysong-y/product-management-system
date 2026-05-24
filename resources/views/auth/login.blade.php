<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8 text-center lg:text-left">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Welcome Back</h2>
        <p class="text-gray-500 text-sm mt-2">Please enter your details to access your dashboard.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Email Address') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4 text-gray-900 bg-gray-50/50 transition-all duration-200" placeholder="admin@example.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1.5">
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password" 
                class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4 text-gray-900 bg-gray-50/50 transition-all duration-200" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-colors" name="remember">
            <label for="remember_me" class="ml-2 block text-sm text-gray-600">
                {{ __('Remember me for 30 days') }}
            </label>
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 active:scale-[0.98]">
                {{ __('Sign In') }}
            </button>
        </div>
        
        <div class="mt-6 text-center text-sm text-gray-600">
            Don't have an account? 
            <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">Create account</a>
        </div>
    </form>
</x-guest-layout>
