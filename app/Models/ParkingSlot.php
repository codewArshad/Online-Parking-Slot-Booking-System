<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'slot_number',
        'location',
        'vehicle_type',
        'status',
        'price',
    ];

    /**
     * A parking slot can have many bookings over time.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
