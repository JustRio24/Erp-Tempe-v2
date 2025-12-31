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
                'nama' => 'Tempe Kedelai Murni 500g',
                'deskripsi' => 'Tempe kedelai premium tanpa campuran, sangat cocok untuk lauk sehari-hari',
                'satuan' => 'pcs',
                'harga_normal' => 12000,
                'harga_grosir' => 10000,
                'minimal_grosir' => 10,
                'stok_tersedia' => 50,
                'batas_kadaluarsa_hari' => 5,
                'is_active' => true,
            ],
            [
                'nama' => 'Tempe Kedelai Hitam 500g',
                'deskripsi' => 'Tempe dari kedelai hitam pilihan, lebih gurih dan bergizi',
                'satuan' => 'pcs',
                'harga_normal' => 15000,
                'harga_grosir' => 13000,
                'minimal_grosir' => 10,
                'stok_tersedia' => 30,
                'batas_kadaluarsa_hari' => 5,
                'is_active' => true,
            ],
            [
                'nama' => 'Tempe Gembus 300g',
                'deskripsi' => 'Tempe dari ampas tahu, ekonomis dan lezat',
                'satuan' => 'pcs',
                'harga_normal' => 8000,
                'harga_grosir' => 7000,
                'minimal_grosir' => 15,
                'stok_tersedia' => 40,
                'batas_kadaluarsa_hari' => 4,
                'is_active' => true,
            ],
            [
                'nama' => 'Tempe Kacang Merah 400g',
                'deskripsi' => 'Tempe unik dari kacang merah, cocok untuk variasi menu',
                'satuan' => 'pcs',
                'harga_normal' => 14000,
                'harga_grosir' => 12000,
                'minimal_grosir' => 10,
                'stok_tersedia' => 25,
                'batas_kadaluarsa_hari' => 5,
                'is_active' => true,
            ],
            [
                'nama' => 'Tempe Daun Pisang 1 Papan',
                'deskripsi' => 'Tempe tradisional dibungkus daun pisang untuk aroma khas',
                'satuan' => 'papan',
                'harga_normal' => 20000,
                'harga_grosir' => 18000,
                'minimal_grosir' => 5,
                'stok_tersedia' => 15,
                'batas_kadaluarsa_hari' => 5,
                'is_active' => true,
            ],
            [
                'nama' => 'Tempe Mendoan (Siap Goreng) 250g',
                'deskripsi' => 'Tempe sudah dipotong tipis, siap untuk digoreng mendoan',
                'satuan' => 'pcs',
                'harga_normal' => 10000,
                'harga_grosir' => null,
                'minimal_grosir' => null,
                'stok_tersedia' => 20,
                'batas_kadaluarsa_hari' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
