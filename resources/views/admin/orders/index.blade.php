@extends('layouts.admin')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-serif font-bold text-gray-900 tracking-tight">Pesanan Masuk</h2>
            <p class="text-sm text-gray-500 mt-2 font-medium">Kelola transaksi dan status pengiriman pelanggan.</p>
        </div>

        <div class="w-full md:w-auto">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="relative">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari No. Pesanan / Pembeli..."
                    class="w-full md:w-64 pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:border-primary focus:ring-1 focus:ring-primary shadow-sm">
            </form>
        </div>
    </div>

    <div class="border-b border-gray-200 mb-6 overflow-x-auto">
        <nav class="-mb-px flex space-x-6 min-w-max">
            <a href="{{ route('admin.orders.index') }}"
                class="whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm transition-colors {{ !request('status') ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Semua Pesanan
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}"
                class="whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm transition-colors {{ request('status') == 'pending' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Pending
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'diproses']) }}"
                class="whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm transition-colors {{ request('status') == 'diproses' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Diproses
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'dikirim']) }}"
                class="whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm transition-colors {{ request('status') == 'dikirim' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Dikirim
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'selesai']) }}"
                class="whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm transition-colors {{ request('status') == 'selesai' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Selesai
            </a>
        </nav>
    </div>

    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-200 text-left">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Pesanan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Pembeli</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Total & Tanggal
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">
                            Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="group hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 border border-gray-200 text-lg">
                                    🧾
                                </div>
                                <div>
                                    <span class="font-mono text-sm font-bold text-gray-900 block">{{
                                        $order->nomor_pesanan }}</span>
                                    <span class="text-xs text-gray-500">{{ $order->items_count }} Item</span>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-800">{{ $order->nama_pembeli }}</span>
                                <span class="text-xs text-gray-500">{{ $order->telepon_pembeli }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-primary">Rp {{ number_format($order->total, 0, ',',
                                    '.') }}</span>
                                <span class="text-[10px] text-gray-400 mt-0.5">{{ $order->created_at->format('d M Y,
                                    H:i') }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-5 text-center">
                            @php
                            $statusClass = match($order->status) {
                            'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                            'diproses' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'dikirim' => 'bg-purple-50 text-purple-700 border-purple-200',
                            'selesai' => 'bg-green-50 text-green-700 border-green-200',
                            'dibatalkan' => 'bg-red-50 text-red-700 border-red-200',
                            default => 'bg-gray-50 text-gray-600'
                            };
                            @endphp
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $statusClass }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>

                        <td class="px-6 py-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-200 text-gray-600 text-xs font-bold rounded-lg hover:bg-gray-50 hover:text-primary transition shadow-sm gap-1">
                                    <span>Detail</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.orders.contact', $order->id) }}" target="_blank"
                                    class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-200 text-gray-600 text-xs font-bold rounded-lg hover:bg-gray-50 hover:text-green-600 transition shadow-sm gap-1"
                                    title="Hubungi Pelanggan via WhatsApp">
                                    <span>Hubungi</span>
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3 text-gray-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-sm">Tidak ada pesanan ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection