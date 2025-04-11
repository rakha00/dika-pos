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
            'nama_menu' => fake()->sentence(1),
            'kategori' => fake()->randomElement(['Makanan', 'Minuman']),
            'harga' => fake()->numberBetween(5000, 50000),
            'stok' => fake()->randomNumber(2),
            'status_tersedia' => true,
        ];
    }
}
