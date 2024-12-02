<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div >
            <x-input-label
                class="text-white"
                for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-800 text-white border-orange-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label class="text-white" for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full bg-gray-800 text-white border-orange-500"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-orange-500 text-orange-500 shadow-sm focus:ring-orange-400" name="remember">
                <span class="ms-2 text-sm text-white">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
{{--            @if (Route::has('password.request'))--}}
{{--                <a class="underline text-sm text-white hover:text-orange-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-400" href="{{ route('password.request') }}">--}}
{{--                    {{ __('Forgot your password?') }}--}}
{{--                </a>--}}
{{--            @endif--}}

            <x-primary-button class="ms-3 hover:bg-gray-800 bg-orange-500 hover:border-orange-500 hover:text-white">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
