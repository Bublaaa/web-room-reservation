@extends('admin-page')

@section('admin-content')
<div class="w-full mt-14">
    <div class="flex flex-wrap w-full">
        <div class="w-full flex md:flex-row flex-col gap-4 mb-4">
            <!-- Table Header -->
            <div class="w-full h-fit  p-6 bg-white border border-gray-200 rounded-lg shadow order-last md:order-first">
                <div class="flex flex-row justify-between items-center mb-4">
                    <div class="flex flex-row items-center gap-4">
                        <!-- Add Room Button -->
                        <button type="button" class="primary-button rounded-lg px-3 py-3 inline-flex items-center"
                            id="openAddRoomModal">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M6 3a3 3 0 0 0-3 3v2.25a3 3 0 0 0 3 3h2.25a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3H6ZM15.75 3a3 3 0 0 0-3 3v2.25a3 3 0 0 0 3 3H18a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3h-2.25ZM6 12.75a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h2.25a3 3 0 0 0 3-3v-2.25a3 3 0 0 0-3-3H6ZM17.625 13.5a.75.75 0 0 0-1.5 0v2.625H13.5a.75.75 0 0 0 0 1.5h2.625v2.625a.75.75 0 0 0 1.5 0v-2.625h2.625a.75.75 0 0 0 0-1.5h-2.625V13.5Z" />
                            </svg>
                        </button>
                        <h5 class="text-2xl font-semibold tracking-tight text-gray-900">All Rooms
                        </h5>
                    </div>
                    <form>
                        <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" id="search"
                                class="block w-full px-4 py-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search Room Name " required />
                    </form>
                </div>
            </div>
            <!-- Room Gallery -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($rooms as $room)
                <div class="room-card" data-id="{{ $room->id }}" data-name="{{ $room->room_name }}"
                    data-location="{{ $room->location }}" data-capacity="{{ $room->capacity }}"
                    data-description="{{ $room->description }}">
                    <div class="p-5">
                        <p class="mb-3 font-bold text-gray-700">{{ ucwords($room->location) }}</p>
                        <h5 class="mb-2 text-2xl font-bold tracking-tight max-w-md text-gray-900 break-words">
                            {{ $room->room_name }}</h5>
                        <p class="mb-3 font-semibold text-gray-700">Capacity - {{ $room->capacity }}</p>
                        <p class="mb-3 font-normal text-gray-700">{{ $room->description }}</p>
                    </div>
                    <button type="button" onclick="openDeleteModal({{ $room->id }}, '{{ $room->room_name }}')"
                        class="danger-button rounded-lg px-3 py-3 inline-flex items-center m-5">
                        <svg class="w-5 h-5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                clip-rule="evenodd" />
                        </svg>
                        Delete Room
                    </button>
                </div>
                @endforeach
            </div>
        </div>
        <!-- Room Setting Card-->
        <div class="w-full md:max-w-sm min-w-sm p-6 h-fit bg-white border border-gray-200 rounded-lg shadow">
            <svg class="w-8 h-8 text-gray-500 mb-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M3 2.25a.75.75 0 0 0 0 1.5v16.5h-.75a.75.75 0 0 0 0 1.5H15v-18a.75.75 0 0 0 0-1.5H3ZM6.75 19.5v-2.25a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-.75.75h-3a.75.75 0 0 1-.75-.75ZM6 6.75A.75.75 0 0 1 6.75 6h.75a.75.75 0 0 1 0 1.5h-.75A.75.75 0 0 1 6 6.75ZM6.75 9a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75ZM6 12.75a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 0 1.5h-.75a.75.75 0 0 1-.75-.75ZM10.5 6a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75Zm-.75 3.75A.75.75 0 0 1 10.5 9h.75a.75.75 0 0 1 0 1.5h-.75a.75.75 0 0 1-.75-.75ZM10.5 12a.75.75 0 0 0 0 1.5h.75a.75.75 0 0 0 0-1.5h-.75ZM16.5 6.75v15h5.25a.75.75 0 0 0 0-1.5H21v-12a.75.75 0 0 0 0-1.5h-4.5Zm1.5 4.5a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Zm.75 2.25a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75v-.008a.75.75 0 0 0-.75-.75h-.008ZM18 17.25a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z"
                    clip-rule="evenodd" />
            </svg>
            <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900">Room Setting
            </h5>
            <p class="mb-3 font-normal text-gray-500">Choose one room you wish to edit</p>
            <form id="editRoomForm" method="POST" action="{{ route('admin.rooms.update') }}">
                @csrf
                @method('PUT')
                <input type="hidden" class="hidden" name="roomId" id="roomId">

                <!-- Room Name Field -->
                <div class="mb-4">
                    <label for="editName" class="form-label">Name</label>
                    <input type="text" id="editName" name="room_name" class="text-form" required>
                </div>

                <!-- Room Location Field -->
                <div class="mb-4">
                    <label for="editLocation" class="form-label">Location</label>
                    <select id="editLocation" name="location" class="text-form" required>
                        <option value="" disabled selected>Select a location</option>
                        <option value="gedung 1">Gedung 1</option>
                        <option value="gedung 2">Gedung 2</option>
                        <option value="gedung 3">Gedung 3</option>
                    </select>
                </div>

                <!-- Room Capacity Field -->
                <div class="mb-4">
                    <label for="editCapacity" class="form-label">Capacity</label>
                    <input type="number" id="editCapacity" name="capacity" class="text-form" min="10" max="100"
                        required>
                </div>

                <!-- Room Description Field -->
                <div class="mb-4">
                    <label for="editDescription" class="form-label">Description</label>
                    <textarea id="editDescription" name="description" class="text-form" rows="4" required></textarea>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button type="submit" class="large-button primary-button">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Room Modal -->
