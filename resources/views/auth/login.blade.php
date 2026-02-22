<x-guest-layout>

    <div class="min-h-screen flex items-center justify-center
                bg-gradient-to-br from-red-900 via-red-800 to-rose-900 px-4">

        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">

            <!-- Title -->
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-red-900">
                    Welcome Back
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Please login to your account
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input
                        id="email"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                        class="block w-full rounded-lg
                               border-gray-300
                               focus:border-red-800
                               focus:ring-red-800"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="block w-full rounded-lg
                               border-gray-300
                               focus:border-red-800
                               focus:ring-red-800"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="rounded text-red-800 focus:ring-red-800"
                        >
                        <span class="ms-2 text-sm text-gray-600">
                            {{ __('Remember me') }}
                        </span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-red-800 hover:underline">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <div class="mt-6">
                   <a href="{{ route('google.redirect') }}"
   class="flex items-center justify-center w-full px-4 py-2 border rounded-md">
   Login dengan Google
</a>


                <!-- Button -->
                <x-primary-button
                    class="w-full justify-center
                           bg-red-900 hover:bg-red-800
                           focus:bg-red-800 active:bg-red-950">
                    {{ __('Log in') }}
                </x-primary-button>
            </form>

        </div>
    </div>

</x-guest-layout>
