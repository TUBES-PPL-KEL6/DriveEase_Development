<?php

namespace Database\Seeders;

use App\Models\User;
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

        // Create default users if they don't exist
        User::updateOrCreate(
            ['email' => 'pelanggan@gmail.com'],
            [
                'name' => 'pelanggan',
                'username' => 'pelanggan',
                'role' => 'customer',
                'password' => bcrypt('password'),
                'telepon' => '081234567890',
                'alamat' => 'Jl. Pelanggan No. 1'
            ]
        );

        User::updateOrCreate(
            ['email' => 'rental@gmail.com'],
            [
                'name' => 'rental',
                'username' => 'rental',
                'role' => 'owner',
                'password' => bcrypt('password'),
                'telepon' => '081234567891',
                'alamat' => 'Jl. Rental No. 1'
            ]
        );

        // Run the review feature seeder
        $this->call([
            ReviewFeatureSeeder::class,
        ]);

        $this->call([
            CarSeeder::class,
        ]);
    }
}
