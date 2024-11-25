<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class BookerController extends Controller
{
    public function showBookerDashboard() {
        $user = Auth::user();
        $rooms = Room::all();
        $reservations = Reservation::where('user_id',$user->id)->get();
        return view('booker-content/booker-dashboard-page')->with([
            'user' => $user,
            'reservations' => $reservations,
            'rooms' => $rooms,
        ]);
    }

    public function showBookerReservation() {
        $user = Auth::user();
        $reservations = Reservation::where('user_id',$user->id)->get();
        $rooms = Room::all();
        return view('booker-content/booker-reservation-page')->with([
            'user' => $user,
            'reservations' => $reservations,
            'rooms' => $rooms,
        ]);
    }

    private function isOverlap($roomId, $startTime, $endTime, $bookDate) {
        $reservations = Reservation::whereDate('created_at', $bookDate)
            ->where('room_id', $roomId)
            ->where('status', 'approved')
            ->get();

        foreach ($reservations as $reservation) {
            $existingStartTime = \Carbon\Carbon::parse($reservation->start_time)->format('Y-m-d H:i:s');
            $existingEndTime = \Carbon\Carbon::parse($reservation->end_time)->format('Y-m-d H:i:s');

            if (
                ($startTime >= $existingStartTime && $startTime < $existingEndTime) || 
                ($endTime > $existingStartTime && $endTime <= $existingEndTime) || 
                ($startTime <= $existingStartTime && $endTime >= $existingEndTime)
            ) {
                return true;
            }
        }

        return false;
    }


    public function storeReservation(Request $request) {
        $user = Auth::user();
        $request->validate([
            'book_date' => 'required',
            'room_id' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
            'purpose' => 'required|string|max:255',
        ]);

        $bookDate = \Carbon\Carbon::parse($request->book_date)->format('Y-m-d');
        $startTime = \Carbon\Carbon::parse($bookDate . ' ' . $request->start_time)->format('Y-m-d H:i:s');
        $endTime = \Carbon\Carbon::parse($bookDate . ' ' . $request->end_time)->format('Y-m-d H:i:s');

        if ($this->isOverlap($request->room_id, $startTime, $endTime, $bookDate)) {
            return redirect()->back()->with('error', 'Overlapping reservation exists.');
        }

        $createdAt = \Carbon\Carbon::parse($bookDate)->format('Y-m-d H:i:s');

        $newReservation = Reservation::create([
            'user_id' => $user->id,
            'room_id' => $request->room_id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'purpose' => $request->purpose,
            'status' => 'pending',
            'created_at' => $createdAt,
        ]);

        if (!$newReservation) {
            return redirect()->back()->with('error', 'Failed to place reservation request.');
        }

        return redirect()->back()->with('success', 'Successfully placed reservation request.');
    }

}