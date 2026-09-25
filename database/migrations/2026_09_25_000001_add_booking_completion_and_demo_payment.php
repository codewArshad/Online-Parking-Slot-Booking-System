<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('status')->default('Booked')->change();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('Pending');
            $table->decimal('paid_amount', 8, 2)->default(0);
        });
    }

    public function down(): void
    {
        DB::table('bookings')->where('status', 'Completed')->update(['status' => 'Cancelled']);

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_status', 'paid_amount']);
            $table->enum('status', ['Booked', 'Cancelled'])->default('Booked')->change();
        });
    }
};
