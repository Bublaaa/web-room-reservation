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
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user', // Default to 'user' if no role is provided
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard');
    }

    // Handle logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('showLoginForm');
    }

    // Show edit user page
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('auth.edit', compact('user'));
    }

    // Handle update user
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username,' . $id,
            'email' => 'required|string|email|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully.');
    }

    // Handle delete user
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
    }
}