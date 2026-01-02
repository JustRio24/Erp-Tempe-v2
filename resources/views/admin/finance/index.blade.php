@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-serif font-bold text-gray-900 tracking-tight">Keuangan</h2>
            <p class="text-sm text-gray-500 mt-2 font-medium">Ringkasan profitabilitas dan pencatatan arus kas.</p>
        </div>
        <a href="{{ route('admin.finance.reports') }}"
            class="px-5 py-2.5 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            Laporan Lengkap
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div
            class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between group hover:shadow-md transition">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Pendapatan Hari Ini</p>
            <div class="flex items-center justify-between">
                <span class="text-2xl font-bold text-green-600">Rp {{ number_format($todayIncome, 0, ',', '.') }}</span>
                <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center text-green-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div
            class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between group hover:shadow-md transition">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Pengeluaran Hari Ini</p>
            <div class="flex items-center justify-between">
                <span class="text-2xl font-bold text-red-500">Rp {{ number_format($todayExpense, 0, ',', '.') }}</span>
                <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center text-red-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 17h8m0 0V9m0 8l-8-8-4 4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div
            class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between group hover:shadow-md transition">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Total Bulan Ini</p>
            <div class="flex items-center justify-between">
                <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($monthlyIncome, 0, ',', '.')
                    }}</span>
                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-br from-[#1e4329] to-[#2a5c3a] p-5 rounded-2xl shadow-lg shadow-green-900/20 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
            <p class="text-xs font-bold text-green-200 uppercase tracking-wider mb-2 relative z-10">Laba Bersih Bulan
                Ini</p>
            <div class="flex items-center justify-between relative z-10">
                <span class="text-2xl font-bold">Rp {{ number_format($monthlyIncome - $monthlyExpense, 0, ',', '.')
                    }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-50">
                    <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Catat Pengeluaran</h3>
                </div>

                <form action="{{ route('admin.finance.store-expense') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-red-500 bg-gray-50 focus:bg-white transition-all text-sm font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kategori</label>
                        <select name="kategori" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-red-500 bg-white text-sm">
                            <option value="Bahan Baku (Kedelai)">Bahan Baku (Kedelai)</option>
                            <option value="Bahan Penolong">Bahan Penolong (Ragi/Plastik)</option>
                            <option value="Operasional">Operasional (Gas/Listrik)</option>
                            <option value="Gaji Karyawan">Gaji Karyawan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Jumlah (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2.5 text-gray-400 font-bold text-sm">Rp</span>
                            <input type="number" name="jumlah" min="100" required placeholder="0"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-red-500 font-bold text-gray-800">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Keterangan</label>
                        <textarea name="deskripsi" rows="2" placeholder="Contoh: Beli gas 3kg" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-red-500 text-sm placeholder-gray-400"></textarea>
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-200 transition-all transform hover:-translate-y-0.5 text-sm flex justify-center items-center gap-2">
                        <span>Simpan Pengeluaran</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/30">
                    <h3 class="font-bold text-gray-900">Riwayat Transaksi Terakhir</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold">
                            <tr>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Keterangan</th>
                                <th class="px-6 py-4 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentRecords as $record)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                    {{ $record->tanggal->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 {{ $record->tipe == 'pemasukan' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                            @if($record->tipe == 'pemasukan')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                            </svg>
                                            @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                            </svg>
                                            @endif
                                        </div>
                                        <div>
                                            @if($record->tipe == 'pemasukan')
                                            <p class="font-bold text-gray-900">Order #{{ $record->referensi_id }}</p>
                                            @else
                                            <p class="font-bold text-gray-900">{{ $record->kategori }}</p>
                                            @endif
                                            <p class="text-xs text-gray-500 truncate max-w-[200px]">{{
                                                $record->deskripsi }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span
                                        class="font-mono font-bold {{ $record->tipe == 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $record->tipe == 'pemasukan' ? '+' : '-' }} Rp {{
                                        number_format($record->jumlah, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                                    Belum ada transaksi tercatat.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection