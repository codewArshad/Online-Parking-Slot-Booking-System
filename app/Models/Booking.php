<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parking_slot_id',
        'vehicle_number',
        'booking_date',
        'start_time',
        'end_time',
        'status',
    ];

    /**
     * A booking belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A booking belongs to a parking slot.
     */
    public function parkingSlot()
    {
        return $this->belongsTo(ParkingSlot::class);
    }
}
