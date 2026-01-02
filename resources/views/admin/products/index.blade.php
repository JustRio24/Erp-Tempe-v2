@extends('layouts.admin')

@section('title', 'Daftar Produk')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-serif font-bold text-gray-900 tracking-tight">Katalog Produk</h2>
            <p class="text-sm text-gray-500 mt-1 font-medium">Kelola inventori, harga, dan stok.</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <form action="{{ route('admin.products.index') }}" method="GET"
                class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..."
                        class="w-full sm:w-64 pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:border-primary focus:ring-1 focus:ring-primary shadow-sm">
                </div>

                <select name="status" onchange="this.form.submit()"
                    class="px-4 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 focus:border-primary focus:ring-1 focus:ring-primary shadow-sm cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('status')=='1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('status')=='0' ? 'selected' : '' }}>Arsip</option>
                </select>
            </form>

            <a href="{{ route('admin.products.create') }}"
                class="px-5 py-2.5 bg-[#1e4329] hover:bg-[#163320] text-white font-bold text-sm rounded-xl shadow-lg shadow-green-900/20 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Produk Baru
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 mb-8">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div
                class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-primary text-xl flex-shrink-0">
                📦</div>
            <div class="min-w-0">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider truncate">Total SKU</p>
                <p class="text-2xl font-bold text-gray-900">{{ $products->total() }}</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div
                class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-xl flex-shrink-0">
                💰</div>
            <div class="min-w-0">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider truncate">Total Aset</p>
                @php $totalAsset = $products->sum(function($p) { return $p->calculateHpp() * $p->stok_tersedia; });
                @endphp
                <p class="text-2xl font-bold text-gray-900 truncate">Rp {{ number_format($totalAsset / 1000000, 1, ',',
                    '.') }} Jt</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div
                class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-orange-600 text-xl flex-shrink-0">
                ⚠️</div>
            <div class="min-w-0">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider truncate">Stok Kritis</p>
                <p class="text-2xl font-bold text-gray-900">{{ $products->filter(fn($p) => $p->stok_tersedia <= 5)->
                        count() }} Item</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[800px]">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-200 text-left">
                        <th class="px-6 md:px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Produk
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Harga & Margin
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">
                            Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                    <tr class="group hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 md:px-8 py-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden flex-shrink-0 shadow-sm relative">
                                    @if($product->gambar)
                                    <img src="{{ asset('storage/'.$product->gambar) }}"
                                        class="w-full h-full object-cover">
                                    @else
                                    <div
                                        class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-50 text-xs">
                                        No Pic</div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 text-sm md:text-base">{{ $product->nama }}</div>
                                    <div
                                        class="text-xs text-gray-500 font-medium bg-gray-100 px-2 py-0.5 rounded-md inline-block mt-1">
                                        {{ $product->satuan }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-bold text-gray-900">Rp {{
                                    number_format($product->harga_normal, 0, ',', '.') }}</span>
                                @php
                                $hpp = $product->calculateHpp();
                                $marginVal = $product->harga_normal > 0 ? (($product->harga_normal - $hpp) /
                                $product->harga_normal) * 100 : 0;
                                @endphp
                                <div class="flex items-center gap-2 text-xs">
                                    <span class="text-gray-400">Modal: {{ number_format($hpp, 0, ',', '.') }}</span>
                                    <span
                                        class="px-1.5 py-0.5 rounded text-[10px] font-bold {{ $marginVal > 30 ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                        {{ number_format($marginVal, 0) }}%
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div
                                    class="font-bold text-sm {{ $product->stok_tersedia < 10 ? 'text-red-600' : 'text-gray-700' }}">
                                    {{ $product->stok_tersedia }}
                                </div>
                                @if($product->stok_tersedia < 10) <span class="relative flex h-2 w-2">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                    </span>
                                    @endif
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($product->is_active)
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                Aktif
                            </span>
                            @else
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-500 border border-gray-200">
                                Arsip
                            </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.products.bom', $product) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded-lg border border-blue-100 hover:bg-blue-600 hover:text-white transition-all shadow-sm"
                                    title="Atur Resep">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                        </path>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-yellow-50 text-yellow-600 rounded-lg border border-yellow-100 hover:bg-yellow-500 hover:text-white transition-all shadow-sm"
                                    title="Edit Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            Tidak ada produk yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection