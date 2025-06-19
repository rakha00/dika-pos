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
        // Default password for all users is 'password'
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Kasir Siska',
            'email' => 'siska@gmail.com',
            'role' => 'cashier',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Kasir Budi',
            'email' => 'budi@gmail.com',
            'role' => 'cashier',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Chef Anton',
            'email' => 'anton@gmail.com',
            'role' => 'chef',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Chef Rina',
            'email' => 'rina@gmail.com',
            'role' => 'chef',
            'password' => Hash::make('password'),
        ]);
    }
}
