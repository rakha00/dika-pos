<?php

namespace Database\Seeders;

use App\Models\CustomOption;
use App\Models\CustomOptionValue;
use App\Models\Menu;
use App\Models\MenuCustomOption;
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
        $customOptions = ['Topping', 'Sugar Level', 'Ice Level'];
        // Create custom options
        foreach ($customOptions as $option) {
            CustomOption::create([
                'name' => $option,
            ]);
        }

        // Create values for Topping option
        $toppingValues = ['Chocolate', 'Bobba', 'Jelly', 'Matcha'];
        foreach ($toppingValues as $value) {
            CustomOptionValue::create([
                'custom_option_id' => 1, // Topping
                'value' => $value,
                'additional_price' => rand(1000, 5000),
            ]);
        }

        // Create values for Sugar Level option
        $sugarValues = ['No Sugar', 'Less Sugar'];
        foreach ($sugarValues as $value) {
            CustomOptionValue::create([
                'custom_option_id' => 2, // Sugar Level
                'value' => $value,
                'additional_price' => rand(1000, 5000),
            ]);
        }

        // Create values for Ice Level option
        $iceValues = ['No Ice', 'Less Ice', 'More Ice'];
        foreach ($iceValues as $value) {
            CustomOptionValue::create([
                'custom_option_id' => 3, // Ice Level
                'value' => $value,
                'additional_price' => rand(1000, 5000),
            ]);
        }

        // Get all menus with drink category
        $drinkMenus = Menu::where('category', 'minuman')->get();

        // For each drink menu, assign all custom options (topping, sugar level, ice level)
        foreach ($drinkMenus as $menu) {
            for ($i = 1; $i <= 3; $i++) {
                MenuCustomOption::create([
                    'id_menu' => $menu->id,
                    'custom_option_id' => $i,
                ]);
            }
        }
    }
}
