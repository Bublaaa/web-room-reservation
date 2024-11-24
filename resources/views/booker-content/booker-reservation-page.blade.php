@extends('user-page')

@section('user-content')
<div class="w-full mt-14">
    <div class="flex flex-wrap w-full">
        <div class="w-full flex md:flex-row flex-col gap-4 mb-4">
            <!-- Table Header -->
            <div class="w-full h-fit  p-6 bg-white border border-gray-200 rounded-lg shadow order-last md:order-first">
                <div class="flex flex-row justify-between items-center mb-4">
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-row gap-4">
                            <h5 class="text-2xl font-semibold tracking-tight text-gray-900">Schedule
                            </h5>
                            <h5 class="text-2xl font-semibold tracking-tight text-gray-900">Date
                            </h5>
                        </div>

                        <p class="mb-3 font-normal text-gray-700">Choose your date to show the schedule on that day
                        </p>
                    </div>
                    <form>
                        <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                        <div class="relative">
                            <input type="date" id="scheduleDate"
                                class="block px-4 py-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search Username" required />
                    </form>
                </div>
            </div>
            <!-- Table -->
            <div class="overflow-x-auto w-full">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <!-- Column Headers -->
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Room</th>
                            <th scope="col" class="px-6 py-3">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                R ID
                            </th>
                            <td class="px-3 py-4 font-medium text-center">Room 1</td>
                            <td class="px-3 py-4 font-medium text-center">Start Time</td>
                            <td class="px-3 py-4 font-medium text-center">End Time</td>
                            <td class="px-3 py-4 font-medium text-center">Purpose</td>
                            <td class="px-3 py-4 font-medium text-center">Approved</td>
                            <td class="px-3 py-4 font-medium text-center">2024-11-23</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Add Reservation Card-->
        <div class="w-full md:max-w-sm min-w-sm p-6 h-fit bg-white border border-gray-200 rounded-lg shadow">
            <svg class="w-8 h-8 text-gray-500 mb-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M6.32 2.577a49.255 49.255 0 0 1 11.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 0 1-1.085.67L12 18.089l-7.165 3.583A.75.75 0 0 1 3.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93Z"
                    clip-rule="evenodd" />
            </svg>
            <a href="#">
                <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900">Book Your Room
                </h5>
            </a>
            <p class="mb-3 font-normal text-gray-500">Make sure to check on the schedule</p>
            <form id="addReservationForm" method="POST" action="{{ route('user.create.reservation') }}">
                @csrf
                <!-- Date Field -->
                <div class="mb-4">
                    <label for="bookDate" class="form-label">Booking Date</label>
                    <input type="date" id="bookDate" name="book_date" class="text-form" required>
                </div>

                <!-- Room id Field -->
                <div class="mb-4">
                    <label for="roomId" class="form-label">Location</label>
                    <select id="roomId" name="room_id" class="text-form" required>
                        <option value="" disabled selected>Select a Room</option>
                        @foreach($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-row gap-4">
                    <!-- Start Time Field -->
                    <div class="mb-4">
                        <label for="startTime" class="form-label">Start Time</label>
                        <input type="time" id="startTime" name="start_time" class="text-form" required>
                    </div>
                    <!-- End Time Field -->
                    <div class="mb-4">
                        <label for="endTime" class="form-label">End Time</label>
                        <input type="time" id="endTime" name="end_time" class="text-form" required>
                    </div>
                </div>

                <!-- Purpose Field -->
                <div class="mb-4">
                    <label for="purpose" class="form-label">Purpose</label>
                    <input type="text" id="purpose" name="purpose" class="text-form" required>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button type="submit" class="large-button primary-button">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bookDate = document.getElementById('bookDate');
    const scheduleDate = document.getElementById('scheduleDate');
    const roomId = document.getElementById('roomId');
    const startTime = document.getElementById('startTime');
    const endTime = document.getElementById('endTime');
    const purpose = document.getElementById('purpose');

    // Initial time constraint
    startTime.disabled = true;
    endTime.disabled = true;
    purpose.disabled = true;

    // Localized date and time formatting using Intl.DateTimeFormat
    const locale = navigator.language; // Get the user's locale
    const timeFormatter = new Intl.DateTimeFormat(locale, {
        hour: '2-digit',
        minute: '2-digit'
    });
    const dateFormatter = new Intl.DateTimeFormat(locale);

    // Set min and max date values for booking date
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(today.getDate() + 1); // Set min date to tomorrow
    const nextMonth = new Date(today.getFullYear(), today.getMonth() + 2, 0);

    const formattedTomorrow = tomorrow.toLocaleDateString('en-CA');
    const formattedMaxDate = nextMonth.toLocaleDateString('en-CA');

    bookDate.min = formattedTomorrow;
    bookDate.max = formattedMaxDate;
    scheduleDate.min = formattedTomorrow;
    scheduleDate.max = formattedMaxDate;

    // Disable Sundays on the date picker
    bookDate.addEventListener('input', function() {
        const selectedDate = new Date(bookDate.value);
        // Enable start time if date is not empty
        if (selectedDate) {
            startTime.disabled = false;
            startTime.min = "07:30";
        }

        // Sunday
        if (selectedDate.getDay() === 0) {
            // Move picker to monday
            selectedDate.setDate(selectedDate.getDate() + 1);
            const formattedNextMonday = selectedDate.toLocaleDateString('en-CA');
            bookDate.value = formattedNextMonday;
            // console.log('pindah ke senin');
            alert("Sundays are not available for booking.");
        }
        // Monday - Thursday
        else if (selectedDate.getDay() >= 1 && selectedDate.getDay() <= 4) {
            // console.log("monday-thursday");
            startTime.max = "14:30";
            endTime.max = "15:30";
        }
        // Friday
        else if (selectedDate.getDay() === 5) {
            // console.log("friday")
            startTime.max = "15:00";
            endTime.max = "16:00";
        }
        // Saturday
        else {
            // console.log("saturday")
            startTime.max = "12:00";
            endTime.max = "13:00";
        }


    });

    // Disable end time until start time is selected
    startTime.addEventListener('input', function() {
        if (startTime.value) {
            endTime.disabled = false;
            // Set min value for end time: 1 hour after start time
            const startTimeValue = new Date(`1970-01-01T${startTime.value}:00`);
            startTimeValue.setHours(startTimeValue.getHours() + 1);

            const minEndTime = startTimeValue.toLocaleTimeString('en-US', {
                hour12: false,
                hour: '2-digit',
                minute: '2-digit'
            });
            console.log("Min End Time (24-hour format):", minEndTime);

            endTime.min = minEndTime;
        } else {
            endTime.disabled = true;
        }
    });

    // Disable the Purpose field if room is not selected
    roomId.addEventListener('change', function() {
        if (roomId.value) {
            purpose.disabled = false;
        } else {
            purpose.disabled = true;
        }
    });
});
</script>
@endsection