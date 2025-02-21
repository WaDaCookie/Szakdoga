<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @auth()
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h2 class="text-white text-xl font-semibold mb-4">Rooms Overview</h2>

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
                            @foreach ($rooms as $room)
                                <div class="flex flex-row justify-between bg-gray-700 border-b border-gray-500">
                                    <div class="flex items-center justify-center pl-20 py-6 text-white">
                                        {{ $room->room_number }}
                                    </div>
                                    <div class="flex items-center justify-center pl-28 py-6 text-white">
                                        {{ $room->equipmentTypes->count() }}
                                    </div>
                                    <div class="flex items-center justify-center pl-32 py-6 text-white">
                                        {{ $room->created_at->format('Y-m-d') }}
                                    </div>
                                    <button class="flex items-center justify-center py-6 pr-6">
                                        <a href="#" class="bg-orange-500 text-white px-4 py-2 rounded">View Room</a>
                                    </button>
                                </div>
                            @endforeach

                            <!-- Pagination buttons -->
                            <div class="flex flex-row justify-end items-center bg-gray-600 shadow-sm space-x-4 p-4">
                                {{ $rooms->links() }} <!-- Laravel Pagination -->
                            </div>
                        </div>
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
