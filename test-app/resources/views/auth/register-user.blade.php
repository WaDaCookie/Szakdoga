<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register New User') }}
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('admin.register.store') }}" class="max-w-4xl mx-auto mt-8 p-4 bg-white shadow rounded-lg">
        @csrf

        <!-- First Name -->
        <div>
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" type="text" name="first_name" :value="old('first_name')" required />
            <x-input-error :messages="$errors->get('first_name')" />
        </div>

        <!-- Last Name -->
        <div class="mt-4">
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" type="text" name="last_name" :value="old('last_name')" required />
            <x-input-error :messages="$errors->get('last_name')" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <select id="role" name="role" class="block w-full">
                <option value="user">{{ __('User') }}</option>
                <option value="admin">{{ __('Admin') }}</option>
            </select>
            <x-input-error :messages="$errors->get('role')" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="mt-6">
            <x-primary-button>
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-app-layout>
