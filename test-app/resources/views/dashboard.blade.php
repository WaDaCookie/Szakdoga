<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @auth()
                <div class="flex flex-col bg-gray-600 overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- Header Row -->
                    <div class="flex flex-row justify-between bg-gray-600 shadow-sm">
                        <div class="flex items-center justify-center py-6 pl-10 text-white">
                            {{ __("Room Number") }}
                        </div>
                        <div class="flex items-center justify-center py-6 pr-12 text-white">
                            {{ __("Number of items") }}
                        </div>
                        <div class="flex items-center justify-center py-6 pr-10 text-white">
                            {{ __("Created at") }}
                        </div>
                        <div class="flex items-center justify-center p-6 text-white">
                            {{ __("Actions") }}
                        </div>
                    </div>

                    <!-- Data Rows -->
                    <div class="flex flex-row justify-between bg-gray-700 border-b border-gray-500">
                        <div class="flex items-center justify-center pl-20 py-6 text-white">1</div>
                        <div class="flex items-center justify-center pl-28 py-6 text-white">0</div>
                        <div class="flex items-center justify-center pl-32 py-6 text-white">2024-11-30</div>
                        <div class="flex items-center justify-center py-6 pr-6">
                            <button class="bg-orange-500 text-white px-4 py-2 rounded">View Room</button>
                        </div>
                    </div>

                    <div class="flex flex-row justify-between bg-gray-700 border-b border-gray-500">
                        <div class="flex items-center justify-center pl-20 py-6 text-white">2</div>
                        <div class="flex items-center justify-center pl-28 py-6 text-white">0</div>
                        <div class="flex items-center justify-center pl-32 py-6 text-white">2024-11-30</div>
                        <div class="flex items-center justify-center py-6 pr-6">
                            <button class="bg-orange-500 text-white px-4 py-2 rounded">View Room</button>
                        </div>
                    </div>

                    <div class="flex flex-row justify-between bg-gray-700 border-b border-gray-500">
                        <div class="flex items-center justify-center pl-20 py-6 text-white">3</div>
                        <div class="flex items-center justify-center pl-28 py-6 text-white">0</div>
                        <div class="flex items-center justify-center pl-32 py-6 text-white">2024-11-30</div>
                        <div class="flex items-center justify-center py-6 pr-6">
                            <button class="bg-orange-500 text-white px-4 py-2 rounded">View Room</button>
                        </div>
                    </div>

                    <div class="flex flex-row justify-between bg-gray-700 border-b border-gray-500">
                        <div class="flex items-center justify-center pl-20 py-6 text-white">4</div>
                        <div class="flex items-center justify-center pl-28 py-6 text-white">0</div>
                        <div class="flex items-center justify-center pl-32 py-6 text-white">2024-11-30</div>
                        <div class="flex items-center justify-center py-6 pr-6">
                            <button class="bg-orange-500 text-white px-4 py-2 rounded">View Room</button>
                        </div>
                    </div>

                    <div class="flex flex-row justify-between bg-gray-700 border-b border-gray-500">
                        <div class="flex items-center justify-center pl-20 py-6 text-white">5</div>
                        <div class="flex items-center justify-center pl-28 py-6 text-white">0</div>
                        <div class="flex items-center justify-center pl-32 py-6 text-white">2024-11-30</div>
                        <div class="flex items-center justify-center py-6 pr-6">
                            <button class="bg-orange-500 text-white px-4 py-2 rounded">View Room</button>
                        </div>
                    </div>

                    <!-- Pagination buttons -->
                    <div class="flex flex-row justify-end items-center bg-gray-600 shadow-sm space-x-4 p-4">
                        <!-- Previous Button -->
                        <button class="bg-orange-500 text-white px-4 py-2 rounded">
                            {{ __("Previous") }}
                        </button>

                        <!-- Page Info -->
                        <div class="flex items-center justify-center text-white">
                            <span class="px-2">{{ __("1") }}</span>
                            <span class="px-2">{{ __("of") }}</span>
                            <span class="px-2">{{ __("4") }}</span>
                        </div>

                        <!-- Next Button -->
                        <button class="bg-orange-500 text-white px-4 py-2 rounded">
                            {{ __("Next") }}
                        </button>
                    </div>
                </div>
            @endauth
            @guest()
                <div class="bg-gray-600 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-white">
                        {{ __("Welcome to the dashboard, how did you get here?") }}
                    </div>
                </div>
            @endguest
        </div>
    </div>
</x-app-layout>
