<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-gray-600 shadow-md rounded-lg">
        <h2 class="text-xl font-semibold mb-4 text-white">Add a Type Number for Equipment</h2>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Add a Type Number for Existing Equipment --}}
        <form action="{{ route('equipmentType.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                {{--TODO: change this so i can type into the field--}}
                <label class="block font-semibold text-white">Select Equipment:</label>
                <select name="equipment_id" class="w-full p-2 border rounded" required>
                    <option value="">Select Equipment</option>
                    @foreach ($equipments as $equipment)
                        <option value="{{ $equipment->id }}">
                            {{ $equipment->brand }} - {{ $equipment->name }} ({{ $equipment->type }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-semibold text-white">Type Number:</label>
                <input type="text" name="type_number" class="w-full p-2 border rounded" required>
            </div>

            <button type="submit" class="bg-transparent hover:bg-orange-500 hover:text-black text-orange-500 border border-orange-500 px-4 py-2 rounded">Save Type Number</button>
        </form>

        {{-- Add New Equipment --}}
        <h2 class="text-xl font-semibold mt-6 mb-4 text-white">Add New Equipment</h2>
        <form action="{{ route('equipment.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-semibold text-white">Name:</label>
                <input type="text" name="name" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold text-white">Brand:</label>
                <input type="text" name="brand" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold text-white">Type:</label>
                <input type="text" name="type" class="w-full p-2 border rounded" required>
            </div>

            <button type="submit" class="bg-orange-500 text-black hover:text-orange-500 border border-orange-500 hover:bg-transparent px-4 py-2 rounded">Add New Equipment</button>
        </form>
    </div>
</x-app-layout>
