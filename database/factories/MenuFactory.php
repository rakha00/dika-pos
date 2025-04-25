<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(1),
            'category' => fake()->randomElement(['Makanan', 'Minuman', 'Dessert', 'Snacks']),
            'description' => fake()->sentence(3),
            'image' => 'https://placehold.co/400',
            'price' => fake()->numberBetween(5000, 50000),
            'stock' => fake()->randomNumber(2),
        ];
    }
}
