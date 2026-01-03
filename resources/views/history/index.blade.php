@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-serif font-bold text-gray-900">Riwayat Pesanan</h1>
                <p class="text-gray-500 mt-1">Lacak status pesanan tempe Anda di sini.</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="text-sm font-semibold text-primary hover:text-green-800 transition">
                &larr; Kembali Belanja
            </a>
        </div>

        <div class="space-y-6">
            @forelse ($orders as $order)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
                            
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="font-mono text-sm text-gray-500">#{{ $order->nomor_pesanan }}</span>
                                    
                                    {{-- Logika Warna Badge Status --}}
                                    @php
                                        $statusClass = match($order->status) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'diproses' => 'bg-blue-100 text-blue-800',
                                            'dikirim' => 'bg-indigo-100 text-indigo-800',
                                            'selesai' => 'bg-green-100 text-green-800',
                                            'dibatalkan' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                        $statusLabel = ucfirst($order->status);
                                    @endphp
                                    
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </div>
                                
                                <h3 class="font-bold text-gray-900">
                                    {{ $order->created_at->format('d F Y, H:i') }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    Total Item: {{ $order->total_item }} | Metode: {{ strtoupper($order->metode_pembayaran) }}
                                </p>
                            </div>

                            <div class="flex flex-col md:items-end gap-3">
                                <div class="text-lg font-bold text-primary">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </div>
                                
                                <div class="flex gap-2">
                                    {{-- Tombol Bayar (Muncul hanya jika status Pending & bukan COD) --}}
                                    @if($order->status == 'pending' && $order->snap_token && $order->metode_pembayaran != 'cod')
                                        <button onclick="snap.pay('{{ $order->snap_token }}')" 
                                            class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-green-800 transition">
                                            Bayar Sekarang
                                        </button>
                                    @endif

                                    {{-- Tombol Detail (Opsional, jika nanti mau buat halaman detail) --}}
                                    {{-- <a href="{{ route('history.show', $order->id) }}" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-bold rounded-lg hover:bg-gray-50 transition">
                                        Detail
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Footer Card (Info Pengiriman/Resi jika ada) --}}
                    @if($order->status == 'dikirim' || $order->status == 'selesai')
                    <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
                        <p class="text-xs text-gray-500">
                            <strong>Info:</strong> Pesanan sedang dalam perjalanan/telah diterima.
                        </p>
                    </div>
                    @endif
                </div>

            @empty
                {{-- Tampilan Jika Tidak Ada Order --}}
                <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-gray-300">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pesanan</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai belanja tempe segar sekarang.</p>
                    <div class="mt-6">
                        <a href="{{ route('catalog.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Belanja Sekarang
                        </a>
                    </div>
                </div>
            @endforelse

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Script Midtrans (Penting agar tombol Bayar berfungsi) --}}
@if($orders->contains('status', 'pending'))
    <script src="https://app.{{ env('MIDTRANS_IS_PRODUCTION') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY', config('midtrans.client_key')) }}"></script>
@endif

@endsection