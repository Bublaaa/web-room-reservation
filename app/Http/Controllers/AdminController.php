<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    protected $admin;

    public function __construct()
    {
        $this->admin = auth()->user();
    }
    
    public function showAdminDashboard(){
        $admin = auth()->user();
        $rooms = Room::all();
        $users = User::all();
        $reservations = Reservation::all();
        
        $totalReservations = $reservations->count();
        $pendingReservations = $reservations->where('status', 'pending')->count();
        return view('admin-content/admin-dashboard-page')->with([
            'admin' => $this->admin,
             'users' => $users,
            'rooms' => $rooms,
            'reservations' => $reservations,
            'totalReservations' => $totalReservations,
            'pendingReservations' => $pendingReservations,
        ]);
    }
    public function showUserDashboard(){
        $admin = auth()->user();
        $users = User::where('id', '!=', $admin->id)->get();
        return view('admin-content/admin-user-page')->with([
            'admin' => $this->admin,
            'users' => $users,
        ]);
    }
    public function showRoomDashboard(){
        $rooms = Room::all();
        return view('admin-content/admin-room-page')->with([
            'rooms' => $rooms,
            'admin' => $this->admin,
        ]);
    }
    public function showReservationDashboard(){
        $users = User::all();
        $rooms = Room::all();
        $reservations = Reservation::all();
        return view('admin-content/admin-reservation-page')->with([
            'admin' => $this->admin,
            'users' => $users,
            'rooms' => $rooms,
            'reservations' => $reservations,
        ]);
    }

// Room CRUD Function

    public function addRoom(Request $request) {
        $request->validate([
            'room_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|int|max:100|min:10',
            'description' => 'required|string|max:255',
        ]);
        $newRoom = Room::create([
            'room_name' => $request->room_name,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'description' => $request->description,
        ]);

        if (!$newRoom) {
            return redirect()->back()->with('error', 'Failed to register new room');
        }
        return redirect()->back()->with('success', 'Successfully registered new room');
    }

    public function updateRoom(Request $request) {
        $request->validate([
            'roomId' => 'required',
            'room_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|int|max:100|min:10',
            'description' => 'required|string|max:255',
        ]);

        $room = Room::find($request->roomId);

        if (!$room) {
            return redirect()->back()->with('error', 'Room not found');
        }

        $updated = $room->update([
            'room_name' => $request->room_name,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'description' => $request->description,
        ]);

        if (!$updated) {
            return redirect()->back()->with('error', 'Failed to update room');
        }

        return redirect()->back()->with('success', 'Successfully updated room');
    }

    public function deleteRoom(Request $request) {

        $room = Room::find($request->roomId);

        if (!$room) {
            return redirect()->back()->with('error', 'Room not found');
        }

        if (!$room->delete()) {
            return redirect()->back()->with('error', 'Failed to delete room');
        }

        return redirect()->back()->with('success', 'Successfully deleted room');
    }


// CRUD for Reservation
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
    
    public function updateReservationStatus(Request $request, $id) {
        $request->validate([
            'status' => 'required',
        ]);

        $reservation = Reservation::findOrFail($id);

        if ($request->status === 'approved') {
            if ($this->isOverlap($reservation->room_id, $reservation->start_time, $reservation->end_time, $reservation->created_at)) {
                return redirect()->back()->with('error', 'Overlapping reservation exists. Status cannot be updated to approved.');
            }
        }

        $reservation->status = $request->status;
        $reservation->save();

        return redirect()->back()->with('success', 'Reservation status updated successfully.');
    }

    public function deleteReservation(Request $request) {

        $reservation = Reservation::find($request->reservationId);
        if (!$reservation) {
            return redirect()->back()->with('error', 'Room not found');
        }

        if (!$reservation->delete()) {
            return redirect()->back()->with('error', 'Failed to delete reservation');
        }

        return redirect()->back()->with('success', 'Successfully deleted reservation');
    }

}