<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-gray-600 shadow-md rounded-lg">
        <h2 class="text-xl font-semibold mb-4 text-white">Update Appliance</h2>

        {{-- Success & Error Messages --}}
        @if (session('success'))
            <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="p-4 mb-4 text-red-700 bg-red-100 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Equipment Type Search --}}
        <div class="mb-4 relative" x-data="equipmentTypeSearch()">
            <label class="block font-semibold text-white">Select Appliance:</label>
            <div class="relative">
                <input type="text"
                       x-model="search"
                       @input="searchEquipmentTypes"
                       placeholder="Search inventory number..."
                       class="w-full p-2 border rounded"
                       @focus="showDropdown = true"
                >

                {{-- SVG Dropdown Button --}}
                <button type="button" @click="toggleDropdown" class="absolute right-2 top-1/2 transform -translate-y-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                    </svg>
                </button>
            </div>

            {{-- Dropdown List --}}
            <div x-show="showDropdown" class="bg-white border rounded mt-2 max-h-40 overflow-y-auto absolute w-full z-10">
                <template x-for="type in filteredTypes" :key="type.id">
                    <div @click="selectType(type)" class="p-2 hover:bg-gray-200 cursor-pointer">
                        <span x-text="type.type_number"></span>
                    </div>
                </template>
                <div x-show="filteredTypes.length === 0" class="p-2 text-gray-500">No results found</div>
            </div>

            {{-- Update Appliance Form --}}
            <form id="updateForm" :action="formAction" method="POST" @submit.prevent="validateForm">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-semibold text-white">Appliance Name:</label>
                    <input type="text" name="name" id="name" class="w-full p-2 border rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold text-white">Brand:</label>
                    <input type="text" name="brand" id="brand" class="w-full p-2 border rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold text-white">Type:</label>
                    <input type="text" name="type" id="type" class="w-full p-2 border rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold text-white">Status:</label>
                    <select name="status" id="status" class="w-full p-2 border rounded" required>
                        <option value="active">Active</option>
                        <option value="needs_repair">Needs Repair</option>
                        <option value="marked_for_disposal">Marked for Disposal</option>
                    </select>
                </div>

                <button type="submit" class="bg-orange-500 text-black border border-orange-500 hover:bg-transparent hover:text-orange-500 hover:border-orange-500 px-4 py-2 rounded">
                    Save Changes
                </button>
            </form>
        </div>
    </div>

    <script>
        function equipmentTypeSearch() {
            return {
                search: '',
                types: @json($equipmentTypes),
                filteredTypes: @json($equipmentTypes),
                selectedType: null,
                showDropdown: false,
                debounceTimer: null,
                formAction: '#',

                searchEquipmentTypes() {
                    clearTimeout(this.debounceTimer);
                    this.debounceTimer = setTimeout(() => {
                        fetch(`/equipment-type/search?query=${this.search}`)
                            .then(response => response.json())
                            .then(data => {
                                this.filteredTypes = data;
                                this.showDropdown = true;
                            });
                    }, 300);
                },

                toggleDropdown() {
                    this.showDropdown = !this.showDropdown;
                },

                selectType(type) {
                    fetch(`/appliance/by-type/${type.type_number}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data) {
                                document.getElementById('name').value = data.name;
                                document.getElementById('brand').value = data.brand;
                                document.getElementById('type').value = data.type;
                                document.getElementById('status').value = data.status;
                                document.getElementById('updateForm').action = `/appliance/${data.id}`;
                            } else {
                                document.getElementById('name').value = '';
                                document.getElementById('brand').value = '';
                                document.getElementById('type').value = '';
                                document.getElementById('status').value = '';
                                document.getElementById('updateForm').action = '#';
                            }
                        });

                    this.search = type.type_number;
                    this.showDropdown = false;
                },

                validateForm() {
                    let name = document.getElementById('name').value.trim();
                    let brand = document.getElementById('brand').value.trim();
                    let type = document.getElementById('type').value.trim();
                    let status = document.getElementById('status').value.trim();

                    if (!name || !brand || !type || !status) {
                        alert("All fields must be filled out.");
                        return false;
                    }
                    document.getElementById('updateForm').submit();
                }
            };
        }
    </script>
</x-app-layout>
