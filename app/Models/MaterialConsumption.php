<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialConsumption extends Model
{
    protected $table = 'material_consumptions';

    protected $fillable = [
        'product_id',
        'material_id',
        'jumlah_konsumsi',
    ];

    protected $casts = [
        'jumlah_konsumsi' => 'decimal:4',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
