<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;

class ReviewFeatureSeeder extends Seeder
{
    public function run(): void
    {
        // Create test customer
        $customer = User::updateOrCreate(
            ['email' => 'customer@test.com'],
            [
                'name' => 'Test Customer',
                'username' => 'testcustomer',
                'password' => Hash::make('12345678'),
                'role' => 'customer',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Test No. 123'
            ]
        );

        // Create test rental
        $rental = User::updateOrCreate(
            ['email' => 'rental@test.com'],
            [
                'name' => 'Test Rental',
                'username' => 'testrental',
                'password' => Hash::make('12345678'),
                'role' => 'rental',
                'telepon' => '081234567891',
                'alamat' => 'Jl. Rental No. 456'
            ]
        );

        // Create test vehicles
        $vehicles = [
            [
                'name' => 'Toyota Camry',
                'location' => 'Jakarta',
                'category' => 'Sedan',
                'description' => 'Toyota Camry 2022, warna hitam, kondisi baru',
                'price_per_day' => 500000,
                'available' => true,
                'image_path' => null,
                'rental_id' => $rental->id
            ],
            [
                'name' => 'Honda Civic',
                'location' => 'Jakarta',
                'category' => 'Sedan',
                'description' => 'Honda Civic 2023, warna putih, kondisi baru',
                'price_per_day' => 450000,
                'available' => true,
                'image_path' => null,
                'rental_id' => $rental->id
            ]
        ];

        foreach ($vehicles as $vehicleData) {
            $vehicle = Vehicle::create($vehicleData);

            // Create some reviews for each vehicle
            Review::create([
                'user_id' => $customer->id,
                'vehicle_id' => $vehicle->id,
                'rating' => 5,
                'comment' => 'Kendaraan sangat bagus dan nyaman!'
            ]);

            // Create some additional reviews from other users
            for ($i = 1; $i <= 3; $i++) {
                $otherUser = User::updateOrCreate(
                    ['email' => "reviewer$i@test.com"],
                    [
                        'name' => "Reviewer $i",
                        'username' => "reviewer$i",
                        'password' => Hash::make('12345678'),
                        'role' => 'customer',
                        'telepon' => "08123456789$i",
                        'alamat' => "Jl. Reviewer $i No. $i"
                    ]
                );

                Review::create([
                    'user_id' => $otherUser->id,
                    'vehicle_id' => $vehicle->id,
                    'rating' => rand(3, 5),
                    'comment' => "Review dari Reviewer $i - " . ($i % 2 == 0 ? 'Sangat puas dengan pelayanan' : 'Kendaraan dalam kondisi baik')
                ]);
            }
        }
    }
} 