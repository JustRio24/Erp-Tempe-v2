<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialRecord extends Model
{
    protected $fillable = [
        'tanggal',
        'tipe',
        'kategori',
        'jumlah',
        'deskripsi',
        'referensi_tipe',
        'referensi_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];

    // Scopes
    public function scopePemasukan($query)
    {
        return $query->where('tipe', 'pemasukan');
    }

    public function scopePengeluaran($query)
    {
        return $query->where('tipe', 'pengeluaran');
    }

    public function scopeByMonth($query, $year, $month)
    {
        return $query->whereYear('tanggal', $year)
                     ->whereMonth('tanggal', $month);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal', [$startDate, $endDate]);
    }

    // Helper methods
    public static function getTotalPemasukan($startDate = null, $endDate = null)
    {
        $query = self::pemasukan();
        
        if ($startDate && $endDate) {
            $query->byDateRange($startDate, $endDate);
        }
        
        return $query->sum('jumlah');
    }

    public static function getTotalPengeluaran($startDate = null, $endDate = null)
    {
        $query = self::pengeluaran();
        
        if ($startDate && $endDate) {
            $query->byDateRange($startDate, $endDate);
        }
        
        return $query->sum('jumlah');
    }

    public static function getLabaRugi($startDate = null, $endDate = null)
    {
        $pemasukan = self::getTotalPemasukan($startDate, $endDate);
        $pengeluaran = self::getTotalPengeluaran($startDate, $endDate);
        
        return $pemasukan - $pengeluaran;
    }
}
