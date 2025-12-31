@extends('layouts.app')

@section('title', 'Pesanan Berhasil')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">

    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden text-center p-8 md:p-12">

        <div
            class="mx-auto flex items-center justify-center w-20 h-20 bg-green-100 text-green-600 rounded-full mb-6 animate-bounce-slow">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h1 class="text-3xl md:text-4xl font-serif font-bold text-gray-900 mb-2">Pesanan Berhasil!</h1>
        <p class="text-gray-500 mb-8">Terima kasih telah mempercayai Tempe 3 Puteri sebagai pilihan keluarga Anda.</p>

        <div class="bg-gray-50 rounded-2xl p-6 mb-8 border border-gray-200 text-left">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <span class="block text-xs text-gray-400 uppercase tracking-wider mb-1">Nomor Pesanan</span>
                    <span class="block text-xl font-bold text-primary font-mono tracking-wide">{{ $order->nomor_pesanan
                        }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400 uppercase tracking-wider mb-1">Total Pembayaran</span>
                    <span class="block text-xl font-bold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.')
                        }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400 uppercase tracking-wider mb-1">Metode Pembayaran</span>
                    <span class="block font-medium text-gray-800">
                        {{ config('erp.payment_methods')[$order->metode_pembayaran] ??
                        Str::headline($order->metode_pembayaran) }}
                    </span>
                    @if($order->bank_tujuan)
                    <span class="text-sm text-gray-500 block mt-0.5">
                        Bank {{ config('erp.payment_gateway.banks')[$order->bank_tujuan] ??
                        strtoupper($order->bank_tujuan) }}
                    </span>
                    @endif
                </div>
                <div>
                    <span class="block text-xs text-gray-400 uppercase tracking-wider mb-1">Status</span>
                    <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">
                        Menunggu Pembayaran
                    </span>
                </div>
            </div>
        </div>

        @if($order->metode_pembayaran === 'transfer_bank')
        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-r-xl text-left mb-10">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 mt-1">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-blue-900 mb-2">Instruksi Pembayaran</h4>
                    <ol class="list-decimal list-inside text-sm text-blue-800 space-y-1.5">
                        <li>Silakan transfer ke <strong>Bank {{ strtoupper($order->bank_tujuan) }}</strong></li>
                        <li>No. Rekening: <strong>123-456-7890</strong> <span class="text-xs">(a.n Tempe 3
                                Puteri)</span></li>
                        <li>Nominal Transfer: <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                            (Pastikan sesuai hingga 3 digit terakhir)</li>
                        <li>Simpan bukti transfer dan konfirmasi via WhatsApp.</li>
                    </ol>
                </div>
            </div>
        </div>
        @endif

        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('home') }}"
                class="px-8 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
                Kembali ke Beranda
            </a>
            <a href="{{ route('catalog.index') }}"
                class="px-8 py-3 bg-primary text-white font-semibold rounded-xl hover:bg-green-800 transition shadow-lg shadow-green-100">
                Belanja Lagi
            </a>
        </div>

    </div>
</div>
@endsection