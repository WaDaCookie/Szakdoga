<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Room Details: {{ $room->room_number }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10">
        <div class="bg-gray-800 shadow-lg sm:rounded-lg p-6 text-white">
            <h3 class="text-2xl font-semibold mb-4">Room Information</h3>
            <p><strong>Room Number:</strong> {{ $room->room_number }}</p>
            <p><strong>Last updated by:</strong> {{ $room->user ? $room->user->first_name . ' ' . $room->user->last_name : '' }}</p>
            <p><strong>Updated at:</strong> {{ $room->updated_at ? $room->updated_at->format('Y-m-d H:i:s') : '' }}</p>
            <p><strong>Number of active Appliances in the Room:</strong> {{ $room->equipmentTypes->count() }}</p>
        </div>

        <div class="mt-6 bg-gray-600 shadow-lg sm:rounded-lg p-6 text-white">
            <h3 class="text-2xl font-semibold mb-4">Appliances in the room</h3>

            <form action="{{ route('update-room-equipments', $room->id) }}" method="POST">
                @csrf
                @method('PUT')

                @foreach ($equipmentByType as $type => $equipments)
                    <div class="mb-4">
                        <label class="block text-lg font-medium">{{ ucfirst($type) }}:</label>
                        <select name="equipment_types[]" class="w-full px-4 py-2 rounded text-black">
                            <option value="">Select a {{ ucfirst($type) }} type</option>
                            @foreach ($equipments as $equipment)
                                @foreach ($equipment->equipmentType as $equipmentType)
                                    @if (is_null($equipmentType->room_id) || $equipmentType->room_id === $room->id)
                                        <option value="{{ $equipmentType->id }}"
                                                @if(in_array($equipmentType->id, $selectedEquipments)) selected @endif>
                                            {{ $equipmentType->type_number }} - {{ $equipment->brand }} - {{ $equipment->name }}
                                        </option>
                                    @endif
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                @endforeach

                <button type="submit"
                        class="bg-orange-500 text-black border border-orange-500 hover:bg-transparent hover:text-orange-500 hover:border-orange-500 px-4 py-2 rounded">
                    Save changes
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
