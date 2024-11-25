<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Add a new room.
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'room_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:500',
        ]);

        // Create room
        $room = Room::create($validated);

        return response()->json([
            'message' => 'Room created successfully.',
            'data' => $room,
        ], 201);
    }

    /**
     * Get all rooms.
     */
    public function index()
    {
        $rooms = Room::all();

        return response()->json([
            'message' => 'Rooms retrieved successfully.',
            'data' => $rooms,
        ], 200);
    }

    /**
     * Get a single room by ID.
     */
    public function show($id)
    {
        $room = Room::find($id);

        if (!$room) {
            return response()->json(['error' => 'Room not found'], 404);
        }

        return response()->json([
            'message' => 'Room retrieved successfully.',
            'data' => $room,
        ], 200);
    }

    /**
     * Update a room by ID.
     */
    public function update(Request $request, $id)
    {
        $room = Room::find($id);

        if (!$room) {
            return response()->json(['error' => 'Room not found'], 404);
        }

        // Validate input
        $validated = $request->validate([
            'room_name' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'capacity' => 'sometimes|integer|min:1',
            'description' => 'sometimes|string|max:500',
        ]);

        // Update room
        $room->update($validated);

        return response()->json([
            'message' => 'Room updated successfully.',
            'data' => $room,
        ], 200);
    }

    /**
     * Delete a room by ID.
     */
    public function destroy($id)
    {
        $room = Room::find($id);

        if (!$room) {
            return response()->json(['error' => 'Room not found'], 404);
        }

        $room->delete();

        return response()->json([
            'message' => 'Room deleted successfully.',
        ], 200);
    }
}