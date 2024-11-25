<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Create New Reservation
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'required|exists:users,id',
            'purpose' => 'required|string|max:255',
            'start_time' => 'required|date|before:end_time',
            'end_time' => 'required|date|after:start_time',
            'book_date' => 'required|date',
        ]);

        $roomId = $request->room_id;
        $startTime = $request->start_time;
        $endTime = $request->end_time;
        $bookDate = $request->book_date;

        // Check for overlapping reservations
        if ($this->isOverlap($roomId, $startTime, $endTime, $bookDate)) {
            return response()->json(['error' => 'The room is already reserved for the selected time slot.'], 409);
        }

        $reservation = Reservation::create($request->all());

        return response()->json([
            'message' => 'Reservation created successfully.',
            'data' => $reservation,
        ], 201);
    }

    /**
     * Read All Reservations
     */
    public function index()
    {
        $reservations = Reservation::with(['room', 'user'])->get();

        return response()->json([
            'message' => 'Reservations retrieved successfully.',
            'data' => $reservations,
        ], 200);
    }

    /**
     * Read Single Reservation
     */
    public function show($id)
    {
        $reservation = Reservation::with(['room', 'user'])->find($id);

        if (!$reservation) {
            return response()->json(['error' => 'Reservation not found.'], 404);
        }

        return response()->json([
            'message' => 'Reservation retrieved successfully.',
            'data' => $reservation,
        ], 200);
    }

    /**
     * Update Reservation Status
     */
    public function updateStatus(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json(['error' => 'Reservation not found.'], 404);
        }

        $request->validate([
            'status' => 'required|string|in:approved,pending,declined',
        ]);

        // Check for overlapping reservations only if updating status to 'approved'
        if ($request->status === 'approved') {
            $roomId = $reservation->room_id;
            $startTime = $reservation->start_time;
            $endTime = $reservation->end_time;
            $bookDate = $reservation->created_at->format('Y-m-d');

            if ($this->isOverlap($roomId, $startTime, $endTime, $bookDate)) {
                return response()->json(['error' => 'The room is already reserved for the selected time slot.'], 409);
            }
        }

        $reservation->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Reservation status updated successfully.',
            'data' => $reservation,
        ], 200);
    }

    /**
     * Delete Reservation
     */
    public function destroy($id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json(['error' => 'Reservation not found.'], 404);
        }

        $reservation->delete();

        return response()->json([
            'message' => 'Reservation deleted successfully.',
        ], 200);
    }

    /**
     * Check for Overlapping Reservations
     */
    private function isOverlap($roomId, $startTime, $endTime, $bookDate)
    {
        $reservations = Reservation::whereDate('created_at', $bookDate)
            ->where('room_id', $roomId)
            ->where('status', 'approved')
            ->get();

        foreach ($reservations as $reservation) {
            $existingStartTime = Carbon::parse($reservation->start_time);
            $existingEndTime = Carbon::parse($reservation->end_time);

            if (
                ($startTime >= $existingStartTime && $startTime < $existingEndTime) ||
                ($endTime > $existingStartTime && $endTime <= $existingEndTime) ||
                ($startTime <= $existingStartTime && $endTime >= $existingEndTime)
            ) {
                return true;
            }
        }

        return false;
    }
}