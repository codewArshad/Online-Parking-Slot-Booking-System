<?php

namespace App\Http\Controllers;

use App\Models\ParkingSlot;
use Illuminate\Http\Request;

class ParkingSlotController extends Controller
{
    /**
     * Show all parking slots (admin management view).
     */
    public function index()
    {
        $slots = ParkingSlot::latest()->paginate(10);

        return view('admin.slots.index', compact('slots'));
    }

    /**
     * Show the form to add a new parking slot.
     */
    public function create()
    {
        return view('admin.slots.create');
    }

    /**
     * Store a newly created parking slot.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'slot_number' => 'required|string|max:20|unique:parking_slots,slot_number',
            'location' => 'required|string|max:255',
            'vehicle_type' => 'required|in:Car,Bike,Both',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:Available,Booked',
        ]);

        ParkingSlot::create($validated);

        return redirect()->route('admin.slots.index')
            ->with('success', 'Parking slot added successfully.');
    }

    /**
     * Show the form to edit an existing parking slot.
     */
    public function edit(ParkingSlot $slot)
    {
        return view('admin.slots.edit', compact('slot'));
    }

    /**
     * Update an existing parking slot.
     */
    public function update(Request $request, ParkingSlot $slot)
    {
        $validated = $request->validate([
            'slot_number' => 'required|string|max:20|unique:parking_slots,slot_number,' . $slot->id,
            'location' => 'required|string|max:255',
            'vehicle_type' => 'required|in:Car,Bike,Both',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:Available,Booked',
        ]);

        $slot->update($validated);

        return redirect()->route('admin.slots.index')
            ->with('success', 'Parking slot updated successfully.');
    }

    /**
     * Delete a parking slot, unless it has an active booking.
     */
    public function destroy(ParkingSlot $slot)
    {
        $hasActiveBooking = $slot->bookings()->where('status', 'Booked')->exists();

        if ($hasActiveBooking) {
            return redirect()->route('admin.slots.index')
                ->with('error', 'This parking slot cannot be deleted because it has an active booking.');
        }

        $slot->delete();

        return redirect()->route('admin.slots.index')
            ->with('success', 'Parking slot deleted successfully.');
    }
}
