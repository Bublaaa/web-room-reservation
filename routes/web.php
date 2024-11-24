<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthenticationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', [WebAuthenticationController::class, 'showLoginForm'])->name('showLoginForm');
    Route::post('/login', [WebAuthenticationController::class, 'login'])->name('login');
    Route::post('/register', [WebAuthenticationController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    // Admin routes
    Route::prefix('admin')->middleware('role:admin')->as('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'showAdminDashboard'])->name('dashboard');
        Route::get('/rooms', [AdminController::class, 'showRoomDashboard'])->name('room.dashboard');
        Route::get('/reservations', [AdminController::class, 'showReservationDashboard'])->name('reservation.dashboard');
        Route::get('/users', [AdminController::class, 'showUserDashboard'])->name('user.dashboard');
        Route::post('/users/register', [WebAuthenticationController::class, 'register'])->name('register');
        Route::delete('/users/delete', [WebAuthenticationController::class, 'delete'])->name('delete.user');
        Route::put('/users/update', [WebAuthenticationController::class, 'update'])->name('update.user');
        Route::put('/user/{id}', [WebAuthenticationController::class, 'updateAccount'])->name('update.account');


        // Resource routes
        Route::resource('room', RoomController::class);
        Route::resource('reservation', ReservationController::class);
        
    });

    // User routes
    Route::prefix('user')->middleware('role:user')->as('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'showUserDashboard'])->name('dashboard');
    });

    // Logiut route
    Route::post('/logout', [WebAuthenticationController::class, 'logout'])->name('logout');
});