<div id="addRoomModal" class="fixed hidden inset-0 z-50 p-4 bg-gray-800 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg w-full max-w-xs md:max-w-md">
        <h3 class="text-xl font-semibold text-center mb-4">Register New Room</h3>
        <!-- Modal Content -->
        <form id="addRoomForm" method="POST" action="{{ route('admin.rooms.add') }}">
            @csrf
            <!-- Room Name Field -->
            <div class="mb-4">
                <label for="addName" class="form-label">Room Name</label>
                <input type="text" id="addName" name="room_name" class="text-form" required>
            </div>

            <!-- Room Location Field -->
            <div class="mb-4">
                <label for="addLocation" class="form-label">Location</label>
                <select id="addLocation" name="location" class="text-form" required>
                    <option value="" disabled selected>Select a location</option>
                    <option value="gedung 1">Gedung 1</option>
                    <option value="gedung 2">Gedung 2</option>
                    <option value="gedung 3">Gedung 3</option>
                </select>
            </div>

            <!-- Room Capacity Field -->
            <div class="mb-4">
                <label for="addCapacity" class="form-label">Capacity</label>
                <input type="number" id="addCapacity" name="capacity" class="text-form" min="10" max="100" required>
            </div>

            <!-- Room Description Field -->
            <div class="mb-4">
                <label for="addDescription" class="form-label">Description</label>
                <textarea id="addDescription" name="description" class="text-form" rows="4" required></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="large-button primary-button">Add</button>
                <button type="button" id="closeAddRoomModal" class="large-button secondary-button">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Room Modal -->
<div id="deleteRoomModal"
    class="fixed hidden inset-0 z-50 p-4 bg-gray-800 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg w-full max-w-xs md:max-w-md">
        <h3 class="text-xl font-semibold text-center mb-4">Delete Room</h3>
        <p class="text-center mb-4" id="deleteConfirmation"></p>
        <form id="deleteForm" method="POST" action="{{ route('admin.rooms.delete') }}">
            @csrf
            @method('DELETE')
            <input type="hidden" name="roomId" id="deleteRoomId">
            <div class="flex w-full items-center justify-center gap-4">
                <button type="submit" class="large-button danger-button">Confirm</button>
                <button type="button" id="closeDeleteModal" class="large-button secondary-button">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
const searchInput = document.getElementById('search');
const roomCards = document.querySelectorAll('.room-card');

searchInput.addEventListener('input', function() {
    const filter = this.value.toLowerCase();

    roomCards.forEach(card => {
        const roomName = card.querySelector('h5').textContent
            .toLowerCase();

        if (roomName.includes(filter)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
});

const addRoomModal = document.getElementById('addRoomModal');
const closeAddRoomButton = document.getElementById('closeAddRoomModal');
const openAddRoomButton = document.getElementById('openAddRoomModal');

openAddRoomButton.addEventListener('click', function(e) {
    e.preventDefault();
    addRoomModal.classList.remove('hidden');
})

closeAddRoomButton.addEventListener('click', function(e) {
    addRoomModal.classList.add('hidden');
})

const closeDeleteModalButton = document.getElementById('closeDeleteModal');
const deleteModal = document.getElementById('deleteRoomModal')

closeDeleteModalButton.addEventListener('click', function() {
    deleteModal.classList.add('hidden');
});

function openDeleteModal(roomId, name) {
    document.getElementById('deleteConfirmation').textContent =
        `Are you sure you want to delete the room with name: ${name} ?`;
    document.getElementById('deleteRoomId').value = roomId;

    deleteModal.classList.remove('hidden');
}


document.querySelectorAll('.room-card').forEach(card => {
    card.addEventListener('click', function() {
        const roomId = this.dataset.id;
        const roomName = this.dataset.name;
        const roomLocation = this.dataset.location;
        const roomCapacity = this.dataset.capacity;
        const roomDescription = this.dataset.description;

        document.getElementById('roomId').value = roomId;
        document.getElementById('editName').value = roomName;
        document.getElementById('editLocation').value = roomLocation;
        document.getElementById('editCapacity').value = roomCapacity;
        document.getElementById('editDescription').value = roomDescription;
    });
});
</script>
@endsection