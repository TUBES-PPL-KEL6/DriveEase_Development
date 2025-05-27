<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Car::insert([
            [
                'owner_id' => 2,
                'name' => 'Honda Civic',
                'brand' => 'Honda',
                'model' => 'Civic',
                'year' => '2018',
                'color' => 'Red',
                'price' => '40000',
            ],
            [
                'owner_id' => 2,
                'name' => 'Ford Mustang',
                'brand' => 'Ford',
                'model' => 'Mustang',
                'year' => '2022',
                'color' => 'Blue',
                'price' => '60000',
            ],
            [
                'owner_id' => 2,
                'name' => 'Nissan Altima',
                'brand' => 'Nissan',
                'model' => 'Altima',
                'year' => '2019',
                'color' => 'Black',
                'price' => '45000',
            ],
        ]);
    }
}
