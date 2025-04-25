<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailTransaction>
 */
class DetailTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_id' => fake()->randomElement(Transaction::all()->pluck('id')->toArray()),
            'menu_id' => fake()->randomElement(Menu::all()->pluck('id')->toArray()),
            'quantity' => fake()->numberBetween(1, 10),
            'subtotal' => fake()->numberBetween(5000, 50000),
        ];
    }
}
