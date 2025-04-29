<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'cashier',
            'email' => 'cashier@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'cashier',
        ]);

        User::factory()->create([
            'name' => 'chef',
            'email' => 'chef@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'chef',
        ]);

        $this->call([
            MenuSeeder::class,
        ]);
    }
}
