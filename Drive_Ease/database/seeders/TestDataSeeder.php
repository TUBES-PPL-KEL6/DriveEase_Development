<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create test customer
        $customer = User::create([
            'name' => 'Test Customer',
            'username' => 'cust',
            'email' => 'customer@test.com',
            'password' => Hash::make('12345678'),
            'role' => 'customer',
        ]);

        // Create test vehicle
        $vehicle = Vehicle::create([
            'name' => 'Test Vehicle',
            'brand' => 'Toyota',
            'model' => 'Camry',
            'year' => 2020,
            'color' => 'Black',
            'price' => 500000,
            'status' => 'available',
        ]);

        // Create completed booking
        Booking::create([
            'user_id' => $customer->id,
            'vehicle_id' => $vehicle->id,
            'start_date' => now()->subDays(2),
            'end_date' => now()->subDay(),
            'status' => 'completed',
            'total_price' => 1000000,
        ]);
    }
} 