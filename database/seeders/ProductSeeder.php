<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            Product::create([
                'product_name' => 'lorem ipsum',
                'harga' => rand(50000, 100000),
                'diskon' => 0,
                'bahan' => 'lorem ipsum',
                'tags' => 'lorem ipsum',
                'sku' => Str::random(8),
                'ukuran' => 'S,M,L,XL',
                'warna' => 'Hitam, Merah, Kuning, Biru, Hijau',
                'deskripsi' => 'lorem ipsum',
                'gambar' => 'shop_item_' . $i . '.jpg',
            ]);
        }
    }
}
