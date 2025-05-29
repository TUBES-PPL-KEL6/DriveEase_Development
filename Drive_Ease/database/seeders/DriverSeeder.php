<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\DriverJob;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Driver::insert([
            [
                'name' => 'John Doe',
                'phone' => '081234567890',
                'email' => 'john@example.com',
                'rental_id' => 2,
            ],
            [
                'name' => 'Jane Kamal',
                'phone' => '081234567890',
                'email' => 'jane@example.com',
                'rental_id' => 2,
            ],
            [
                'name' => 'Sarah Smith',
                'phone' => '081234567890',
                'email' => 'sarah@example.com',
                'rental_id' => 2,
            ],
            [
                'name' => 'Michael Brown',
                'phone' => '081234567890',
                'email' => 'michael@example.com',
                'rental_id' => 2,
            ],
            [
                'name' => 'Emily Davis',
                'phone' => '081234567890',
                'email' => 'emily@example.com',
                'rental_id' => 2,
            ]
        ]);
    }
}
