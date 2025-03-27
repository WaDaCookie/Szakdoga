<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Register New User') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 p-6 bg-gray-600 shadow-lg rounded-lg">
        <h2 class="text-white text-2xl font-semibold text-center">{{ __('Register New User') }}</h2>

        @if (session('success'))
            <div class="bg-green-200 border-l-4 border-green-500 text-green-700 p-4 mt-4 rounded-md" role="alert">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('store-user') }}" class="mt-6 space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="w-full">
                    <x-input-label for="first_name" :value="__('First Name')" />
                    <x-text-input id="first_name" type="text" name="first_name" :value="old('first_name')" required class="w-full" />
                    <x-input-error :messages="$errors->get('first_name')" />
                </div>
                <div class="w-full">
                    <x-input-label for="last_name" :value="__('Last Name')" />
                    <x-text-input id="last_name" type="text" name="last_name" :value="old('last_name')" required class="w-full" />
                    <x-input-error :messages="$errors->get('last_name')" />
                </div>
            </div>

            <div class="w-full">
                <x-input-label for="dob" :value="__('Date of Birth')" />
                <x-text-input id="dob" type="date" name="dob" :value="old('dob')" required class="w-full text-white" />
                <x-input-error :messages="$errors->get('dob')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="w-full">
                    <x-input-label for="mobile" :value="__('Mobile')" />
                    <x-text-input id="mobile" type="text" name="mobile" :value="old('mobile')" class="w-full" />
                    <x-input-error :messages="$errors->get('mobile')" />
                </div>
                <div class="w-full">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required class="w-full" />
                    <x-input-error :messages="$errors->get('email')" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="w-full">
                    <x-input-label for="role" :value="__('Role')" />
                    <select id="role" name="role" class="block w-full p-2 rounded-md bg-gray-800 border-orange-500 text-white">
                        <option value="user">{{ __('User') }}</option>
                        <option value="admin">{{ __('Admin') }}</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" />
                </div>
                <div class="w-full">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" type="password" name="password" required class="w-full" />
                    <x-input-error :messages="$errors->get('password')" />
                </div>
            </div>

            <div class="w-full">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" type="password" name="password_confirmation" required class="w-full" />
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            <div class="mt-6">
                <x-primary-button class="w-32">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
