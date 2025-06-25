<x-guest-layout>
    <!-- Welcome back message -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Welcome back!</h2>
        <p class="text-gray-600 text-sm">
            Ready to dive back into your thoughts? Let's get you signed in.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" class="text-gray-700 font-medium">Your email</x-input-label>
            <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" type="email" name="email" :value="old('email')" placeholder="you@example.com" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" class="text-gray-700 font-medium">Password</x-input-label>
            <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
            <label for="remember_me" class="ml-2 text-sm text-gray-600">
                Keep me signed in
            </label>
        </div>

        <!-- Submit and Links -->
        <div class="space-y-4">
            <x-primary-button class="w-full justify-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 rounded-lg py-3 text-white font-medium">
                Sign in
            </x-primary-button>

            <div class="text-center space-y-2">
                @if (Route::has('password.request'))
                    <div>
                        <a class="text-sm text-blue-600 hover:text-blue-800 underline" href="{{ route('password.request') }}">
                            Forgot your password?
                        </a>
                    </div>
                @endif
                
                <div class="text-sm text-gray-600">
                    Don't have an account yet? 
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 underline font-medium">
                        Sign up here
                    </a>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
