<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'nama',
        'satuan',
        'stok_tersedia',
        'stok_minimal',
    ];

    protected $casts = [
        'stok_tersedia' => 'decimal:2',
        'stok_minimal' => 'decimal:2',
    ];

    public function movements()
    {
        return $this->hasMany(MaterialMovement::class);
    }

    public function consumptions()
    {
        return $this->hasMany(MaterialConsumption::class);
    }

    public function addStock($jumlah, $referensi_tipe = null, $referensi_id = null, $keterangan = null)
    {
        $this->increment('stok_tersedia', $jumlah);
        
        return $this->movements()->create([
            'tipe' => 'masuk',
            'jumlah' => $jumlah,
            'referensi_tipe' => $referensi_tipe,
            'referensi_id' => $referensi_id,
            'keterangan' => $keterangan,
        ]);
    }

    public function reduceStock($jumlah, $referensi_tipe = null, $referensi_id = null, $keterangan = null)
    {
        $this->decrement('stok_tersedia', $jumlah);
        
        return $this->movements()->create([
            'tipe' => 'keluar',
            'jumlah' => $jumlah,
            'referensi_tipe' => $referensi_tipe,
            'referensi_id' => $referensi_id,
            'keterangan' => $keterangan,
        ]);
    }
}
