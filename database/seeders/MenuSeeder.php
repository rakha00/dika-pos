<?php

namespace Database\Seeders;

use App\Models\CustomOption;
use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::factory(30)->create();

        $drinkMenus = Menu::where('category', 'Minuman')->get();

        foreach ($drinkMenus as $menu) {
            // Size options
            $sizeOption = ['Large', 'Medium', 'Small'];
            foreach ($sizeOption as $size) {
                CustomOption::create([
                    'menu_id' => $menu->id,
                    'category' => 'Size',
                    'value' => $size,
                    'additional_price' => 2000,
                ]);
            }

            // Ice options
            $iceOption = ['More Ice', 'Less Ice', 'No Ice'];
            foreach ($iceOption as $ice) {
                CustomOption::create([
                    'menu_id' => $menu->id,
                    'category' => 'Ice',
                    'value' => $ice,
                    'additional_price' => 0
                ]);
            }

            // Topping options
            $toppingOption = ['Milk', 'Bobba', 'Grass', 'Honey', 'No Topping'];
            foreach ($toppingOption as $topping) {
                CustomOption::create([
                    'menu_id' => $menu->id,
                    'category' => 'Topping',
                    'value' => $topping,
                    'additional_price' => 5000
                ]);
            }
        }
    }
}
