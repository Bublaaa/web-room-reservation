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

}