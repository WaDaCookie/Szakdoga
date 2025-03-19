<x-app-layout>
    <div class="max-w-5xl mx-auto py-10">
        <h2 class="text-2xl font-semibold text-white mb-6 ml-12 text-start">📦 Appliances in Storage</h2>

        <!-- Filters -->
        <form method="GET" action="{{ route('storage') }}" class="mb-6 ml-12 flex gap-4">
            <input
                type="text"
                name="type_number"
                value="{{ request('type_number') }}"
                placeholder="Filter by Type Number..."
                class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 text-black"
            >

            <select name="brand" class="px-6 py-2 rounded-lg border border-gray-300 text-black">
                <option value="">All Brands</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                        {{ $brand }}
                    </option>
                @endforeach
            </select>

            <select name="type" class="px-6 py-2 rounded-lg border border-gray-300 text-black">
                <option value="">All Types</option>
                @foreach ($types as $type)
                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg">Apply Filters</button>
        </form>

        <div class="flex justify-center">
            <table class="w-3/4 border-collapse rounded-lg overflow-hidden mx-auto shadow-lg">
                <thead>
                <tr class="bg-orange-500 text-black uppercase text-sm tracking-wider text-center">
                    <th class="p-4">Type Number</th>
                    <th class="p-4">Appliance Name</th>
                    <th class="p-4">Brand</th>
                    <th class="p-4">Type</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Appliance Added At</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($equipmentWithoutRoom as $equipmentType)
                    <tr class="{{ $loop->odd ? 'bg-gray-500' : 'bg-gray-700' }} text-white text-center">
                        <td class="p-4 font-medium">{{ $equipmentType->type_number }}</td>
                        <td class="p-4">{{ optional($equipmentType->equipment)->name ?? 'N/A' }}</td>
                        <td class="p-4">{{ optional($equipmentType->equipment)->brand ?? 'N/A' }}</td>
                        <td class="p-4">{{ optional($equipmentType->equipment)->type ?? 'N/A' }}</td>
                        <td class="p-4">{{ optional($equipmentType->equipment)->status ?? 'Active' }}</td>
                        <td class="p-4">{{ optional($equipmentType->equipment->created_at)->format('Y-m-d') ?? 'N/A' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
