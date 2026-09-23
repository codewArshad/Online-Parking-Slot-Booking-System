<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ParkingSlot;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard with simple statistics.
     */
    public function dashboard()
    {
        $totalSlots = ParkingSlot::count();
        $availableSlots = ParkingSlot::where('status', 'Available')->count();
        $bookedSlots = ParkingSlot::where('status', 'Booked')->count();
        $totalBookings = Booking::count();

        return view('admin.dashboard', compact(
            'totalSlots',
            'availableSlots',
            'bookedSlots',
            'totalBookings'
        ));
    }

    /**
     * Show all bookings, with optional search by slot number or vehicle number.
     */
    public function bookings(Request $request)
    {
        $search = $request->query('search');

        $bookings = Booking::with(['user', 'parkingSlot'])
            ->when($search, function ($query, $search) {
                $query->whereHas('parkingSlot', function ($q) use ($search) {
                    $q->where('slot_number', 'like', "%{$search}%");
                })->orWhere('vehicle_number', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.bookings.index', compact('bookings', 'search'));
    }
}
