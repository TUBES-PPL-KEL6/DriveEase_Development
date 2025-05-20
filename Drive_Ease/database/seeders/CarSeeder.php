<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vehicle::insert([
            [
                'name' => 'Honda Mobilio',
                'location' => 'Jakarta',
                'category' => 'MPV',
                'description' => 'Honda Mobilio 2018, White',
                'price_per_day' => 400000,
                'available' => true,
                'rental_id' => 2,
            ],
            [
                'name' => 'Ford Mustang',
                'location' => 'Bandung',
                'category' => 'Sedan',
                'description' => 'Ford Mustang 2022, Blue',
                'price_per_day' => 600000,
                'available' => true,
                'rental_id' => 2,
            ],
            [
                'name' => 'Nissan Altima',
                'location' => 'Surabaya',
                'category' => 'Sedan',
                'description' => 'Nissan Altima 2019, Black',
                'price_per_day' => 450000,
                'available' => true,
                'rental_id' => 2,
            ],
        ]);
    }
}
