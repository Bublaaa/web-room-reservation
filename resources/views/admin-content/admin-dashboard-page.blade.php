@extends('admin-page')

@section('admin-content')
<div class="w-full border-2 border-gray-200 border-dashed rounded-lg mt-14">
    <div class="flex flex-wrap w-full">
        <div class="w-full flex md:flex-row flex-col gap-4 mb-4">
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
        </div>
    </div>
</div>
@endsection