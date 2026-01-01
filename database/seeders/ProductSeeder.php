<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'nama' => 'Tempe Keping (Plastik)',
                'deskripsi' => 'Tempe bungkus plastik (250g), ukuran 12x8x3 cm',
                'satuan' => 'pcs',
                'harga_normal' => 3000,
                'harga_grosir' => 2500,
                'minimal_grosir' => 10,
                'stok_tersedia' => 0,
                'batas_kadaluarsa_hari' => 5,
                'is_active' => true,
            ],
            [
                'nama' => 'Tempe Batang (Daun Pisang)',
                'deskripsi' => 'Tempe bungkus daun pisang (500g - 20cm), ukuran 20x4x3 cm',
                'satuan' => 'pcs',
                'harga_normal' => 6000,
                'harga_grosir' => 5500,
                'minimal_grosir' => 5,
                'stok_tersedia' => 0,
                'batas_kadaluarsa_hari' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
