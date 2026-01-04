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
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.orders.contact', $order->id) }}" target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-green-50 border border-green-200 text-green-700 text-sm font-bold rounded-xl hover:bg-green-100 transition gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                            Hubungi Pelanggan
                        </a>
                        <a href="{{ route('orders.invoice', $order->id) }}"
                           class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Download Invoice
                        </a>
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