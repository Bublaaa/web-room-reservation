<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return UserResource::collection($users);
        // return response()->json($users);
    }
}