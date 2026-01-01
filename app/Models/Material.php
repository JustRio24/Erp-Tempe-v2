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
        'harga_beli_terakhir',
        'satuan_beli',
        'rasio_konversi',
    ];

    protected $casts = [
        'stok_tersedia' => 'decimal:2',
        'stok_minimal' => 'decimal:2',
        'harga_beli_terakhir' => 'decimal:2',
        'rasio_konversi' => 'decimal:2',
    ];

    public function movements()
    {
        return $this->hasMany(MaterialMovement::class);
    }

    public function consumptions()
    {
        return $this->hasMany(MaterialConsumption::class);
    }

    public function addStock($jumlah, $referensi_tipe = null, $referensi_id = null, $keterangan = null, $harga_satuan = null)
    {
        $this->increment('stok_tersedia', $jumlah);
        
        return $this->movements()->create([
            'tipe' => 'masuk',
            'jumlah' => $jumlah,
            'harga_satuan' => $harga_satuan,
            'referensi_tipe' => $referensi_tipe,
            'referensi_id' => $referensi_id,
            'keterangan' => $keterangan,
        ]);
    }

    public function reduceStock($jumlah, $referensi_tipe = null, $referensi_id = null, $keterangan = null, $harga_satuan = null)
    {
        $this->decrement('stok_tersedia', $jumlah);
        
        return $this->movements()->create([
            'tipe' => 'keluar',
            'jumlah' => $jumlah,
            'harga_satuan' => $harga_satuan,
            'referensi_tipe' => $referensi_tipe,
            'referensi_id' => $referensi_id,
            'keterangan' => $keterangan,
        ]);
    }
}
