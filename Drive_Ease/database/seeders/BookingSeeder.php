<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Booking;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::where('role', 'customer')->first();
        $vehicle = Vehicle::first();

        if (!$customer || !$vehicle) {
            echo "Please make sure you have at least one customer and one vehicle in your tables.\n";
            return;
        }

        Booking::create([
            'user_id' => $customer->id,
            'vehicle_id' => $vehicle->id,
            'start_date' => Carbon::now()->subDays(3),
            'end_date' => Carbon::now()->subDay(),
            'status' => 'selesai',
            'total_price' => 1000000,
        ]);
    }
}