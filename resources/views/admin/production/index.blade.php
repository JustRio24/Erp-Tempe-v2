@extends('layouts.admin')

@section('title', 'Lantai Produksi')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-serif font-bold text-gray-900 tracking-tight">Lantai Produksi</h2>
            <p class="text-sm text-gray-500 mt-2 font-medium">Monitoring siklus fermentasi dan output harian.</p>
        </div>
        <a href="{{ route('admin.production.create') }}"
            class="px-6 py-3 bg-[#1e4329] hover:bg-[#163320] text-white font-bold rounded-xl shadow-lg shadow-green-900/20 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            Mulai Batch Baru
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div
            class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between h-full relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Aktif</p>
                <p class="text-3xl font-bold text-gray-900">{{ $batches->where('status', '!=', 'Selesai')->count() }}
                </p>
            </div>
            <div class="mt-4 flex items-center gap-2 text-xs font-medium text-blue-600">
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span> Sedang Berjalan
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-600 text-xl">⏳
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Menunggu</p>
                <p class="text-xl font-bold text-gray-900">{{ $batches->where('status', 'Pending')->count() }} Batch</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-xl">⚙️
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Proses</p>
                <p class="text-xl font-bold text-gray-900">{{ $batches->where('status', 'Proses')->count() }} Batch</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-600 text-xl">✅
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Selesai (Total)</p>
                <p class="text-xl font-bold text-gray-900">{{ $batches->where('status', 'Selesai')->count() }} Batch</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-200 text-left">
                        <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Info Batch</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Jadwal</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Target Output
                        </th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">
                            Status / Hari</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($batches as $batch)
                    <tr class="group hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 border border-gray-200 shadow-sm font-mono text-xs font-bold">
                                    #{{ substr($batch->kode_batch, -3) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 text-sm">{{ $batch->kode_batch }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $batch->products_count }} Jenis Produk
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-gray-900">{{ $batch->tanggal_mulai->format('d M
                                    Y') }}</span>
                                @if($batch->status !== 'Selesai')
                                <span class="text-[10px] text-gray-400 mt-0.5">Est. Jadi: {{
                                    $batch->tanggal_mulai->addDays(4)->format('d M') }}</span>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-5">
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-md bg-gray-100 text-gray-700 text-xs font-bold border border-gray-200">
                                {{ $batch->jumlah_target }} Unit
                            </span>
                        </td>

                        <td class="px-6 py-5">
                            <div class="flex flex-col items-center justify-center gap-1.5">
                                @if($batch->status === 'Selesai')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                    Selesai
                                </span>
                                @else
                                <div class="w-full max-w-[100px] bg-gray-200 rounded-full h-2.5 dark:bg-gray-200">
                                    @php
                                    // Asumsi max 4 hari
                                    $progress = min(100, ($batch->hari_ke / 4) * 100);
                                    @endphp
                                    <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500"
                                        style="width: {{ $progress }}%"></div>
                                </div>
                                <span class="text-[10px] font-bold text-blue-600">
                                    Hari ke-{{ $batch->hari_ke }} / 4
                                </span>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-5 text-right">
                            <a href="{{ route('admin.production.show', $batch) }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 text-xs font-bold rounded-lg hover:bg-gray-50 hover:text-primary transition shadow-sm gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                Kelola
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                </div>
                                <p>Belum ada data produksi.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($batches->hasPages())
        <div class="px-8 py-5 border-t border-gray-100 bg-gray-50/50">
            {{ $batches->links() }}
        </div>
        @endif
    </div>
</div>
@endsection