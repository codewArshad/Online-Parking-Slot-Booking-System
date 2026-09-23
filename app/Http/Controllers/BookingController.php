<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ParkingSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Show the user dashboard with quick stats.
     */
    public function userDashboard()
    {
        $availableSlots = ParkingSlot::where('status', 'Available')->count();
        $myActiveBookings = Booking::where('user_id', Auth::id())
            ->where('status', 'Booked')
            ->count();

        return view('user.dashboard', compact('availableSlots', 'myActiveBookings'));
    }

    /**
     * Show only the available parking slots for booking.
     */
    public function showAvailableSlots()
    {
        $slots = ParkingSlot::where('status', 'Available')->paginate(9);

        return view('user.book-slot', compact('slots'));
    }

    /**
     * Store a new booking for the logged-in user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'parking_slot_id' => 'required|exists:parking_slots,id',
            'vehicle_number' => 'required|string|max:20',
            'booking_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $slot = ParkingSlot::findOrFail($validated['parking_slot_id']);

        // Backend check - never trust that the slot is still available just
        // because the user saw it as available a moment ago.
        if ($slot->status !== 'Available') {
            return back()->with('error', 'Sorry, this parking slot is no longer available.');
        }

        Booking::create([
            'user_id' => Auth::id(), // never trust a user_id from the request
            'parking_slot_id' => $slot->id,
            'vehicle_number' => $validated['vehicle_number'],
            'booking_date' => $validated['booking_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => 'Booked',
        ]);

        $slot->update(['status' => 'Booked']);

        return redirect()->route('user.bookings')
            ->with('success', 'Parking slot booked successfully.');
    }

    /**
     * Show the logged-in user's own bookings only.
     */
    public function myBookings()
    {
        $bookings = Booking::with('parkingSlot')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.bookings', compact('bookings'));
    }

    /**
     * Cancel a booking belonging to the logged-in user.
     */
    public function cancel(Booking $booking)
    {
        // A user may only cancel their own booking.
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status !== 'Booked') {
            return back()->with('error', 'This booking is already cancelled.');
        }

        $booking->update(['status' => 'Cancelled']);
        $booking->parkingSlot->update(['status' => 'Available']);

        return back()->with('success', 'Booking cancelled successfully.');
    }
}
