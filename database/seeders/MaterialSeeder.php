<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Product;
use App\Models\MaterialConsumption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Raw Materials
        $kedelai = Material::create([
            'nama' => 'Kedelai',
            'satuan' => 'kg',
            'stok_tersedia' => 1000.00, // Misal stok awal besar agar dashboard tidak langsung merah
            'stok_minimal' => 300.00, // 2 hari produksi (150kg x 2)
            'harga_beli_terakhir' => 9800,
            'satuan_beli' => 'Karung (50kg)',
            'rasio_konversi' => 50,
        ]);

        $ragi = Material::create([
            'nama' => 'Ragi',
            'satuan' => 'kg',
            'stok_tersedia' => 5.00,
            'stok_minimal' => 1.00,
            'harga_beli_terakhir' => 30000,
            'satuan_beli' => 'Pcs/Ball',
            'rasio_konversi' => 1,
        ]);

        $plastik = Material::create([
            'nama' => 'Plastik ½ kg',
            'satuan' => 'pcs',
            'stok_tersedia' => 2000.00,
            'stok_minimal' => 500.00,
            'harga_beli_terakhir' => 90, // 9000 / 100
            'satuan_beli' => 'Pack (100 lbr)',
            'rasio_konversi' => 100,
        ]);

        $daun = Material::create([
            'nama' => 'Daun Pisang',
            'satuan' => 'ikat',
            'stok_tersedia' => 100.00,
            'stok_minimal' => 20.00,
            'harga_beli_terakhir' => 7000,
            'satuan_beli' => 'Ikat',
            'rasio_konversi' => 1,
        ]);

        // 1.5 Create Historical Price Movements for Kedelai (Trend)
        $prices = [9500, 9600, 9750, 9650, 9800];
        foreach ($prices as $index => $price) {
            $kedelai->movements()->create([
                'tipe' => 'masuk',
                'jumlah' => 500,
                'harga_satuan' => $price,
                'referensi_tipe' => 'pembelian',
                'keterangan' => 'Pembelian Stok Awal ' . ($index + 1),
                'created_at' => now()->subDays((5 - $index) * 5),
            ]);
        }

        // 2. Clear then recreate Specific Products with BOM
        // Ensure products exist with correct names as per user spec
        DB::table('material_consumptions')->delete();
        
        // Find or Create specific products to apply BOM
        $keping = Product::where('nama', 'LIKE', '%Keping%')->first();
        if (!$keping) {
            $keping = Product::create([
                'nama' => 'Tempe Keping (Plastik)',
                'deskripsi' => 'Tempe bungkus plastik 250g',
                'satuan' => 'pcs',
                'harga_normal' => 3000,
                'stok_tersedia' => 0,
                'batas_kadaluarsa_hari' => 5,
                'is_active' => true,
            ]);
        }

        $batang = Product::where('nama', 'LIKE', '%Batang%')->first();
        if (!$batang) {
            $batang = Product::create([
                'nama' => 'Tempe Batang (Daun Pisang)',
                'deskripsi' => 'Tempe bungkus daun pisang silinder 2m (diukur per 20cm)',
                'satuan' => 'papan',
                'harga_normal' => 6000,
                'stok_tersedia' => 0,
                'batas_kadaluarsa_hari' => 5,
                'is_active' => true,
            ]);
        }

        // 3. Define BOM Takaran Per Produk (Acuan Mutlak)
        
        // Tempe Keping (250g)
        MaterialConsumption::create([
            'product_id' => $keping->id,
            'material_id' => $kedelai->id,
            'jumlah_konsumsi' => 0.0960, // 96 gram
        ]);
        MaterialConsumption::create([
            'product_id' => $keping->id,
            'material_id' => $ragi->id,
            'jumlah_konsumsi' => 0.0001, // 0.10 gram
        ]);
        MaterialConsumption::create([
            'product_id' => $keping->id,
            'material_id' => $plastik->id,
            'jumlah_konsumsi' => 1.0000, // 1 lembar
        ]);

        // Tempe Batang (500g - 20cm)
        MaterialConsumption::create([
            'product_id' => $batang->id,
            'material_id' => $kedelai->id,
            'jumlah_konsumsi' => 0.1920, // 192 gram
        ]);
        MaterialConsumption::create([
            'product_id' => $batang->id,
            'material_id' => $ragi->id,
            'jumlah_konsumsi' => 0.0002, // 0.20 gram
        ]);
        MaterialConsumption::create([
            'product_id' => $batang->id,
            'material_id' => $daun->id,
            'jumlah_konsumsi' => 0.0500, // 0.05 ikat
        ]);
    }
}
