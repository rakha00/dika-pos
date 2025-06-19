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
        $menus = [
            // Makanan Berat
            ['name' => 'Nasi Goreng Spesial', 'category' => 'Makanan Berat', 'description' => 'Nasi goreng dengan telur, ayam suwir, dan acar.', 'image' => 'menus/nasi-goreng.jpg', 'price' => 25000, 'stock' => 50, 'is_available' => true],
            ['name' => 'Mie Goreng Seafood', 'category' => 'Makanan Berat', 'description' => 'Mie goreng dengan udang, cumi, dan sayuran segar.', 'image' => 'menus/mie-goreng.jpg', 'price' => 28000, 'stock' => 45, 'is_available' => true],
            ['name' => 'Ayam Bakar Madu', 'category' => 'Makanan Berat', 'description' => 'Ayam bakar dengan bumbu madu manis gurih, disajikan dengan sambal.', 'image' => 'menus/ayam-bakar.jpg', 'price' => 35000, 'stock' => 30, 'is_available' => true],
            ['name' => 'Soto Ayam Lamongan', 'category' => 'Makanan Berat', 'description' => 'Soto ayam bening dengan koya dan pelengkapnya.', 'image' => 'menus/soto-ayam.jpg', 'price' => 20000, 'stock' => 40, 'is_available' => true],

            // Appetizer
            ['name' => 'Lumpia Goreng', 'category' => 'Appetizer', 'description' => 'Lumpia isi rebung dan ayam, disajikan dengan saus khas.', 'image' => 'menus/lumpia.jpg', 'price' => 15000, 'stock' => 60, 'is_available' => true],
            ['name' => 'Tahu Isi Pedas', 'category' => 'Appetizer', 'description' => 'Tahu goreng dengan isian sayuran dan cabai rawit.', 'image' => 'menus/tahu-isi.jpg', 'price' => 12000, 'stock' => 70, 'is_available' => true],

            // Minuman Dingin
            ['name' => 'Es Teh Manis', 'category' => 'Minuman', 'description' => 'Teh manis disajikan dingin dengan es batu.', 'image' => 'menus/es-teh.jpg', 'price' => 5000, 'stock' => 100, 'is_available' => true],
            ['name' => 'Es Jeruk Peras', 'category' => 'Minuman', 'description' => 'Jeruk peras segar dengan es dan sedikit gula.', 'image' => 'menus/es-jeruk.jpg', 'price' => 8000, 'stock' => 100, 'is_available' => true],
            ['name' => 'Jus Alpukat', 'category' => 'Minuman', 'description' => 'Jus alpukat segar dengan susu kental manis coklat.', 'image' => 'menus/jus-alpukat.jpg', 'price' => 15000, 'stock' => 50, 'is_available' => true],

            // Kopi
            ['name' => 'Kopi Hitam', 'category' => 'Kopi', 'description' => 'Kopi hitam tubruk dari biji kopi pilihan.', 'image' => 'menus/kopi-hitam.jpg', 'price' => 10000, 'stock' => 80, 'is_available' => true],
            ['name' => 'Kopi Susu Gula Aren', 'category' => 'Kopi', 'description' => 'Espresso, susu segar, dan gula aren.', 'image' => 'menus/kopi-susu.jpg', 'price' => 18000, 'stock' => 70, 'is_available' => true],

            // Snack & Dessert
            ['name' => 'Kentang Goreng', 'category' => 'Snack', 'description' => 'Kentang goreng renyah dengan saus sambal dan mayones.', 'image' => 'menus/kentang-goreng.jpg', 'price' => 15000, 'stock' => 60, 'is_available' => true],
            ['name' => 'Roti Bakar Coklat Keju', 'category' => 'Snack', 'description' => 'Roti bakar dengan topping meses coklat dan keju parut.', 'image' => 'menus/roti-bakar.jpg', 'price' => 17000, 'stock' => 50, 'is_available' => true],
            ['name' => 'Pisang Goreng Keju', 'category' => 'Dessert', 'description' => 'Pisang goreng krispi dengan taburan keju dan susu kental manis.', 'image' => 'menus/pisang-goreng.jpg', 'price' => 16000, 'stock' => 40, 'is_available' => true],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
