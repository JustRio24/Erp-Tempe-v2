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
        <h3>Rp {{ number_format($monthlyProfit, 0, ',', '.') }}</h3>
        <p>Laba Bulan Ini</p>
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

<!-- Weather Forecast -->
<div class="card">
    <div class="card-header">
        <h3>Prakiraan Cuaca 7 Hari</h3>
    </div>
    <div class="grid grid-4" style="margin-bottom: 1.5rem;">
        @foreach(array_slice($forecast, 0, 7) as $day)
            <div style="text-align: center; padding: 1rem; background: #f9fafb; border-radius: 8px;">
                <div style="font-size: 2rem; margin-bottom: 0.5rem;">{{ $day['icon'] }}</div>
                <div style="font-weight: 600; margin-bottom: 0.25rem;">{{ $day['tanggal_singkat'] }}</div>
                <div style="font-size: 1.5rem; color: var(--primary); margin-bottom: 0.25rem;">{{ $day['suhu_avg'] }}°C</div>
                <div style="font-size: 0.875rem; color: #666;">{{ $day['klasifikasi'] }}</div>
            </div>
        @endforeach
    </div>

    @if(count($recommendations) > 0)
        <h4 style="margin-bottom: 1rem;">Rekomendasi Produksi</h4>
        @foreach($recommendations as $rec)
            <div class="alert alert-{{ $rec['type'] }}" style="margin-bottom: 0.5rem;">
                {{ $rec['message'] }}
            </div>
        @endforeach
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
        <div style="text-align: center; padding: 1.5rem; background: #E3F2FD; border-radius: 8px;">
            <div style="font-size: 0.875rem; color: #1565C0; margin-bottom: 0.5rem;">Laba Bersih</div>
            <div style="font-size: 1.75rem; font-weight: 700; color: #1565C0;">
                Rp {{ number_format($monthlyProfit, 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>
@endsection
