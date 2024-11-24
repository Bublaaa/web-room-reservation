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
        return view('admin-page')->with([
            'admin' => $this->admin,
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
        $admin = auth()->user();
        $rooms = Room::all();
        return view('admin-content/admin-room-page')->with([
            'rooms' => $rooms,
            'admin' => $this->admin,
        ]);
    }
    public function showReservationDashboard(){
        $admin = auth()->user();
        $reservations = Reservation::all();
        return view('admin-content/admin-reservation-page')->with([
            'reservations' => $reservations,
            'admin' => $this->admin,
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


}