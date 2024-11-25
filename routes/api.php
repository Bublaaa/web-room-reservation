<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AuthenticationController;

/**
 * Authentication Routes
 */
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthenticationController::class, 'login']);
    Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/user', [AuthenticationController::class, 'getAuthenticatedUser'])->middleware('auth:sanctum');
});

/**
 * User Routes
 */
Route::prefix('users')->middleware('auth:sanctum')->group(function () {
    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/', [UserController::class, 'index']); // Read All Users
        Route::get('/{id}', [UserController::class, 'show']); // Read Single User
        Route::put('/{id}', [UserController::class, 'update']); // Update User
        Route::delete('/{id}', [UserController::class, 'destroy']); // Delete User
    });

    // Public Routes
    Route::post('/register', [UserController::class, 'store']); // Register User
});

/**
 * Room Routes
 */
Route::prefix('rooms')->middleware('auth:sanctum')->group(function () {
    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::post('/', [RoomController::class, 'store']); // Add New Room
        Route::put('/{id}', [RoomController::class, 'update']); // Update Room
        Route::delete('/{id}', [RoomController::class, 'destroy']); // Delete Room
    });

    // Public Routes
    Route::get('/', [RoomController::class, 'index']); // Read All Rooms
    Route::get('/{id}', [RoomController::class, 'show']); // Read Single Room
});

/**
 * Reservation Routes
 */
Route::prefix('reservations')->middleware('auth:sanctum')->group(function () {
    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::put('/{id}/status', [ReservationController::class, 'updateStatus']); // Update Reservation Status
    });

    // Public Routes
    Route::post('/', [ReservationController::class, 'store']); // Create New Reservation
    Route::get('/', [ReservationController::class, 'index']); // Read All Reservations
    Route::get('/{id}', [ReservationController::class, 'show']); // Read Single Reservation
    Route::delete('/{id}', [ReservationController::class, 'destroy']); // Delete Reservation
});