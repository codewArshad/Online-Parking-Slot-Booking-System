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
        'payment_method',
        'payment_status',
        'paid_amount',
    ];

    /** Mark elapsed bookings complete and return how many records changed. */
    public static function completeExpired(): int
    {
        $now = now();

        return static::where('status', 'Booked')
            ->where(function ($query) use ($now) {
                $query->where('booking_date', '<', $now->toDateString())
                    ->orWhere(function ($query) use ($now) {
                        $query->where('booking_date', $now->toDateString())
                            ->where('end_time', '<=', $now->format('H:i:s'));
                    });
            })
            ->update(['status' => 'Completed', 'updated_at' => $now]);
    }

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
