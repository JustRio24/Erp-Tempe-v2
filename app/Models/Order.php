<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'nomor_pesanan',
        'nama_pembeli',
        'email_pembeli',
        'telepon_pembeli',
        'alamat_pembeli',
        'metode_pembayaran',
        'bank_tujuan',
        'metode_pengiriman',
        'total_item',
        'subtotal',
        'ongkir',
        'total',
        'status',
        'catatan',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'ongkir' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            if (empty($order->nomor_pesanan)) {
                $order->nomor_pesanan = static::generateNomorPesanan();
            }
        });
    }

    public static function generateNomorPesanan()
    {
        $date = now()->format('Ymd');
        $count = static::whereDate('created_at', today())->count() + 1;
        return 'ORD-' . $date . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    // Relationships
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function financialRecords()
    {
        return $this->hasMany(FinancialRecord::class, 'referensi_id')
            ->where('referensi_tipe', 'order');
    }

    // Helper methods
    public function calculateTotal()
    {
        $this->subtotal = $this->items->sum('subtotal');
        $this->total = $this->subtotal + $this->ongkir;
        $this->total_item = $this->items->sum('jumlah');
        $this->save();
    }

    public function updateStatus($newStatus)
    {
        $this->status = $newStatus;
        $this->save();
        
        // Record income when order is completed
        if ($newStatus === 'selesai') {
            $this->recordToFinance();
        }
    }

    public function recordToFinance()
    {
        // Check if already recorded
        if ($this->financialRecords()->exists()) {
            return;
        }
        
        FinancialRecord::create([
            'tanggal' => today(),
            'tipe' => 'pemasukan',
            'kategori' => 'Penjualan',
            'jumlah' => $this->total,
            'deskripsi' => 'Penjualan dari pesanan ' . $this->nomor_pesanan,
            'referensi_tipe' => 'order',
            'referensi_id' => $this->id,
        ]);
    }

    public function reduceStock()
    {
        foreach ($this->items as $item) {
            $product = $item->product;
            $product->decrement('stok_tersedia', $item->jumlah);
            
            // Record stock movement
            StockMovement::create([
                'product_id' => $product->id,
                'tipe' => 'keluar',
                'jumlah' => $item->jumlah,
                'referensi_tipe' => 'penjualan',
                'referensi_id' => $this->id,
                'keterangan' => 'Penjualan pesanan ' . $this->nomor_pesanan,
            ]);
        }
    }
}
