@extends('layouts.admin')

@section('title', 'Detail Pesanan ' . $order->nomor_pesanan)

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex items-center gap-3 mb-8 text-sm text-gray-500">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.orders.index') }}" class="hover:text-primary transition-colors">Pesanan</a>
        <span>/</span>
        <span class="text-gray-900 font-bold">{{ $order->nomor_pesanan }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">

                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-start bg-gray-50/50">
                    <div>
                        <h1 class="text-2xl font-serif font-bold text-gray-900">Invoice</h1>
                        <p class="text-sm text-gray-500 font-mono mt-1">#{{ $order->nomor_pesanan }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Tanggal Pesanan</p>
                        <p class="text-sm font-bold text-gray-800">{{ $order->created_at->format('d F Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }} WIB</p>
                    </div>
                </div>

                <div class="p-8 border-b border-gray-100">
                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="flex-1">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Info Pembeli</p>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $order->nama_pembeli }}</h3>
                            <p class="text-sm text-gray-600 mb-1">{{ $order->telepon_pembeli }}</p>
                            <p class="text-sm text-gray-600">{{ $order->email_pembeli }}</p>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Alamat Pengiriman
                            </p>
                            <p
                                class="text-sm text-gray-600 leading-relaxed bg-gray-50 p-3 rounded-lg border border-gray-100">
                                {{ $order->alamat_pembeli }}
                            </p>
                            @if($order->catatan)
                            <div
                                class="mt-3 text-xs text-yellow-700 bg-yellow-50 p-2 rounded border border-yellow-100 flex gap-2">
                                <span>📝</span> <span>"{{ $order->catatan }}"</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Rincian Barang</p>
                    <div class="border rounded-xl overflow-hidden">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-500 font-bold border-b border-gray-100">
                                <tr>
                                    <th class="px-4 py-3">Produk</th>
                                    <th class="px-4 py-3 text-center">Qty</th>
                                    <th class="px-4 py-3 text-right">Harga</th>
                                    <th class="px-4 py-3 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $item->nama_produk }}</td>
                                    <td class="px-4 py-3 text-center text-gray-500">x{{ $item->jumlah }}</td>
                                    <td class="px-4 py-3 text-right text-gray-600">Rp {{
                                        number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right font-bold text-gray-800">Rp {{
                                        number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <div class="w-full sm:w-1/2 space-y-3">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Ongkos Kirim</span>
                                <span>Rp {{ number_format($order->ongkir, 0, ',', '.') }}</span>
                            </div>
                            <div class="pt-3 border-t border-gray-100 flex justify-between items-center">
                                <span class="font-bold text-gray-900">Total Tagihan</span>
                                <span class="text-2xl font-bold text-primary">Rp {{ number_format($order->total, 0, ',',
                                    '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Update Status Pesanan</h4>

                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div class="relative">
                        <select name="status"
                            class="w-full pl-4 pr-10 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:border-primary focus:ring-2 focus:ring-primary/20 appearance-none font-bold text-gray-700 cursor-pointer">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Pending
                            </option>
                            <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>⚙️ Diproses
                            </option>
                            <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>🚚 Dikirim
                            </option>
                            <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>✅ Selesai
                            </option>
                            <option value="dibatalkan" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>❌
                                Dibatalkan</option>
                        </select>
                        <div
                            class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-primary hover:bg-green-800 text-white font-bold rounded-xl shadow-lg shadow-green-900/20 transition-all transform hover:-translate-y-0.5">
                        Simpan Status
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Rincian Pembayaran</h4>
                <div class="space-y-4">
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-xl shadow-sm">
                            💳</div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold">Metode</p>
                            <p class="text-sm font-bold text-gray-900">{{
                                config('erp.payment_methods')[$order->metode_pembayaran] ??
                                Str::headline($order->metode_pembayaran) }}</p>
                        </div>
                    </div>

                    @if($order->bank_tujuan)
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-xl shadow-sm">
                            🏦</div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold">Bank Tujuan</p>
                            <p class="text-sm font-bold text-gray-900">{{
                                config('erp.payment_gateway.banks')[$order->bank_tujuan] ??
                                strtoupper($order->bank_tujuan) }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-xl shadow-sm">
                            🛵</div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold">Pengiriman</p>
                            <p class="text-sm font-bold text-gray-900">{{
                                config('erp.shipping_methods')[$order->metode_pengiriman] ??
                                Str::headline($order->metode_pengiriman) }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection