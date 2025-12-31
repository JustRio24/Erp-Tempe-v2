@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-serif font-bold text-primary">Keranjang Belanja</h1>
        <span class="text-sm text-gray-500 font-medium">{{ count($cartItems) }} Item di keranjang</span>
    </div>

    @if(empty($cartItems))
    <div class="text-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
        <div
            class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-full shadow-sm mb-6 text-green-200">
            <svg class="w-12 h-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
        </div>
        <h2 class="text-xl font-bold text-gray-900 mb-2">Keranjang Anda Masih Kosong</h2>
        <p class="text-gray-500 mb-8 max-w-md mx-auto">Wah, sepertinya Anda belum memilih tempe favorit Anda. Yuk, lihat
            katalog kami yang segar!</p>
        <a href="{{ route('catalog.index') }}"
            class="inline-flex items-center justify-center px-8 py-3 bg-primary text-white font-semibold rounded-xl hover:bg-green-800 transition shadow-lg shadow-green-100">
            Mulai Belanja Sekarang
        </a>
    </div>
    @else
    <div class="lg:grid lg:grid-cols-12 lg:gap-12 items-start">

        <div class="lg:col-span-8 space-y-6">
            @foreach($cartItems as $item)
            <div
                class="bg-white p-4 sm:p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col sm:flex-row gap-6 transition hover:shadow-md">

                <div class="w-full sm:w-28 h-28 flex-shrink-0 bg-gray-100 rounded-xl overflow-hidden relative">
                    @if($item['product']->gambar)
                    <img src="{{ asset('storage/'.$item['product']->gambar) }}" alt="{{ $item['product']->nama }}"
                        class="w-full h-full object-cover">
                    @else
                    <div
                        class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#2D5F3F] to-[#4CAF50] text-white">
                        <span class="text-3xl">🌿</span>
                    </div>
                    @endif
                </div>

                <div class="flex-1 flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $item['product']->nama }}</h3>
                            <p class="text-sm text-gray-500">Harga Satuan: <span class="font-medium text-gray-700">Rp {{
                                    number_format($item['harga'], 0, ',', '.') }}</span> / {{ $item['product']->satuan
                                }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-primary">Rp {{ number_format($item['subtotal'], 0, ',',
                                '.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-50">
                        <form action="{{ route('cart.update', $item['product']) }}" method="POST"
                            class="flex items-center gap-3">
                            @csrf
                            @method('PATCH')
                            <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden h-9 w-28">
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                    max="{{ $item['product']->stok_tersedia }}"
                                    class="w-full text-center text-sm font-semibold border-none focus:ring-0 px-1 appearance-none">
                            </div>
                            <button type="submit"
                                class="text-sm text-primary font-medium hover:text-green-800 hover:underline">
                                Update
                            </button>
                        </form>

                        <form action="{{ route('cart.remove', $item['product']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="flex items-center gap-1 text-sm text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                <span class="hidden sm:inline">Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="flex justify-end pt-4">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-red-500 text-sm font-medium hover:text-red-700 hover:underline flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-red-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Kosongkan Keranjang
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-4 mt-8 lg:mt-0">
            <div class="bg-gray-50 rounded-2xl p-6 lg:p-8 border border-gray-200 sticky top-24">
                <h3 class="text-xl font-bold text-gray-900 mb-6 font-serif">Ringkasan Belanja</h3>

                <div class="space-y-3 mb-6 pb-6 border-b border-gray-200">
                    <div class="flex justify-between text-gray-600">
                        <span>Total Item</span>
                        <span class="font-medium">{{ count($cartItems) }} pcs</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span class="font-medium">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Pajak (PPN)</span>
                        <span class="text-xs text-gray-400 italic">Termasuk</span>
                    </div>
                </div>

                <div class="flex justify-between items-end mb-8">
                    <span class="text-lg font-bold text-gray-900">Total Akhir</span>
                    <span class="text-2xl font-bold text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('checkout.index') }}"
                        class="block w-full text-center py-3.5 bg-primary hover:bg-green-800 text-white font-bold rounded-xl shadow-lg shadow-green-100 transition-all transform hover:-translate-y-0.5">
                        Lanjut ke Checkout →
                    </a>
                    <a href="{{ route('catalog.index') }}"
                        class="block w-full text-center py-3.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
                        Lanjut Belanja
                    </a>
                </div>

                <div class="mt-6 flex items-center justify-center gap-2 text-xs text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                    <span>Transaksi Aman & Terenkripsi</span>
                </div>
            </div>
        </div>

    </div>
    @endif
</div>
@endsection