<x-guest-layout>
    <!-- Welcome message -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Join GTAW</h2>
        <p class="text-gray-600 text-sm">
            Let's get you set up! Your thoughts are waiting for their new home.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" class="text-gray-700 font-medium">What should we call you?</x-input-label>
            <x-text-input id="name" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" type="text" name="name" :value="old('name')" placeholder="Your name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" class="text-gray-700 font-medium">Your email address</x-input-label>
            <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" type="email" name="email" :value="old('email')" placeholder="you@example.com" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" class="text-gray-700 font-medium">Create a password</x-input-label>
            <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            type="password"
                            name="password"
                            placeholder="Make it secure, but memorable"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" class="text-gray-700 font-medium">Confirm your password</x-input-label>
            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            type="password"
                            name="password_confirmation" 
                            placeholder="Type it again to be sure"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit and Links -->
        <div class="space-y-4 pt-2">
            <x-primary-button class="w-full justify-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 rounded-lg py-3 text-white font-medium">
                Create my account
            </x-primary-button>

            <div class="text-center">
                <div class="text-sm text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 underline font-medium">
                        Sign in instead
                    </a>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
