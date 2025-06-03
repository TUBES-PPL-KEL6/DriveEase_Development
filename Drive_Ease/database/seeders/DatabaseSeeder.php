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

        User::insert([
            [
                'name' => 'pelanggan',
                'username' => 'pelanggan',
                'email' => 'pelanggan@gmail.com',
                'role' => 'pelanggan',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'rental',
                'username' => 'rental',
                'email' => 'rental@gmail.com',
                'role' => 'rental',
                'password' => bcrypt('password'),
            ]
        ]);

        $this->call([
            CarSeeder::class,
        ]);
    }
}
