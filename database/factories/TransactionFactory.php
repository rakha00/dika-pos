<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->randomElement(User::all()->pluck('id')->toArray()),
            'transaction_id' => fake()->unique()->bothify('TX-########'),
            'customer_name' => fake()->name,
            'total_price' => fake()->randomNumber(5, true),
            'status' => fake()->randomElement(['pending', 'completed', 'cancelled']),
        ];
    }
}
