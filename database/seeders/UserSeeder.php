<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'cashier',
            'email' => 'cashier@gmail.com',
            'password' => Hash::make('cashier'),
            'role' => 'cashier',
        ]);

        User::factory()->create([
            'name' => 'chef',
            'email' => 'chef@gmail.com',
            'password' => Hash::make('chef'),
            'role' => 'chef',
        ]);
    }
}
