<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 px-4">
        <h2 class="text-2xl font-semibold text-white mb-6 text-start">📦 Appliances in Storage</h2>

        <!-- Filters Form -->
        <form method="GET" action="{{ route('storage') }}" class="mb-6 flex flex-wrap gap-4">
            <input
                type="text"
                name="type_number"
                value="{{ request('type_number') }}"
                placeholder="Filter by Inventory Number..."
                class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 text-black w-full md:w-auto"
            >

            <select name="brand" class="px-6 py-2 rounded-lg border border-gray-300 text-black w-full md:w-auto">
                <option value="">All Brands</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                        {{ $brand }}
                    </option>
                @endforeach
            </select>

            <select name="type" class="px-6 py-2 rounded-lg border border-gray-300 text-black w-full md:w-auto">
                <option value="">All Types</option>
                @foreach ($types as $type)
                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg w-full md:w-auto">
                Apply Filters
            </button>
        </form>

        <!-- Table Container with Scroll for Mobile -->
        <div class="overflow-x-auto">
            <!-- Desktop Table -->
            <table class="w-full border-collapse rounded-lg overflow-hidden shadow-lg hidden md:table">
                <thead>
                <tr class="bg-orange-500 text-black uppercase text-sm tracking-wider text-center">
                    <th class="p-4">Inventory Number</th>
                    <th class="p-4">Appliance Name</th>
                    <th class="p-4">Brand</th>
                    <th class="p-4">Type</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Appliance Added At</th>
                    @if (auth()->user() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin')))
                        <th class="p-4">Actions</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($equipmentWithoutRoom as $equipmentType)
                    <tr class="{{ $loop->odd ? 'bg-gray-500' : 'bg-gray-700' }} text-white text-center">
                        <td class="p-4 font-medium">{{ $equipmentType->type_number }}</td>
                        <td class="p-4">{{ optional($equipmentType->equipment)->name ?? 'N/A' }}</td>
                        <td class="p-4">{{ optional($equipmentType->equipment)->brand ?? 'N/A' }}</td>
                        <td class="p-4">{{ optional($equipmentType->equipment)->type ?? 'N/A' }}</td>
                        <td class="p-4">{{ optional($equipmentType)->status ?? 'Active' }}</td>
                        <td class="p-4">{{ optional($equipmentType->equipment->created_at)->format('Y-m-d') ?? 'N/A' }}</td>
                        @if (auth()->user() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin')))
                            <td class="p-4">
                                @if (optional($equipmentType)->status === 'marked_for_disposal')
                                    <form method="POST"
                                          action="{{ route('equipment.destroy', $equipmentType->equipment) }}"
                                          onsubmit="return confirm('Are you sure you want to delete this appliance?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Mobile Cards -->
            <div class="md:hidden space-y-4">
                @foreach ($equipmentWithoutRoom as $equipmentType)
                    <div class="bg-gray-700 text-white p-4 rounded-lg shadow-lg">
                        <p><strong>Type Number:</strong> {{ $equipmentType->type_number }}</p>
                        <p><strong>Appliance Name:</strong> {{ optional($equipmentType->equipment)->name ?? 'N/A' }}</p>
                        <p><strong>Brand:</strong> {{ optional($equipmentType->equipment)->brand ?? 'N/A' }}</p>
                        <p><strong>Type:</strong> {{ optional($equipmentType->equipment)->type ?? 'N/A' }}</p>
                        <p><strong>Status:</strong> {{ optional($equipmentType)->status ?? 'Active' }}</p>
                        <p><strong>Added At:</strong> {{ optional($equipmentType->equipment->created_at)->format('Y-m-d') ?? 'N/A' }}</p>

                        @if (auth()->user() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin')))
                            @if (optional($equipmentType)->status === 'marked_for_disposal')
                                <form method="POST"
                                      action="{{ route('equipment.destroy', $equipmentType->equipment) }}"
                                      onsubmit="return confirm('Are you sure you want to delete this appliance?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full mt-2">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
