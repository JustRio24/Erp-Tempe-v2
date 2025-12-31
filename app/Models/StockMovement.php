<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'product_id',
        'tipe',
        'jumlah',
        'referensi_tipe',
        'referensi_id',
        'keterangan',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopeMasuk($query)
    {
        return $query->where('tipe', 'masuk');
    }

    public function scopeKeluar($query)
    {
        return $query->where('tipe', 'keluar');
    }
}
