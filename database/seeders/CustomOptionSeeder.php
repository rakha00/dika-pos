<?php

namespace Database\Seeders;

use App\Models\CustomOption;
use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find menus by name
        $nasiGoreng = Menu::where('name', 'Nasi Goreng Spesial')->first();
        $mieGoreng = Menu::where('name', 'Mie Goreng Seafood')->first();
        $esTeh = Menu::where('name', 'Es Teh Manis')->first();
        $kopiSusu = Menu::where('name', 'Kopi Susu Gula Aren')->first();

        // Options for Nasi Goreng
        if ($nasiGoreng) {
            $this->createOptions($nasiGoreng->id, 'Level Pedas', ['Tidak Pedas' => 0, 'Sedang' => 0, 'Sangat Pedas' => 2000]);
            $this->createOptions($nasiGoreng->id, 'Topping', ['Telur Dadar' => 4000, 'Sosis' => 5000]);
        }

        // Options for Mie Goreng
        if ($mieGoreng) {
            $this->createOptions($mieGoreng->id, 'Level Pedas', ['Tidak Pedas' => 0, 'Sedang' => 0, 'Gila' => 3000]);
        }

        // Options for Es Teh
        if ($esTeh) {
            $this->createOptions($esTeh->id, 'Ukuran', ['Reguler' => 0, 'Jumbo' => 3000]);
        }

        // Options for Kopi Susu
        if ($kopiSusu) {
            $this->createOptions($kopiSusu->id, 'Tingkat Manis', ['Normal Sugar' => 0, 'Less Sugar' => 0, 'No Sugar' => 0]);
            $this->createOptions($kopiSusu->id, 'Penyajian', ['Panas' => 0, 'Dingin' => 0]);
        }
    }

    /**
     * Helper function to create options easily
     */
    private function createOptions(int $menuId, string $category, array $options): void
    {
        foreach ($options as $value => $price) {
            CustomOption::create([
                'menu_id' => $menuId,
                'category' => $category,
                'value' => $value,
                'additional_price' => $price,
            ]);
        }
    }
}
