@extends('layouts.admin')

@section('title', 'Laporan Keuangan Detail')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex items-center gap-3 mb-8 text-sm text-gray-500">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.finance.index') }}" class="hover:text-primary transition-colors">Keuangan</a>
        <span>/</span>
        <span class="text-gray-900 font-bold">Laporan</span>
    </div>

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-serif font-bold text-gray-900">Laporan Laba Rugi</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <form action="{{ route('admin.finance.reports') }}" method="GET"
            class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:flex-1">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Dari Tanggal</label>
                <input type="date" name="start_date"
                    class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm"
                    value="{{ $startDate }}">
            </div>
            <div class="w-full md:flex-1">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date"
                    class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm"
                    value="{{ $endDate }}">
            </div>
            <div class="w-full md:w-auto flex gap-2">
                <button type="submit"
                    class="flex-1 md:flex-none px-6 py-2.5 bg-primary hover:bg-green-800 text-white font-bold rounded-xl shadow-md transition text-sm">
                    Tampilkan
                </button>
                <a href="{{ route('admin.finance.reports.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                    target="_blank"
                    class="flex-1 md:flex-none px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition text-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    PDF
                </a>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

        <div
            class="bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 p-8 flex flex-col justify-center">
            <h3 class="text-center font-bold text-gray-400 text-xs uppercase tracking-widest mb-6">Ringkasan Periode Ini
            </h3>

            <div class="space-y-4">
                <div class="flex justify-between items-center pb-4 border-b border-dashed border-gray-200">
                    <span class="text-gray-600 font-medium">Total Pemasukan</span>
                    <span class="text-xl font-bold text-green-600">Rp {{ number_format($totalIncome, 0, ',', '.')
                        }}</span>
                </div>

                <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">Total Pengeluaran</span>
                    <span class="text-xl font-bold text-red-500">(Rp {{ number_format($totalExpense, 0, ',', '.')
                        }})</span>
                </div>

                <div class="flex justify-between items-center pt-2">
                    <span class="text-lg font-bold text-gray-900">Laba Bersih</span>
                    <span class="text-3xl font-bold {{ $profit >= 0 ? 'text-primary' : 'text-red-600' }}">
                        Rp {{ number_format($profit, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="w-1 h-5 bg-red-500 rounded-full"></span> Rincian Pengeluaran
            </h3>

            @if(count($expensesByCategory) > 0)
            <div class="space-y-3">
                @foreach($expensesByCategory as $category => $amount)
                <div class="flex justify-between items-center p-3 rounded-xl bg-gray-50 border border-gray-100">
                    <span class="text-sm font-medium text-gray-700">{{ $category }}</span>
                    <span class="text-sm font-bold text-red-600">Rp {{ number_format($amount, 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-10 text-gray-400 text-sm">
                Tidak ada data pengeluaran.
            </div>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/30">
            <h3 class="font-bold text-gray-900">Rincian Transaksi Lengkap</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold">
                    <tr>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4 text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php
                    $allRecords = $income->concat($expenses)->sortByDesc('tanggal');
                    @endphp
                    @foreach($allRecords as $record)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-500 font-mono text-xs">
                            {{ $record->tanggal->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-bold uppercase {{ $record->tipe === 'pemasukan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($record->tipe) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ $record->kategori ? $record->kategori . ' - ' : '' }} {{ $record->deskripsi }}
                        </td>
                        <td
                            class="px-6 py-4 text-right font-mono font-bold {{ $record->tipe === 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                            Rp {{ number_format($record->jumlah, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection