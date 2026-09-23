<?php

namespace Database\Seeders;

use App\Models\ParkingSlot;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Demo admin account.
        // IMPORTANT: change this password before any real deployment.
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'phone' => '9999999999',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin',
        ]);

        // Sample parking slots for demonstration.
        $slots = [
            ['slot_number' => 'A-01', 'location' => 'Ground Floor', 'vehicle_type' => 'Car', 'price' => 100.00, 'status' => 'Available'],
            ['slot_number' => 'A-02', 'location' => 'Ground Floor', 'vehicle_type' => 'Car', 'price' => 100.00, 'status' => 'Available'],
            ['slot_number' => 'B-01', 'location' => 'First Floor', 'vehicle_type' => 'Bike', 'price' => 50.00, 'status' => 'Available'],
            ['slot_number' => 'B-02', 'location' => 'First Floor', 'vehicle_type' => 'Both', 'price' => 75.00, 'status' => 'Available'],
        ];

        foreach ($slots as $slot) {
            ParkingSlot::create($slot);
        }
    }
}
