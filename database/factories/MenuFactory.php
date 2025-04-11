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
            'deskripsi' => fake()->sentence(3),
            'image' => fake()->imageUrl(640, 480, 'food'),
            'kategori' => fake()->randomElement(['Makanan', 'Minuman', 'Dessert', 'Snacks']),
            'harga' => fake()->numberBetween(5000, 50000),
            'stok' => fake()->randomNumber(2),
        ];
    }
}
