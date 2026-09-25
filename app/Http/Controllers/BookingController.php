<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ParkingSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Show the user dashboard with quick stats.
     */
    public function userDashboard()
    {
        Booking::completeExpired();

        $availableSlots = ParkingSlot::count();
        $myActiveBookings = Booking::where('user_id', Auth::id())
            ->where('status', 'Booked')
            ->count();
        $myTotalBookings = Booking::where('user_id', Auth::id())->count();
        $myCompletedBookings = Booking::where('user_id', Auth::id())
            ->where('status', 'Completed')
            ->count();

        return view('user.dashboard', compact(
            'availableSlots', 'myActiveBookings', 'myTotalBookings', 'myCompletedBookings'
        ));
    }

    /**
     * Show only the available parking slots for booking.
     */
    public function showAvailableSlots()
    {
        // Availability depends on the selected date and time, not a permanent
        // Available/Booked flag on the slot.
        $slots = ParkingSlot::orderBy('slot_number')->paginate(9);

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
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $unavailable = DB::transaction(function () use ($validated) {
            // Serialize bookings for this slot to avoid simultaneous overlaps.
            $slot = ParkingSlot::whereKey($validated['parking_slot_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $overlap = Booking::where('parking_slot_id', $slot->id)
                ->where('booking_date', $validated['booking_date'])
                ->where('status', 'Booked')
                ->where('start_time', '<', $validated['end_time'])
                ->where('end_time', '>', $validated['start_time'])
                ->exists();

            if ($overlap) {
                return true;
            }

            $startMinutes = ((int) substr($validated['start_time'], 0, 2) * 60)
                + (int) substr($validated['start_time'], 3, 2);
            $endMinutes = ((int) substr($validated['end_time'], 0, 2) * 60)
                + (int) substr($validated['end_time'], 3, 2);
            $estimatedAmount = round(($endMinutes - $startMinutes) / 60 * (float) $slot->price, 2);

            Booking::create([
                'user_id' => Auth::id(),
                'parking_slot_id' => $slot->id,
                'vehicle_number' => $validated['vehicle_number'],
                'booking_date' => $validated['booking_date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'status' => 'Booked',
                'payment_status' => 'Paid',
                'paid_amount' => $estimatedAmount,
            ]);

            return false;
        });

        if ($unavailable) {
            return back()->withInput()->with('error', 'This slot is already booked for part of that time. Please choose another time.');
        }

        return redirect()->route('user.bookings')
            ->with('success', 'Parking slot booked successfully.');
    }

    /**
     * Show the logged-in user's own bookings only.
     */
    public function myBookings()
    {
        Booking::completeExpired();

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

        return back()->with('success', 'Booking cancelled successfully.');
    }
}
