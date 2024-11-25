@extends('admin-page')

@section('admin-content')
<div class="w-full border-2 border-gray-200 border-dashed rounded-lg mt-14">
    <div class="flex flex-wrap w-full">
        <div class="w-full flex md:flex-row flex-col gap-4 mb-4">
            <!-- Table Header -->
            <div class="w-full h-fit  p-6 bg-white border border-gray-200 rounded-lg shadow order-last md:order-first">
                <div class="flex flex-row justify-between items-center mb-4">
                    <div class="flex flex-col gap-4">
                        <h5 class="text-2xl font-semibold tracking-tight text-gray-900">Reservations
                        </h5>
                        <p class="mb-3 font-normal text-gray-700">Click on reservation row to edit status</p>
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
                                placeholder="Search Username" required />
                    </form>
                </div>
            </div>
            <!-- Table -->
            <div class="overflow-x-auto w-full">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <!-- Filter -->
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3"></th>
                            <th scope="col" class="px-6 py-3"></th>
                            <!-- Room ID Filter -->
                            <th scope="col" class="px-6 py-3">
                                <select id="room-id-filter" class="select-form">
                                    <option value="">All Rooms</option>
                                    @foreach($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th scope="col" class="px-6 py-3"></th>
                            <th scope="col" class="px-6 py-3"></th>
                            <th scope="col" class="px-6 py-3"></th>
                            <!-- Status Filter -->
                            <th scope="col" class="px-6 py-3">
                                <select id="status-filter" class="select-form">
                                    <option value="all">All Statuses</option>
                                    <option value="approved">Approved</option>
                                    <option value="pending">Pending</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </th>
                            <!-- Date Filter -->
                            <th scope="col" class="px-6 py-3">
                                <input type="date" id="date-picker"
                                    class="block w-full px-4 py-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" />
                                <!-- <select id="date-filter" class="select-form">
                                    <option value="all">All</option>
                                    <option value="today">Today</option>
                                    <option value="yesterday">Yesterday</option>
                                    <option value="week">A Week Ago</option>
                                    <option value="week">A Week Ago</option>
                                </select> -->
                            </th>
                        </tr>
                        <!-- Column Headers -->
                        <tr class="text-center">
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Booker Name</th>
                            <th scope="col" class="px-6 py-3">Room Name</th>
                            <th scope="col" class="px-3 py-3">Start Time</th>
                            <th scope="col" class="px-3 py-3">End Time</th>
                            <th scope="col" class="px-6 py-3">Purpose</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody id="reservationTable">
                        @foreach($reservations as $reservation)
                        <tr class="bg-white border-b hover:bg-gray-50 reservation-row text-center align-center"
                            data-room-id="{{ $reservation->room_id }}" data-status="{{ $reservation->status }}"
                            data-username="{{ $users->firstWhere('id', $reservation->user_id)->username ?? '' }}"
                            data-date="{{ $reservation->created_at }}">
                            <!-- Reservation ID -->
                            <td class="px-3 py-4 font-medium">
                                #{{$reservation->id}}
                            </td>
                            <!-- Booker Name -->
                            <td class="px-3 py-4 font-medium">
                                {{ $users->firstWhere('id', $reservation->user_id)->username ?? 'Unknown' }}
                            </td>
                            <!-- Room Name -->
                            <td class="px-3 py-4 font-medium">
                                {{ $rooms->firstWhere('id', $reservation->room_id)->room_name ?? 'Unknown' }}
                            </td>
                            <!-- Start Time -->
                            <td class="px-3 py-4 font-medium">
                                {{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}
                            </td>
                            <!-- End Time -->
                            <td class="px-3 py-4 font-medium">
                                {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}
                            </td>
                            <!-- Purpose -->
                            <td class="px-3 py-4 font-medium">{{ $reservation->purpose }}</td>
                            <!-- Status -->
                            <td class="px-3 py-4 font-medium">
                                <form id="updateStatusForm{{ $reservation->id }}"
                                    action="{{ route('admin.reservation.update', $reservation->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 px-3 mt-1 
                                        @if($reservation->status == 'rejected') text-red-500 
                                        @elseif($reservation->status == 'pending') text-yellow-500 
                                        @elseif($reservation->status == 'approved') text-green-500 
                                        @endif">
                                        <option value="pending"
                                            {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved"
                                            {{ $reservation->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected"
                                            {{ $reservation->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </form>
                            </td>
                            <!-- Book Date -->
                            <td class="px-3 py-4 font-medium">
                                {{ \Carbon\Carbon::parse($reservation->created_at)->format('d M Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    const roomFilter = document.getElementById('room-id-filter');
    const statusFilter = document.getElementById('status-filter');
    const datePicker = document.getElementById('date-picker');
    const tableRows = document.querySelectorAll('.reservation-row');

    const getSearchValue = () => searchInput.value.toLowerCase();
    const getRoomValue = () => roomFilter.value;
    const getStatusValue = () => statusFilter.value;
    const getDateValue = () => datePicker.value;

    const setDatePickerLimits = (dates) => {
        const formatDate = (date) => date.toLocaleDateString('en-CA');

        const minDate = new Date(Math.min(...dates));
        const maxDate = new Date(Math.max(...dates));

        datePicker.min = formatDate(minDate);
        datePicker.max = formatDate(maxDate);
    };

    const filterRow = (row, searchValue, roomValue, statusValue, dateValue) => {
        const username = row.getAttribute('data-username').toLowerCase();
        const roomId = row.getAttribute('data-room-id');
        const status = row.getAttribute('data-status');
        const date = new Date(row.getAttribute('data-date')).toLocaleDateString('en-CA');

        const matchesSearch = username.includes(searchValue);
        const matchesRoom = !roomValue || roomId === roomValue;
        const matchesStatus = statusValue === 'all' || status === statusValue;
        const matchesDate = !dateValue || date === dateValue;

        return matchesSearch && matchesRoom && matchesStatus && matchesDate;
    };

    const filterTable = () => {
        const searchValue = getSearchValue();
        const roomValue = getRoomValue();
        const statusValue = getStatusValue();
        const dateValue = getDateValue();

        tableRows.forEach(row => {
            const shouldShowRow = filterRow(row, searchValue, roomValue, statusValue, dateValue);
            row.style.display = shouldShowRow ? '' : 'none';
        });
    };
    const dates = Array.from(tableRows).map(row => new Date(row.getAttribute('data-date')));
    if (dates.length > 0) {
        setDatePickerLimits(dates);
    }

    searchInput.addEventListener('input', filterTable);
    roomFilter.addEventListener('change', filterTable);
    statusFilter.addEventListener('change', filterTable);
    datePicker.addEventListener('change', filterTable);
});
</script>

@endsection