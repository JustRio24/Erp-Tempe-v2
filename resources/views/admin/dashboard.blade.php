@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1 style="color: var(--primary); margin-bottom: 0.5rem;">Dashboard Admin</h1>
    <p style="color: #666;">Selamat datang di sistem ERP Tempe 3 Puteri</p>
</div>

<!-- Statistics -->
<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ $totalProducts }}</h3>
        <p>Total Produk Aktif</p>
    </div>
    <div class="stat-card">
        <h3>{{ $activeBatches->count() }}</h3>
        <p>Batch Produksi Aktif</p>
    </div>
    <div class="stat-card">
        <h3>{{ $todayOrders }}</h3>
        <p>Pesanan Hari Ini</p>
    </div>
    <div class="stat-card">
        <h3>Rp {{ number_format($monthlyGrossProfit, 0, ',', '.') }}</h3>
        <p>Laba Kotor Bulan Ini</p>
        <small style="color: #666;">(Setelah potong HPP Bahan)</small>
    </div>
</div>

<!-- Notifications -->
@if(count($notifications) > 0)
<div class="card">
    <div class="card-header">
        <h3>Notifikasi & Peringatan</h3>
    </div>
    @foreach($notifications as $notif)
        <div class="alert alert-{{ $notif['type'] === 'danger' ? 'error' : $notif['type'] }}" style="margin-bottom: 0.5rem;">
            {{ $notif['message'] }}
            @if(isset($notif['link']))
                - <a href="{{ $notif['link'] }}" style="font-weight: 600;">Lihat Detail</a>
            @endif
        </div>
    @endforeach
</div>
@endif

