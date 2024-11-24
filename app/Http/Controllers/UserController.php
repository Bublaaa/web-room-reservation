<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return UserResource::collection($users);
        // return response()->json($users);
    }
    
    public function showUserDashboard() {
        $user = Auth::user();
        return view('user-page')->with([
            'user' => $user,
        ]);
    }
}