<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;

class CompleteExpiredBookings extends Command
{
    protected $signature = 'bookings:complete-expired';

    protected $description = 'Mark bookings as completed when their end time has passed';

    public function handle(): int
    {
        $completed = Booking::completeExpired();

        $this->info("Completed {$completed} expired booking(s).");

        return self::SUCCESS;
    }
}
