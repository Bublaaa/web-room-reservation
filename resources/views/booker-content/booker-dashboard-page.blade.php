@extends('user-page')

@section('user-content')
<div class="w-full mt-14">
    <div class="flex flex-wrap w-full">
        <div class="w-full flex md:flex-row flex-col gap-4 mb-4">
            <!-- Table Header -->
            <div class="w-full h-fit  p-6 bg-white border border-gray-200 rounded-lg shadow order-last md:order-first">
                <div class="flex flex-row justify-between items-center mb-4">
                    <div class="flex flex-row items-center justify-center gap-4">
                        <button type="button" class="primary-button rounded-lg px-3 py-3 inline-flex items-center"
                            id="openRegisterModal">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M6.32 2.577a49.255 49.255 0 0 1 11.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 0 1-1.085.67L12 18.089l-7.165 3.583A.75.75 0 0 1 3.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div class="flex flex-col gap-2">
                            <h5 class="text-2xl font-semibold tracking-tight text-gray-900">Your Reservation History
                            </h5>
                            <p class="mb-3 font-normal text-gray-700">Click on reservation row to view detail</p>
                        </div>
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
                    <!-- Column Headers -->
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Room ID</th>
                            <th scope="col" class="px-3 py-3">Start Time</th>
                            <th scope="col" class="px-3 py-3">End Time</th>
                            <th scope="col" class="px-6 py-3">Purpose</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="flex items-center font-bold px-3 py-4 text-gray-900">
                                #{{$reservation->id}}
                            </td>
                            @foreach($rooms as $room)
                            @if($reservation->room_id == $room->id)
                            <td class="px-3 py-4 font-medium">{{ $room->room_name }}</td>
                            @endif
                            @endforeach
                            <td class="px-3 py-4 font-medium text-end">
                                {{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}
                            </td>
                            <td class="px-3 py-4 font-medium">
                                {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}
                            </td>
                            <td class="px-3 py-4 font-medium">{{ $reservation->purpose }}</td>
                            <td class="px-3 py-4 font-medium 
                                @if($reservation->status == 'rejected')
                                    text-red-600
                                @elseif($reservation->status == 'pending')
                                    text-yellow-600
                                @elseif($reservation->status == 'approved')
                                    text-green-600
                                @endif
                            ">
                                {{ strtoupper($reservation->status) }}
                            </td>
                            <td class="px-3 py-4 font-medium">
                                {{ \Carbon\Carbon::parse($reservation->created_at)->format('d M Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Account Setting Card-->
        <div class="w-full md:max-w-sm min-w-sm p-6 h-fit bg-white border border-gray-200 rounded-lg shadow">
            <svg class="w-8 h-8 text-gray-500 mb-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
            </svg>
            <a href="#">
                <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900">Account Setting
                </h5>
            </a>
            <p class="mb-3 font-normal text-gray-500">Change your account detail</p>
            <form id="editAccountForm" method="POST" action="#">
                @csrf
                @method('PUT')

                <!-- Username Field -->
                <div class="mb-4">
                    <label for="editAccountUsername" class="form-label">Username</label>
                    <input type="text" id="editAccountUsername" name="username" class="text-form"
                        value="{{ $user->username }}" required>
                </div>

                <!-- Email Field -->
                <div class="mb-4">
                    <label for="editEmail" class="form-label">Email</label>
                    <input type="email" id="editAccountEmail" name="email" class="text-form" value="{{ $user->email }}"
                        required>
                </div>

                <!-- Checkbox for Password Update -->
                <div class="mb-4 flex items-center">
                    <input type="checkbox" id="changePasswordCheckbox" class="mr-2" onchange="togglePasswordFields()">
                    <label for="changePasswordCheckbox" class="form-label mt-2">Change Password</label>
                </div>

                <!-- Password Fields (Initially Hidden) -->
                <div id="passwordFields" class="hidden">
                    <!-- New Password -->
                    <div class="mb-4">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" id="newPassword" name="new_password" class="text-form" disabled>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" id="confirmPassword" name="new_password_confirmation" class="text-form"
                            disabled>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button type="submit" class="large-button primary-button">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection