<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthenticationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\BookerController;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', [WebAuthenticationController::class, 'showLoginForm'])->name('showLoginForm');
    Route::post('/login', [WebAuthenticationController::class, 'login'])->name('login');
    Route::post('/register', [WebAuthenticationController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    // Admin routes
    Route::prefix('admin')->middleware('role:admin')->as('admin.')->group(function () {
        // Navigation Routes
        Route::get('/dashboard', [AdminController::class, 'showAdminDashboard'])->name('dashboard');
        Route::get('/rooms', [AdminController::class, 'showRoomDashboard'])->name('room.dashboard');
        Route::get('/reservations', [AdminController::class, 'showReservationDashboard'])->name('reservation.dashboard');
        Route::get('/users', [AdminController::class, 'showUserDashboard'])->name('user.dashboard');

        // CRUD route for user table
        Route::post('/users/register', [WebAuthenticationController::class, 'register'])->name('register');
        Route::delete('/users/delete', [WebAuthenticationController::class, 'delete'])->name('delete.user');
        Route::put('/users/update', [WebAuthenticationController::class, 'update'])->name('update.user');
        // Update self account
        Route::put('/user/{id}', [WebAuthenticationController::class, 'updateAccount'])->name('update.account');

        // CRUD route for rooms table
        Route::post('/rooms/add', [AdminController::class, 'addRoom'])->name('rooms.add');
        Route::put('/rooms/update', [AdminController::class, 'updateRoom'])->name('rooms.update');
        Route::delete('/rooms/delete', [AdminController::class, 'deleteRoom'])->name('rooms.delete');
        // CRUD route for reservations table
        Route::put('/reservation/update/{id}', [AdminController::class, 'updateReservationStatus'])->name('reservation.update');
    
    });

    // User routes
    Route::prefix('user')->middleware('role:user')->as('user.')->group(function () {
        // Navigation routes
        Route::get('/dashboard', [BookerController::class, 'showBookerDashboard'])->name('dashboard');
        Route::get('/reservation', [BookerController::class, 'showBookerReservation'])->name('reservation');
        
        Route::post('/create/reservation', [BookerController::class, 'storeReservation'])->name('create.reservation');

    });

    // Logiut route
    Route::post('/logout', [WebAuthenticationController::class, 'logout'])->name('logout');
});