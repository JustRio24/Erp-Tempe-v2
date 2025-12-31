<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialMovement extends Model
{
    protected $fillable = [
        'material_id',
        'tipe',
        'jumlah',
        'referensi_tipe',
        'referensi_id',
        'keterangan',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
