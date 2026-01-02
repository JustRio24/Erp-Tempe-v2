@extends('layouts.admin')

@section('title', 'Executive Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-12">

    <div
        class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#1a3c27] to-[#2E5635] shadow-2xl shadow-green-900/20 text-white p-8 md:p-12">
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-yellow-500/10 rounded-full blur-2xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <div>
                <p class="text-green-200 font-medium tracking-wide text-sm uppercase mb-2">Executive Overview</p>
                <h1 class="text-3xl md:text-4xl font-serif font-bold leading-tight">
                    Selamat Datang, {{ auth()->user()->name ?? 'Administrator' }}
                </h1>
                <p class="text-green-100/80 mt-2 max-w-xl text-lg font-light">
                    Berikut adalah laporan kinerja operasional dan finansial Tempe 3 Puteri untuk hari ini.
                </p>
            </div>
            <div
                class="bg-white/10 backdrop-blur-md border border-white/20 px-6 py-3 rounded-2xl flex items-center gap-3 shadow-lg">
                <div class="bg-green-400 w-2 h-2 rounded-full animate-pulse"></div>
                <span class="font-medium text-sm">{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
            class="bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 group hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div
                    class="p-3 bg-green-50 rounded-2xl text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Katalog</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $totalProducts }}</h3>
            <p class="text-sm text-gray-500">Produk Aktif</p>
        </div>

        <div
            class="bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 group hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div
                    class="p-3 bg-blue-50 rounded-2xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                        </path>
                    </svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Produksi</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $activeBatches->count() }}</h3>
            <p class="text-sm text-gray-500">Batch Berjalan</p>
        </div>

        <div
            class="bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 group hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div
                    class="p-3 bg-orange-50 rounded-2xl text-orange-600 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Penjualan</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $todayOrders }}</h3>
            <p class="text-sm text-gray-500">Pesanan Hari Ini</p>
        </div>

        <div
            class="bg-gradient-to-br from-gray-900 to-gray-800 p-6 rounded-3xl shadow-xl text-white group hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>

            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="p-3 bg-white/10 rounded-2xl text-yellow-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Laba Kotor</span>
            </div>
            <h3 class="text-2xl font-bold text-white mb-1 tracking-tight">Rp {{ number_format($monthlyGrossProfit, 0,
                ',', '.') }}</h3>
            <p class="text-sm text-gray-400">Akumulasi Bulan Ini</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-8">

            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 font-serif">Tren Harga Bahan Baku</h3>
                        <p class="text-sm text-gray-500">Fluktuasi harga kedelai 5 pembelian terakhir</p>
                    </div>
                    @if($kedelai)
                    <div class="px-4 py-2 bg-green-50 rounded-xl border border-green-100 text-right">
                        <p class="text-xs text-green-600 font-bold uppercase">Harga Saat Ini</p>
                        <p class="text-lg font-bold text-primary">Rp {{ number_format($kedelai->harga_beli_terakhir, 0,
                            ',', '.') }}</p>
                    </div>
                    @endif
                </div>

                <div class="h-64 w-full relative">
                    <canvas id="kedelaiChart"></canvas>
                </div>

                @php
                $latest = $kedelaiTrend->last();
                $previous = count($kedelaiTrend) > 1 ? $kedelaiTrend[count($kedelaiTrend)-2] : null;
                $avgPrice = $kedelaiTrend->avg('harga_satuan');
                @endphp

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <h4 class="text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span
                            class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-xs">✨</span>
                        AI Insight & Rekomendasi
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Status Tren</p>
                            @if(!$previous)
                            <p class="text-sm text-gray-600">Menunggu data historis lebih lanjut.</p>
                            @else
                            @php
                            $priceDiff = $latest->harga_satuan - $previous->harga_satuan;
                            $percentDiff = ($priceDiff / $previous->harga_satuan) * 100;
                            @endphp
                            @if($priceDiff > 0)
                            <div class="flex items-center gap-2 text-red-600 font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                Naik {{ round($percentDiff, 1) }}%
                            </div>
                            @elseif($priceDiff < 0) <div class="flex items-center gap-2 text-green-600 font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                </svg>
                                Turun {{ round(abs($percentDiff), 1) }}%
                        </div>
                        @else
                        <div class="flex items-center gap-2 text-blue-600 font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14">
                                </path>
                            </svg>
                            Stabil
                        </div>
                        @endif
                        @endif
                    </div>

                    <div class="p-4 rounded-2xl bg-indigo-50/50 border border-indigo-100">
                        <p class="text-xs font-bold text-indigo-400 uppercase tracking-wider mb-1">Saran Tindakan</p>
                        <p class="text-sm text-indigo-900 leading-snug">
                            @if(isset($priceDiff))
                            @if($priceDiff > 0)
                            Audit efisiensi produksi untuk menjaga margin laba.
                            @elseif($priceDiff < 0) Waktu yang tepat untuk meningkatkan stok gudang (Stockpiling). @else
                                Pertahankan level stok normal dan pantau pasar. @endif @else Data belum cukup untuk
                                memberikan saran spesifik. @endif </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900 font-serif">Rincian Keuangan</h3>
                <span class="text-xs font-medium bg-gray-100 px-3 py-1 rounded-full text-gray-500">Bulan Ini</span>
            </div>
            <div class="grid grid-cols-3 divide-x divide-gray-100">
                <div class="p-6 text-center group hover:bg-gray-50 transition">
                    <p class="text-xs font-bold text-green-600 uppercase tracking-wider mb-2">Pemasukan</p>
                    <p class="text-xl font-bold text-gray-900 group-hover:text-green-700 transition">Rp {{
                        number_format($monthlyIncome, 0, ',', '.') }}</p>
                </div>
                <div class="p-6 text-center group hover:bg-gray-50 transition">
                    <p class="text-xs font-bold text-red-600 uppercase tracking-wider mb-2">Pengeluaran</p>
                    <p class="text-xl font-bold text-gray-900 group-hover:text-red-700 transition">Rp {{
                        number_format($monthlyExpense, 0, ',', '.') }}</p>
                </div>
                <div class="p-6 text-center group hover:bg-gray-50 transition">
                    <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-2">Laba Bersih</p>
                    <p class="text-xl font-bold text-gray-900 group-hover:text-blue-700 transition">Rp {{
                        number_format($monthlyNetProfit, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

    </div>

    <div class="lg:col-span-1 space-y-6">

        <div
            class="bg-gradient-to-b from-blue-500 to-blue-600 rounded-3xl shadow-xl shadow-blue-500/20 text-white p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white/20 rounded-full blur-2xl"></div>

            <div class="relative z-10">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="font-bold text-lg">Cuaca</h3>
                        <p class="text-blue-100 text-xs">{{ config('erp.weather_city', 'Jakarta') }}</p>
                    </div>
                    <div class="text-3xl">
                        @php $todayWeather = $forecast[0] ?? null; @endphp
                        {{ $todayWeather['icon'] ?? '🌤️' }}
                    </div>
                </div>

                @if($todayWeather)
                <div class="mb-6">
                    <span class="text-4xl font-bold">{{ $todayWeather['suhu_avg'] }}°C</span>
                    <p class="text-blue-100 text-sm font-medium">{{ $todayWeather['klasifikasi'] }}</p>
                </div>
                @endif

                <div class="flex justify-between gap-2 mt-4 pt-4 border-t border-white/20">
                    @foreach(array_slice($forecast, 1, 4) as $day)
                    <div class="text-center">
                        <p class="text-[10px] text-blue-100 uppercase mb-1">{{
                            \Carbon\Carbon::parse($day['tanggal'])->format('D') }}</p>
                        <p class="text-sm">{{ $day['icon'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-bold text-gray-900 text-lg font-serif">Smart Alerts</h3>
                <span class="flex h-3 w-3 relative">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                </span>
            </div>

            <div class="space-y-4">
                @if(count($notifications) > 0)
                @foreach(array_slice($notifications, 0, 3) as $notif)
                <div class="p-3 rounded-2xl bg-white border border-gray-100 shadow-sm flex gap-3 items-start">
                    <div
                        class="w-2 h-2 rounded-full mt-2 flex-shrink-0 {{ $notif['type'] === 'danger' ? 'bg-red-500' : 'bg-yellow-500' }}">
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 leading-snug">{{ $notif['message'] }}</p>
                        @if(isset($notif['link']))
                        <a href="{{ $notif['link'] }}"
                            class="text-[10px] font-bold text-primary hover:underline mt-1 block">Tindak Lanjut →</a>
                        @endif
                    </div>
                </div>
                @endforeach
                @endif

                @if(count($inventoryAlerts) > 0)
                @foreach($inventoryAlerts as $alert)
                <div class="p-3 rounded-2xl bg-orange-50 border border-orange-100 flex gap-3 items-start">
                    <span class="text-lg">{{ $alert['icon'] ?? '📦' }}</span>
                    <div>
                        <p class="text-xs font-bold text-orange-800 mb-0.5">Stok Menipis</p>
                        <p class="text-xs text-orange-700 leading-snug">{{ $alert['message'] }}</p>
                    </div>
                </div>
                @endforeach
                @endif

                @if(count($notifications) == 0 && count($inventoryAlerts) == 0)
                <div class="text-center py-8">
                    <span class="text-4xl grayscale opacity-50">✅</span>
                    <p class="text-sm text-gray-400 mt-2">Semua sistem aman terkendali.</p>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-900">Produksi Aktif</h3>
                <a href="{{ route('admin.production.index') }}"
                    class="text-xs text-primary font-bold hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-3">
                @forelse($activeBatches->take(3) as $batch)
                <div class="flex items-center justify-between pb-3 border-b border-gray-50 last:border-0 last:pb-0">
                    <div>
                        <p class="text-xs font-bold text-gray-800">{{ $batch->kode_batch }}</p>
                        <p class="text-[10px] text-gray-400">{{ $batch->tanggal_mulai->format('d M, H:i') }}</p>
                    </div>
                    <span class="px-2 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-lg">{{ $batch->status
                        }}</span>
                </div>
                @empty
                <p class="text-xs text-gray-400 text-center py-2">Tidak ada batch aktif.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('kedelaiChart').getContext('2d');
        const labels = {!! json_encode($kedelaiTrend->map(fn($t) => $t->created_at->format('d/m'))->toArray()) !!};
        const prices = {!! json_encode($kedelaiTrend->pluck('harga_satuan')->toArray()) !!};

        // Create Gradient
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(46, 86, 53, 0.2)'); // Brand Green Opacity
        gradient.addColorStop(1, 'rgba(46, 86, 53, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Harga (Rp)',
                    data: prices,
                    borderColor: '#2E5635',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4, // Smooth Curve
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#2E5635',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#2E5635',
                    pointHoverBorderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1a3c27',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        border: { display: false },
                        grid: {
                            color: '#f3f4f6',
                            borderDash: [5, 5]
                        },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 11 },
                            color: '#9ca3af',
                            callback: function(value) {
                                return (value / 1000) + 'k';
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 11 },
                            color: '#9ca3af'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });
    });
</script>
@endsection