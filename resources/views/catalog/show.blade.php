@extends('layouts.app')

@section('title', $product->nama)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">

    <nav class="flex mb-8 text-sm text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-primary">Beranda</a>
        <span class="mx-2">/</span>
        <a href="{{ route('catalog.index') }}" class="hover:text-primary">Katalog</a>
        <span class="mx-2">/</span>
        <span class="text-gray-900 font-medium">{{ $product->nama }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-16">

        <div class="space-y-4">
            <div
                class="aspect-square w-full rounded-3xl overflow-hidden bg-gray-100 shadow-lg border border-gray-200 relative">
                @if($product->gambar)
                <img src="{{ asset('storage/'.$product->gambar) }}" alt="{{ $product->nama }}"
                    class="w-full h-full object-cover">
                @else
                <div
                    class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-[#2D5F3F] to-[#4CAF50] text-white">
                    <span class="text-6xl md:text-8xl mb-4">🌿</span>
                    <span class="text-lg font-medium opacity-90">Gambar Belum Tersedia</span>
                </div>
                @endif

                <div class="absolute top-4 left-4">
                    <span
                        class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide text-white shadow-md {{ $product->is_active && $product->stok_tersedia > 0 ? 'bg-green-600' : 'bg-red-500' }}">
                        {{ $product->is_active && $product->stok_tersedia > 0 ? 'Tersedia' : 'Habis' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="flex flex-col">
            <h1 class="text-3xl md:text-4xl font-serif font-bold text-gray-900 mb-4">{{ $product->nama }}</h1>

            <div class="prose prose-sm text-gray-600 mb-6 leading-relaxed">
                <p>{{ $product->deskripsi }}</p>
            </div>

            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 mb-8">
                <div class="flex items-baseline gap-2 mb-2">
                    <span class="text-sm text-gray-500">Harga Satuan:</span>
                </div>
                <div class="text-3xl font-bold text-primary mb-2">
                    Rp {{ number_format($product->harga_normal, 0, ',', '.') }}
                    <span class="text-sm font-normal text-gray-500">/ {{ $product->satuan }}</span>
                </div>

                @if($product->harga_grosir && $product->minimal_grosir)
                <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-200">
                    <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 011 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Harga Grosir</p>
                        <p class="text-secondary font-bold">
                            Rp {{ number_format($product->harga_grosir, 0, ',', '.') }}
                            <span class="text-gray-400 font-normal text-xs">(Min. beli {{ $product->minimal_grosir }} {{
                                $product->satuan }})</span>
                        </p>
                    </div>
                </div>
                @endif
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white border border-gray-100 p-4 rounded-xl text-center shadow-sm">
                    <span class="block text-gray-400 text-xs uppercase mb-1">Satuan</span>
                    <span class="block font-bold text-gray-800">{{ $product->satuan }}</span>
                </div>
                <div class="bg-white border border-gray-100 p-4 rounded-xl text-center shadow-sm">
                    <span class="block text-gray-400 text-xs uppercase mb-1">Stok</span>
                    <span
                        class="block font-bold {{ $product->stok_tersedia > 10 ? 'text-green-600' : 'text-orange-500' }}">
                        {{ $product->stok_tersedia }}
                    </span>
                </div>
                <div class="bg-white border border-gray-100 p-4 rounded-xl text-center shadow-sm">
                    <span class="block text-gray-400 text-xs uppercase mb-1">Ketahanan</span>
                    <span class="block font-bold text-gray-800">{{ $product->batas_kadaluarsa_hari }} Hari</span>
                </div>
            </div>

            <div class="mt-auto">
                @if($product->is_active && $product->stok_tersedia > 0)
                <form action="{{ route('cart.add', $product) }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                    @csrf
                    <div class="w-full sm:w-32">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Jumlah</label>
                        <div class="relative flex items-center">
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stok_tersedia }}"
                                class="w-full text-center font-bold border-2 border-gray-200 rounded-xl py-3 focus:ring-primary focus:border-primary transition-colors">
                        </div>
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-transparent mb-1">Action</label>
                        <button type="submit"
                            class="w-full bg-primary hover:bg-green-800 text-white font-bold text-lg py-3 rounded-xl shadow-lg shadow-green-200 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            Masukkan Keranjang
                        </button>
                    </div>
                </form>
                @else
                <div
                    class="w-full bg-gray-100 text-gray-400 font-bold py-4 rounded-xl text-center border-2 border-dashed border-gray-300">
                    Produk Sedang Tidak Tersedia
                </div>
                @endif
            </div>
        </div>
    </div>

    @if($relatedProducts->count() > 0)
    <div class="mt-20 border-t border-gray-200 pt-12">
        <h2 class="text-2xl md:text-3xl font-serif font-bold text-primary mb-8 text-center">Produk Terkait Lainnya</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($relatedProducts as $related)
            <div class="group bg-white rounded-xl border border-gray-100 hover:shadow-lg transition-all duration-300">
                <a href="{{ route('catalog.show', $related) }}"
                    class="block relative h-40 overflow-hidden rounded-t-xl bg-gray-100">
                    @if($related->gambar)
                    <img src="{{ asset('storage/'.$related->gambar) }}" alt="{{ $related->nama }}"
                        class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-green-50 text-2xl">🌿</div>
                    @endif
                </a>
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 text-sm mb-1 truncate">{{ $related->nama }}</h3>
                    <div class="text-primary font-bold text-sm">Rp {{ number_format($related->harga_normal, 0, ',', '.')
                        }}</div>
                    <a href="{{ route('catalog.show', $related) }}"
                        class="mt-3 block w-full text-center text-xs font-semibold text-primary border border-primary rounded-lg py-1.5 hover:bg-primary hover:text-white transition-colors">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection