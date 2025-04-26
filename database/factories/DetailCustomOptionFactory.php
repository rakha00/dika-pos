<?php

namespace Database\Factories;

use App\Models\CustomOption;
use App\Models\DetailTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailCustomOption>
 */
class DetailCustomOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "detail_transaction_id" => fake()->randomElement(DetailTransaction::all()->pluck('id')->toArray()),
            "custom_option_id" => fake()->randomElement(CustomOption::all()->pluck('id')->toArray()),
        ];
    }
}
