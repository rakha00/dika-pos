<?php

namespace Database\Seeders;

use App\Models\DetailTransaction;
use App\Models\Menu;
use App\Models\Transaction;
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
        $this->call([
            UserSeeder::class,
            MenuSeeder::class,
        ]);

        // Transaction::factory(10)->create();

        // DetailTransaction::factory(50)->create();


    }
}
