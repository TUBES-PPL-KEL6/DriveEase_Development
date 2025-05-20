<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Rent;
use App\Models\Review;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate([
            'email' => 'pelanggan@gmail.com'
        ], [
            'name' => 'pelanggan',
            'username' => 'pelanggan',
            'role' => 'pelanggan',
            'password' => bcrypt('password'),
        ]);

        User::firstOrCreate([
            'email' => 'rental@gmail.com'
        ], [
            'name' => 'rental',
            'username' => 'rental',
            'role' => 'rental',
            'password' => bcrypt('password'),
        ]);

        User::firstOrCreate([
            'email' => 'admin@example.com'
        ], [
            'name' => 'Admin',
            'username' => 'admin',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            CarSeeder::class,
        ]);

        // Create demo users
        $customer = \App\Models\User::firstOrCreate([
            'email' => 'customer@example.com'
        ], [
            'name' => 'Customer Demo',
            'username' => 'customer',
            'role' => 'pelanggan',
            'password' => bcrypt('password'),
        ]);

        $rental = \App\Models\User::firstOrCreate([
            'email' => 'rental@example.com'
        ], [
            'name' => 'Rental Demo',
            'username' => 'rental',
            'role' => 'rental',
            'password' => bcrypt('password'),
        ]);

        // Create a vehicle
        $vehicle = Vehicle::firstOrCreate([
            'name' => 'Demo Car',
            'rental_id' => $rental->id,
        ], [
            'location' => 'Jakarta',
            'category' => 'SUV',
            'description' => 'Demo car for review feature',
            'price_per_day' => 500000,
            'available' => true,
        ]);

        // Create a rent (simulate completed rental)
        $rent = Rent::firstOrCreate([
            'customer_id' => $customer->id,
            'car_id' => $vehicle->id,
            'status' => 'selesai',
        ], [
            'start_date' => now()->subDays(5),
            'end_date' => now()->subDays(2),
            'total_price' => 1500000,
        ]);

        // Create a review (optional, or let user create via UI)
        Review::firstOrCreate([
            'user_id' => $customer->id,
            'vehicle_id' => $vehicle->id,
            'rental_id' => $rental->id,
        ], [
            'rating' => 5,
            'comment' => 'Great rental experience!',
            'is_approved' => true,
        ]);
    }
}
