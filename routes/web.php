<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthenticationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;

Route::middleware('guest')->group(function () {
    Route::get('/',[WebAuthenticationController::class, 'showLoginForm'])->name('showLoginForm');
    Route::post('/login', [WebAuthenticationController::class, 'login'])->name('login');
    Route::get('/register', [WebAuthenticationController::class, 'showRegister'])->name('register');
    Route::post('/register', [WebAuthenticationController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    // Logout route
    Route::post('/logout', [WebAuthenticationController::class, 'logout'])->name('logout');
    // admin route
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'showAdminDashboard'])->name('admin.dashboard');
        Route::get('/rooms', [AdminController::class, 'showRoomDashboard'])->name('admin.room.dashboard');
        Route::get('/reservations', [AdminController::class, 'showReservationDashboard'])->name('admin.reservation.dashboard');
        Route::get('/users', [AdminController::class, 'showUserDashboard'])->name('admin.user.dashboard');
        
        Route::get('/register', [AdminController::class, 'register'])->name('register-user');
        Route::resource('room', RoomController::class);
        Route::resource('reservation', ReservationController::class);
    });
    // user route
    Route::middleware('role:user')->group(function () {
        Route::get('/user/dashboard', function () {
            return view('user.dashboard');
        })->name('user.dashboard');
    });
});