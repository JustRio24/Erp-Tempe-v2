<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'satuan',
        'harga_normal',
        'harga_grosir',
        'minimal_grosir',
        'stok_tersedia',
        'batas_kadaluarsa_hari',
        'gambar',
        'is_active',
    ];

    protected $casts = [
        'harga_normal' => 'decimal:2',
        'harga_grosir' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function productionBatches()
    {
        return $this->belongsToMany(ProductionBatch::class, 'batch_products')
            ->withPivot('jumlah')
            ->withTimestamps();
    }

    // Helper methods
    public function updateStock($jumlah)
    {
        $this->increment('stok_tersedia', $jumlah);
    }

    public function checkStockStatus()
    {
        $threshold = config('erp.stock_warning_threshold', 10);
        
        if ($this->stok_tersedia == 0) {
            return 'habis';
        } elseif ($this->stok_tersedia <= $threshold) {
            return 'menipis';
        }
        
        return 'aman';
    }

    public function getHargaByJumlah($jumlah)
    {
        if ($this->harga_grosir && $this->minimal_grosir && $jumlah >= $this->minimal_grosir) {
            return $this->harga_grosir;
        }
        
        return $this->harga_normal;
    }
}
