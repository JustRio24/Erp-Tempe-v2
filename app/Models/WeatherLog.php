<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherLog extends Model
{
    protected $fillable = [
        'tanggal',
        'suhu',
        'kelembaban',
        'klasifikasi',
        'notifikasi',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'notifikasi' => 'array',
    ];
}
