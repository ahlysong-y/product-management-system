<x-guest-layout>
    <div class="mb-8 text-center lg:text-left">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Create an Account</h2>
        <p class="text-gray-500 text-sm mt-2">Join us to manage your products efficiently.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Full Name') }}</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4 text-gray-900 bg-gray-50/50 transition-all duration-200" placeholder="John Doe">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Email Address') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4 text-gray-900 bg-gray-50/50 transition-all duration-200" placeholder="john@example.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" 
                class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4 text-gray-900 bg-gray-50/50 transition-all duration-200" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3 px-4 text-gray-900 bg-gray-50/50 transition-all duration-200" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 active:scale-[0.98]">
                {{ __('Create Account') }}
            </button>
        </div>

        <div class="mt-6 text-center text-sm text-gray-600">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">Sign in instead</a>
        </div>
    </form>
</x-guest-layout>
