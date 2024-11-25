<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebAuthenticationController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        
        if (Auth::attempt($request->only('username', 'password'))) {
            $user = Auth::user();
            
            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('user.dashboard');
        }

        return back()->withErrors(['username' => 'Invalid credentials']);
    }

    // Show register page
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
         
        $request->validate([
            'username' => 'required|string|unique:users',
            'email' => 'required|string|unique:users',
            'role' => 'required',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user', // Default to 'user' if no role is provided
        ]);

        // Auth::login($user);
        if(!$user) {
            return redirect()->back()->with('error', 'User updated successfully.');
        }
        return redirect()->back()->with('success',"Success register new user");
    }

    // Handle logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('showLoginForm');
    }

     public function updateAccount(Request $request, $id)
    {
        // dd($request);
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);
        $user = User::findOrFail($id);

        $user->username = $request->input('username');
        $user->email = $request->input('email');

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->input('new_password'));
        }

        $user->save();

        return redirect()->back()->with('success', 'User updated successfully!');
    }

    // Handle update user
    public function update(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username,' . $request->userId,
            'email' => 'required|string|email|unique:users,email,' . $request->userId,
            'role' => 'required|string',
        ]);
        $user = User::findOrFail($request->userId);
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'User updated successfully.');
    }


    // Handle delete user
    public function delete(Request $request)
    {
        $user = User::findOrFail($request->userId);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}