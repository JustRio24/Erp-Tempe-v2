@extends('layouts.admin')

@section('title', 'Detail Batch ' . $production->kode_batch)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">

    <div class="flex items-center gap-2 mb-6 text-sm text-gray-500 overflow-x-auto whitespace-nowrap pb-2">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.production.index') }}" class="hover:text-primary transition-colors">Produksi</a>
        <span>/</span>
        <span class="text-gray-900 font-bold tracking-wide">{{ $production->kode_batch }}</span>
    </div>

    <div
        class="bg-white rounded-3xl shadow-xl shadow-gray-200/60 border border-gray-100 p-6 md:p-8 mb-8 relative overflow-hidden group">
        <div
            class="absolute top-0 right-0 w-64 h-64 bg-green-50/50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none transition-transform group-hover:scale-110 duration-700">
        </div>

        <div class="relative z-10 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">

            <div>
                <div class="flex flex-wrap items-center gap-3 mb-2">
                    <h1 class="text-2xl md:text-3xl font-serif font-bold text-gray-900 tracking-tight">{{
                        $production->kode_batch }}</h1>

                    @php
                    $statusStyles = match($production->status) {
                    'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                    'processing' => 'bg-blue-50 text-blue-700 border-blue-100',
                    'completed' => 'bg-green-50 text-green-700 border-green-100',
                    'failed' => 'bg-red-50 text-red-700 border-red-100',
                    default => 'bg-gray-50 text-gray-700 border-gray-100'
                    };
                    $statusIcon = match($production->status) {
                    'pending' => '⏳',
                    'processing' => '⚙️',
                    'completed' => '✅',
                    'failed' => '❌',
                    default => '📄'
                    };
                    @endphp
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase border {{ $statusStyles }}">
                        <span class="mr-1">{{ $statusIcon }}</span> {{ $production->status }}
                    </span>
                </div>
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Mulai: {{ $production->tanggal_mulai->format('d M Y') }}
                    </span>
                    @if($production->status !== 'Selesai')
                    <span class="flex items-center gap-1 text-orange-500 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Est. Panen: {{ $production->tanggal_mulai->addDays(4)->format('d M') }}
                    </span>
                    @endif
                </div>
            </div>

            @if($production->status !== 'Selesai')
            <div class="w-full lg:w-1/3 bg-white/80 p-4 rounded-2xl border border-gray-100 backdrop-blur-sm">
                <div class="flex justify-between text-xs font-bold text-gray-500 mb-2 uppercase tracking-wide">
                    <span>Fermentasi</span>
                    <span>Hari {{ $production->hari_ke }} dari 4</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                    @php $progress = min(100, ($production->hari_ke / 4) * 100); @endphp
                    <div class="bg-gradient-to-r from-blue-500 to-blue-400 h-3 rounded-full transition-all duration-1000 ease-out shadow-sm relative"
                        style="width: {{ $progress }}%">
                        <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                    </div>
                </div>
            </div>
            @else
            <div
                class="bg-green-50/80 px-6 py-3 rounded-2xl border border-green-100 text-green-800 flex items-center gap-3">
                <span class="text-2xl">🎉</span>
                <div>
                    <p class="font-bold text-sm">Produksi Selesai</p>
                    <p class="text-xs">Stok telah ditambahkan ke gudang.</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-8">

            @if($production->status !== 'Selesai' && $production->status !== 'Gagal')
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <h3 class="font-bold text-gray-900">Kontrol Harian</h3>
                </div>

                <div class="p-6">
                    <div class="flex items-start gap-4 mb-6 bg-blue-50 p-4 rounded-xl border border-blue-100">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-bold">Status Saat Ini: Hari ke-{{ $production->hari_ke }}</p>
                            <p class="text-blue-600 mt-1 text-xs leading-relaxed">Pastikan kondisi suhu dan kelembaban
                                ruang fermentasi stabil. Update status setiap hari atau selesaikan jika tempe sudah
                                matang.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @if($production->hari_ke < 4) <form
                            action="{{ route('admin.production.advance', $production) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="group w-full py-4 px-4 bg-white border-2 border-dashed border-gray-300 text-gray-600 font-bold rounded-xl hover:border-blue-500 hover:text-blue-600 hover:bg-blue-50 transition-all flex flex-col items-center justify-center gap-2">
                                <span class="text-2xl group-hover:scale-110 transition-transform">⏩</span>
                                <span>Lanjut Hari {{ $production->hari_ke + 1 }}</span>
                            </button>
                            </form>
                            @endif

                            @if($production->hari_ke >= 3)
                            <form id="complete-batch-form"
                                action="{{ route('admin.production.complete', $production) }}" method="POST">
                                @csrf
                                <button type="button" onclick="handleComplete()"
                                    class="group w-full py-4 px-4 bg-gradient-to-br from-green-500 to-green-600 text-white font-bold rounded-xl shadow-lg shadow-green-500/30 hover:shadow-green-500/50 transition-all transform hover:-translate-y-1 flex flex-col items-center justify-center gap-2">
                                    <span class="text-2xl group-hover:rotate-12 transition-transform">🌾</span>
                                    <span>Panen & Selesai</span>
                                </button>
                            </form>
                            @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    Catat Produk Gagal (Rusak/Busuk)
                </h4>
                <form action="{{ route('admin.production.record-failure', $production) }}" method="POST"
                    class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <div class="flex-1">
                        <select name="product_id"
                            class="w-full rounded-xl border-gray-200 text-sm focus:border-red-500 focus:ring-red-500 bg-gray-50 py-2.5"
                            required>
                            <option value="" disabled selected>-- Pilih Produk --</option>
                            @foreach($production->products as $prod)
                            <option value="{{ $prod->id }}">{{ $prod->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full sm:w-32">
                        <input type="number" name="jumlah"
                            class="w-full rounded-xl border-gray-200 text-sm focus:border-red-500 focus:ring-red-500 bg-gray-50 py-2.5"
                            placeholder="Jumlah" required min="1">
                    </div>
                    <button type="submit"
                        class="px-5 py-2.5 bg-white border border-red-200 text-red-600 font-bold rounded-xl hover:bg-red-50 transition text-sm shadow-sm">
                        Simpan
                    </button>
                </form>
            </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="font-bold text-gray-900">Rincian Output</h3>
                    <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded">Real-time</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Produk</th>
                                <th class="px-6 py-4 text-center">Target</th>
                                <th class="px-6 py-4 text-center text-red-500">Gagal</th>
                                <th class="px-6 py-4 text-right">Hasil Netto</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($production->products as $item)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $item->nama }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-block bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-bold">{{
                                        $item->pivot->jumlah }} {{ $item->satuan }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($item->pivot->jumlah_gagal > 0)
                                    <span class="text-red-600 font-bold bg-red-50 px-2 py-1 rounded text-xs">- {{
                                        $item->pivot->jumlah_gagal }}</span>
                                    @else
                                    <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @php $netto = max(0, $item->pivot->jumlah - ($item->pivot->jumlah_gagal ?? 0));
                                    @endphp
                                    <span
                                        class="font-bold text-lg {{ $production->status === 'Selesai' ? 'text-green-600' : 'text-gray-400' }}">
                                        {{ $netto }} <span class="text-xs font-normal">{{ $item->satuan }}</span>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="lg:col-span-1 space-y-6">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Ringkasan Batch</h4>
                <ul class="space-y-4">
                    <li class="flex justify-between items-center pb-3 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Total Target</span>
                        <span class="text-sm font-bold text-gray-900">{{ $production->jumlah_target }} Unit</span>
                    </li>
                    <li class="flex justify-between items-center pb-3 border-b border-gray-50">
                        <span class="text-sm text-gray-500">Total Gagal</span>
                        <span class="text-sm font-bold text-red-500">{{ $production->jumlah_gagal }} Unit</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Hasil Bersih</span>
                        <span class="text-lg font-bold text-primary">{{ $production->jumlah_target -
                            $production->jumlah_gagal }} Unit</span>
                    </li>
                </ul>
            </div>

            <div class="bg-yellow-50 rounded-2xl border border-yellow-100 p-6 relative">
                <svg class="w-8 h-8 text-yellow-200 absolute top-4 right-4" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M11 17h2v-6h-2v6zm1-15C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zM11 9h2V7h-2v2z">
                    </path>
                </svg>
                <h4 class="text-xs font-bold text-yellow-800 uppercase tracking-wide mb-2">Catatan</h4>
                <p class="text-sm text-yellow-900 italic leading-relaxed">
                    "{{ $production->catatan ?: 'Tidak ada catatan khusus.' }}"
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-6">Riwayat Aktivitas</h4>

                <div class="relative space-y-6 pl-2">
                    <div class="absolute left-[7px] top-2 bottom-2 w-0.5 bg-gray-100"></div>

                    @foreach($production->stockMovements->sortByDesc('created_at')->take(5) as $move)
                    <div class="flex gap-4 relative z-10">
                        <div
                            class="flex-shrink-0 w-4 h-4 rounded-full border-2 border-white shadow-sm mt-1 {{ $move->tipe == 'masuk' ? 'bg-green-500' : 'bg-red-500' }}">
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 mb-0.5">{{ $move->created_at->format('d M H:i') }}</p>
                            <p class="text-sm font-bold text-gray-800">{{ ucfirst($move->tipe) }} Stok</p>
                            <p class="text-xs text-gray-600 mt-0.5">{{ $move->product->nama }} <span
                                    class="font-mono font-bold">({{ $move->jumlah }})</span></p>
                        </div>
                    </div>
                    @endforeach

                    <div class="flex gap-4 relative z-10">
                        <div
                            class="flex-shrink-0 w-4 h-4 rounded-full bg-blue-500 border-2 border-white shadow-sm mt-1">
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 mb-0.5">{{ $production->created_at->format('d M H:i') }}
                            </p>
                            <p class="text-sm font-bold text-gray-800">Batch Dibuat</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    async function handleComplete() {
        const result = await Swal.fire({
            title: 'Panen Sekarang?',
            text: "Status akan berubah menjadi Selesai. Stok produk akan otomatis ditambahkan ke gudang sesuai hasil netto.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10B981',
            cancelButtonColor: '#EF4444',
            confirmButtonText: 'Ya, Panen & Selesai!',
            cancelButtonText: 'Batal',
            background: '#fff',
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl px-5 py-2.5',
                cancelButton: 'rounded-xl px-5 py-2.5'
            }
        });

        if (result.isConfirmed) {
            document.getElementById('complete-batch-form').submit();
        }
    }
</script>
@endpush