<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductionBatch extends Model
{
    protected $table = 'production_batches';

    protected $fillable = [
        'kode_batch',
        'tanggal_mulai',
        'hari_ke',
        'status',
        'jumlah_target',
        'jumlah_jadi',
        'jumlah_gagal',
        'catatan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($batch) {
            if (empty($batch->kode_batch)) {
                $batch->kode_batch = static::generateKodeBatch();
            }
        });
    }

    public static function generateKodeBatch()
    {
        $date = now()->format('Ymd');
        $count = static::whereDate('created_at', today())->count() + 1;
        return 'BATCH-' . $date . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    // Relationships
    public function products()
    {
        return $this->belongsToMany(Product::class, 'batch_products')
            ->withPivot('jumlah')
            ->withTimestamps();
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class, 'referensi_id')
            ->where('referensi_tipe', 'produksi');
    }

    // Helper methods
    public function advanceDay()
    {
        if ($this->hari_ke < 4) {
            $this->hari_ke++;
            $statuses = ['Hari ke-1', 'Hari ke-2', 'Hari ke-3', 'Siap dijual'];
            $this->status = $statuses[$this->hari_ke - 1];
            $this->save();
        }
   }

    public function complete()
    {
        $this->status = 'Selesai';
        $this->save();
        
        // Update stock for each product in the batch
        foreach ($this->products as $product) {
            $jumlah = $product->pivot->jumlah;
            $product->increment('stok_tersedia', $jumlah);
            
            // Record stock movement
            StockMovement::create([
                'product_id' => $product->id,
                'tipe' => 'masuk',
                'jumlah' => $jumlah,
                'referensi_tipe' => 'produksi',
                'referensi_id' => $this->id,
                'keterangan' => 'Hasil produksi batch ' . $this->kode_batch,
            ]);
        }
    }

    public function recordFailure($product_id, $jumlah)
    {
        $this->increment('jumlah_gagal', $jumlah);
    }
}
