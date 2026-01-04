@extends('layouts.app')

@section('title', 'Pesanan Berhasil')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">

    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden text-center p-8 md:p-12">

        <div class="mx-auto flex items-center justify-center w-20 h-20 bg-green-100 text-green-600 rounded-full mb-6 animate-bounce-slow">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h1 class="text-3xl md:text-4xl font-serif font-bold text-gray-900 mb-2">Terima Kasih!</h1>
        <p class="text-gray-500 mb-8">Pesanan Anda telah kami terima.</p>

        <div class="bg-gray-50 rounded-2xl p-6 mb-8 border border-gray-200 text-left">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <span class="block text-xs text-gray-400 uppercase tracking-wider mb-1">Nomor Pesanan</span>
                    <span class="block text-xl font-bold text-primary font-mono tracking-wide">{{ $order->nomor_pesanan }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400 uppercase tracking-wider mb-1">Total Pembayaran</span>
                    <span class="block text-xl font-bold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400 uppercase tracking-wider mb-1">Metode Pembayaran</span>
                    <span class="block font-medium text-gray-800">
                        @if($order->metode_pembayaran === 'transfer_bank')
                            E-Payment (Lunas/Menunggu Verifikasi)
                        @else
                            Bayar di Tempat (COD)
                        @endif
                    </span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400 uppercase tracking-wider mb-1">Status</span>
                    {{-- Karena user diarahkan kesini setelah interaksi popup, anggap saja diproses/pending payment --}}
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ URL::signedRoute('orders.invoice', $order->id) }}" class="px-8 py-3 bg-white border-2 border-primary text-primary font-bold rounded-xl hover:bg-green-50 transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Download Invoice
            </a>
            <a href="{{ route('home') }}" class="px-8 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
                Beranda
            </a>
            <a href="{{ route('catalog.index') }}" class="px-8 py-3 bg-primary text-white font-semibold rounded-xl hover:bg-green-800 transition shadow-lg shadow-green-100">
                Belanja Lagi
            </a>
        </div>

    </div>
</div>
@endsection