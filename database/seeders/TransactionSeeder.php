<?php

namespace Database\Seeders;


use App\Models\DetailTransaction;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::factory(10)->create();

        DetailTransaction::factory(50)->create();
    }
}