<!-- Weather & Decision Support -->
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>🌦️ Prakiraan Cuaca & Rekomendasi</h3>
        <span style="font-size: 0.875rem; color: #666;">Lokasi: {{ config('erp.weather_city', 'Jakarta') }}</span>
    </div>

    <!-- Weather Cards -->
    <div class="grid grid-4" style="margin-bottom: 2rem;">
        @foreach(array_slice($forecast, 0, 7) as $day)
            <div style="text-align: center; padding: 1rem; background: #f9fafb; border-radius: 8px; border: 1px solid #eee; position: relative;">
                <div style="font-size: 2.25rem; margin-bottom: 0.5rem;">{{ $day['icon'] }}</div>
                <div style="font-weight: 600; font-size: 0.875rem; color: #444;">{{ $day['tanggal_singkat'] }}</div>
                <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">{{ $day['suhu_avg'] }}°C</div>
                
                @php
                    $badgeColor = match($day['klasifikasi']) {
                        'Panas' => '#F44336',
                        'Dingin / Lembab' => '#2196F3',
                        'Normal' => '#4CAF50',
                        default => '#9E9E9E'
                    };
                @endphp
                <span style="font-size: 0.75rem; color: {{ $badgeColor }}; font-weight: 600; text-transform: uppercase;">
                    {{ $day['klasifikasi'] }}
                </span>
            </div>
        @endforeach
    </div>

    <!-- Decision Support Notifications -->
    @if(count($weatherRecommendations) > 0)
        <div style="background: #fff8e1; border-radius: 12px; padding: 1.5rem; border-left: 5px solid #ffc107;">
            <h4 style="margin-bottom: 1rem; color: #856404; display: flex; align-items: center; gap: 0.5rem;">
                💡 Rekomendasi & Peringatan Cuaca
            </h4>
            <div class="grid grid-2" style="gap: 1rem;">
                @foreach($weatherRecommendations as $rec)
                    <div style="display: flex; gap: 0.75rem; padding: 0.75rem; background: rgba(255,255,255,0.7); border-radius: 8px; border: 1px solid rgba(0,0,0,0.05);">
                        <div style="font-size: 1.25rem;">{{ $rec['icon'] ?? 'ℹ️' }}</div>
                        <div style="font-size: 0.9375rem; line-height: 1.4; color: #444;">
                            {{ $rec['message'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 1.5rem; background: #f1f8e9; border-radius: 12px; color: #388e3c;">
            ✅ Cuaca stabil. Tidak ada peringatan khusus untuk produksi hari ini.
        </div>
    @endif

    @if(count($inventoryAlerts) > 0)
        <div style="margin-top: 1rem; background: #e0f2f1; border-radius: 12px; padding: 1.5rem; border-left: 5px solid #009688;">
            <h4 style="margin-bottom: 1rem; color: #00796b; display: flex; align-items: center; gap: 0.5rem;">
                📊 Manajemen Inventori (Smart Alert)
            </h4>
            <div class="grid grid-2" style="gap: 1rem;">
                @foreach($inventoryAlerts as $alert)
                    <div style="display: flex; gap: 0.75rem; padding: 0.75rem; background: rgba(255,255,255,0.7); border-radius: 8px; border: 1px solid rgba(0,0,0,0.05);">
                        <div style="font-size: 1.25rem;">{{ $alert['icon'] ?? 'ℹ️' }}</div>
                        <div style="font-size: 0.9375rem; line-height: 1.4; color: #444;">
                            {{ $alert['message'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<!-- Recent Stats Grid -->
<div class="grid grid-2">
    <!-- Stock Alerts -->
    <div class="card">
        <div class="card-header">
            <h3>Peringatan Stok</h3>
        </div>
        @if($lowStockProducts->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Stok</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockProducts->take(5) as $product)
                        <tr>
                            <td>{{ $product->nama }}</td>
                            <td>{{ $product->stok_tersedia }} {{ $product->satuan }}</td>
                            <td>
                                <span class="badge" style="background: {{ $product->stok_tersedia == 0 ? '#F44336' : '#FF9800' }}; padding: 0.25rem 0.75rem; border-radius: 12px; color: white;">
                                    {{ $product->checkStockStatus() }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color: #666; text-align: center; padding: 2rem;">Semua produk stok aman</p>
        @endif
    </div>

    <!-- Active Batches -->
    <div class="card">
        <div class="card-header">
            <h3>Batch Produksi Aktif</h3>
        </div>
        @if($activeBatches->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode Batch</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activeBatches->take(5) as $batch)
                        <tr>
                            <td>{{ $batch->kode_batch }}</td>
                            <td>{{ $batch->status }}</td>
                            <td>{{ $batch->tanggal_mulai->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color: #666; text-align: center; padding: 2rem;">Tidak ada batch aktif</p>
        @endif
    </div>
</div>

<!-- Financial Summary -->
<div class="card">
    <div class="card-header">
        <h3>Ringkasan Keuangan Bulan Ini</h3>
    </div>
    <div class="grid grid-3">
        <div style="text-align: center; padding: 1.5rem; background: #E8F5E9; border-radius: 8px;">
            <div style="font-size: 0.875rem; color: #2E7D32; margin-bottom: 0.5rem;">Pemasukan</div>
            <div style="font-size: 1.75rem; font-weight: 700; color: #2E7D32;">
                Rp {{ number_format($monthlyIncome, 0, ',', '.') }}
            </div>
        </div>
        <div style="text-align: center; padding: 1.5rem; background: #FFEBEE; border-radius: 8px;">
            <div style="font-size: 0.875rem; color: #C62828; margin-bottom: 0.5rem;">Pengeluaran</div>
            <div style="font-size: 1.75rem; font-weight: 700; color: #C62828;">
                Rp {{ number_format($monthlyExpense, 0, ',', '.') }}
            </div>
        </div>
        <div style="text-align: center; padding: 1.5rem; background: #FFF3E0; border-radius: 8px;">
            <div style="font-size: 0.875rem; color: #E65100; margin-bottom: 0.5rem;">Laba Kotor</div>
            <div style="font-size: 1.75rem; font-weight: 700; color: #E65100;">
                Rp {{ number_format($monthlyGrossProfit, 0, ',', '.') }}
            </div>
            <div style="font-size: 0.75rem; color: #666; margin-top: 0.25rem;">Margin: {{ $monthlyIncome > 0 ? round(($monthlyGrossProfit / $monthlyIncome) * 100, 1) : 0 }}%</div>
        </div>
        <div style="text-align: center; padding: 1.5rem; background: #E3F2FD; border-radius: 8px;">
            <div style="font-size: 0.875rem; color: #1565C0; margin-bottom: 0.5rem;">Laba Bersih</div>
            <div style="font-size: 1.75rem; font-weight: 700; color: #1565C0;">
                Rp {{ number_format($monthlyNetProfit, 0, ',', '.') }}
            </div>
            <div style="font-size: 0.75rem; color: #666; margin-top: 0.25rem;">(Setelah Operasional)</div>
        </div>
    </div>
</div>
<div class="card" style="margin-top: 2rem;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>📈 Tren Harga Kedelai (5 Pembelian Terakhir)</h3>
        @php
            $latest = $kedelaiTrend->last();
            $previous = count($kedelaiTrend) > 1 ? $kedelaiTrend[count($kedelaiTrend)-2] : null;
            $avgPrice = $kedelaiTrend->avg('harga_satuan');
        @endphp
        @if($latest && $kedelai)
            <div style="font-weight: 600; font-size: 0.9rem;">
                Harga Sekarang: <span style="color: var(--primary);">Rp {{ number_format($kedelai->harga_beli_terakhir, 0, ',', '.') }}</span>
            </div>
        @endif
    </div>
    <div class="grid grid-2" style="gap: 2rem; padding: 1.5rem;">
        <!-- Chart Section -->
        <div>
            <canvas id="kedelaiChart" height="200"></canvas>
        </div>

        <!-- Rule Based Insight Section -->
        <div style="display: flex; flex-direction: column; justify-content: center; gap: 1rem;">
            <div style="padding: 1rem; border-radius: 12px; border: 1px solid #eee; background: #fff;">
                <h4 style="margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    💡 Analisis Strategis
                </h4>
                
                @if(!$previous)
                    <p style="color: #666; font-size: 0.875rem;">Data historis belum cukup untuk analisis tren (minimal 2 pembelian).</p>
                @else
                    @php
                        $priceDiff = $latest->harga_satuan - $previous->harga_satuan;
                        $percentDiff = ($priceDiff / $previous->harga_satuan) * 100;
                    @endphp

                    <div style="font-size: 0.95rem; line-height: 1.6;">
                        @if($priceDiff > 0)
                            <p style="color: #d32f2f;">
                                ⚠️ <strong>Harga Naik!</strong> Terjadi kenaikan sebasar {{ round($percentDiff, 1) }}% dibanding terakhir. 
                                <br><span style="font-size: 0.85rem; color: #666;">Saran: Audit efisiensi produksi dan pertimbangkan penyesuaian harga jual jika tren terus naik.</span>
                            </p>
                        @elseif($priceDiff < 0)
                            <p style="color: #388e3c;">
                                ✅ <strong>Harga Turun!</strong> Harga lebih murah {{ round(abs($percentDiff), 1) }}% dari sebelumnya.
                                <br><span style="font-size: 0.85rem; color: #666;">Saran: <strong>"Masa Stok"</strong>. Rekomendasi belanja lebih banyak untuk mengamankan modal HPP.</span>
                            </p>
                        @else
                            <p style="color: #1565c0;">
                                ℹ️ <strong>Harga Stabil.</strong> Tidak ada perubahan harga dari pembelian terakhir.
                                <br><span style="font-size: 0.85rem; color: #666;">Saran: Tetap pantau ketersediaan stok Kedelai Anda.</span>
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div style="padding: 1rem; border-radius: 12px; background: #f8f9fa; border: 1px dashed #ced4da;">
                <div style="font-size: 0.8rem; color: #666; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Rata-rata Harga</div>
                <div style="font-size: 1.25rem; font-weight: 700; color: #495057;">Rp {{ number_format($avgPrice, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('kedelaiChart').getContext('2d');
        const labels = {!! json_encode($kedelaiTrend->map(fn($t) => $t->created_at->format('d/m'))->toArray()) !!};
        const prices = {!! json_encode($kedelaiTrend->pluck('harga_satuan')->toArray()) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Harga Kedelai (Rp)',
                    data: prices,
                    borderColor: '#1E88E5',
                    backgroundColor: 'rgba(30, 136, 229, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#1E88E5',
                    pointRadius: 5,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>

@endsection
