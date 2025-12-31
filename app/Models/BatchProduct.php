<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchProduct extends Model
{
    protected $fillable = [
        'production_batch_id',
        'product_id',
        'jumlah',
    ];

    // Relationships
    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
