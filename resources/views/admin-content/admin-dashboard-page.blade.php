@extends('admin-page')

@section('admin-content')
<div class="w-full mt-14">
    <div class="flex flex-wrap w-full">
        <div class="w-full flex flex-col gap-4 mb-4">
            <!-- Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Pending Reservation Request -->
                <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                    <h5 class="mb-4 text-xl font-medium text-gray-500">Pending Reservations</h5>
                    <div class="flex items-baseline text-gray-900 mb-4">
                        <span class="text-5xl font-extrabold tracking-tight">{{ $pendingReservations }}</span>
                        <span class="ms-1 text-xl font-normal text-gray-500">/{{ $totalReservations }}</span>
                    </div>
                    <a href="{{ route('admin.reservation.dashboard') }}" type="button"
                        class="primary-button large-button">
                        View More
                    </a>
                </div>
                <!-- Total Room -->
                <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                    <h5 class="mb-4 text-xl font-medium text-gray-500">Available Room</h5>
                    <div class="flex items-baseline text-gray-900 mb-4">
                        <span class="text-5xl font-extrabold tracking-tight">{{ $rooms->count() }}</span>
                        <span class="ms-1 text-xl font-normal text-gray-500">rooms</span>
                    </div>
                    <a href="{{ route('admin.room.dashboard') }}" type="button" class="primary-button large-button">
                        View More
                    </a>
                </div>
            </div>
            <!-- Table Header -->
            <div class="w-full h-fit p-6 bg-white border border-gray-200 rounded-lg shadow">
                <div class="flex flex-col gap-2">
                    <h5 class="text-2xl font-semibold tracking-tight text-gray-900">Schedule
                    </h5>
                    <p class="mb-3 font-normal text-gray-700">Choose your date to show the schedule on that day
                    </p>
                </div>
                <!-- Table -->
                <div class="overflow-x-auto w-full">
                    <!-- Schedule -->
                    <div class="schedule w-full">
                        @foreach($roomsWithReservations as $createdAt => $reservationsByDate)
                        <!-- Group by Created At -->
                        <div class="flex flex-row mb-4 schedule-date w-full"
                            data-created-at="{{ \Carbon\Carbon::parse($createdAt)->format('Y-m-d') }}">
                            <div class="date-header p-2 border-r">
                                <div class="text-base font-semibold">
                                    {{ \Carbon\Carbon::parse($createdAt)->format(' d F Y') }}
                                </div>
                            </div>

                            <div class="reservations w-full">
                                @foreach ($reservationsByDate as $roomId => $reservations)
                                <!-- Group by Room ID -->
                                <div class="flex flex-row room-group border-b">
                                    <div class="room-info p-2">
                                        <div class="room-name text-xl font-semibold">
                                            {{ $rooms->firstWhere('id', $roomId)->room_name ?? 'Unknown' }}
                                        </div>
                                        <div class="room-location text-gray-500">
                                            {{ ucwords($rooms->firstWhere('id', $roomId)->location ?? 'Unknown') }}
                                        </div>
                                    </div>

                                    <div class="reservations-list w-full mb-2 p-2">
                                        @foreach ($reservations as $reservation)
                                        <!-- Group by Reservation -->
                                        <div class="flex flex-row reservation-item">
                                            <!-- Time Before -->
                                            <div class="flex time-before-reservation bg-transprent"
                                                data-start-time="{{ $reservation->start_time }}">
                                            </div>

                                            <!-- Reservation Time -->
                                            <div class="flex flex-col font-medium text-center border-l reservation-time"
                                                data-start-time="{{ $reservation->start_time }}"
                                                data-end-time="{{ $reservation->end_time }}">
                                                <p class="font-bold">{{ $reservation->purpose }}</p>
                                                <p class="text-xs text-white bg-blue-700">
                                                    {{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // Define the max start time and max end time (07:30 to 16:00)
    const maxStartTime = 7 * 60 + 30; // 07:30 in minutes
    const maxEndTime = 16 * 60; // 16:00 in minutes
    const maxDiff = maxEndTime - maxStartTime; // Total minutes (510)

    // Get all the reservation divs
    const reservationDivs = document.querySelectorAll('.reservation-time');
    const timeBeforeReservationDivs = document.querySelectorAll('.time-before-reservation');

    timeBeforeReservationDivs.forEach(div => {
        const startTime = div.getAttribute('data-start-time');
        const startMinutes = convertToMinutes(startTime);

        const diff = startMinutes - maxStartTime;
        const widthPercentage = (diff / maxDiff) * 100;
        div.style.width = `${widthPercentage}%`;
    });

    reservationDivs.forEach(div => {
        const startTime = div.getAttribute('data-start-time');
        const endTime = div.getAttribute('data-end-time');

        // Convert the times to minutes
        const startMinutes = convertToMinutes(startTime);
        const endMinutes = convertToMinutes(endTime);


        // Calculate the time difference in minutes
        const diff = endMinutes - startMinutes;

        // Calculate the width as a percentage
        const widthPercentage = (diff / maxDiff) * 100;

        // Set the width as inline style
        div.style.width = `${widthPercentage}%`;
    });

    // Function to convert time "HH:mm" to minutes
    function convertToMinutes(time) {
        const date = new Date(time);
        const hours = date.getHours();
        const minutes = date.getMinutes();
        return hours * 60 + minutes;
    }
});
</script>
@endsection