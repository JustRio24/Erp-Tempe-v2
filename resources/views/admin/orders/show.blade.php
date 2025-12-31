@extends('layouts.admin')

@section('title', 'Detail Pesanan ' . $order->nomor_pesanan)

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('admin.orders.index') }}" style="color: #666; font-size: 0.875rem;">← Kembali ke Daftar Pesanan</a>
    <div style="display: flex; justify-content: space-between; align-items: start; margin-top: 0.5rem;">
        <div>
            <h1 style="color: var(--primary); margin: 0;">Pesanan #{{ $order->nomor_pesanan }}</h1>
            <p style="color: #666;">Dibuat pada: {{ $order->created_at->format('d F Y, H:i') }}</p>
        </div>
        
        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" style="display: flex; align-items: center; gap: 0.5rem; background: white; padding: 1rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            @csrf
            @method('PATCH')
            <label style="font-weight: 500;">Update Status:</label>
            <select name="status" class="form-control" style="width: auto;">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

<div class="grid grid-2">
    <!-- Customer Info -->
    <div class="card">
        <h3 style="border-bottom: 1px solid #eee; padding-bottom: 0.5rem; margin-bottom: 1rem;">Info Pembeli</h3>
        <table style="width: 100%;">
            <tr>
                <td style="padding: 0.5rem 0; color: #666; width: 120px;">Nama</td>
                <td><strong>{{ $order->nama_pembeli }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 0.5rem 0; color: #666;">Telepon</td>
                <td>{{ $order->telepon_pembeli }}</td>
            </tr>
            <tr>
                <td style="padding: 0.5rem 0; color: #666;">Email</td>
                <td>{{ $order->email_pembeli }}</td>
            </tr>
            <tr>
                <td style="padding: 0.5rem 0; color: #666; vertical-align: top;">Alamat</td>
                <td>{{ $order->alamat_pembeli }}</td>
            </tr>
        </table>
        
        @if($order->catatan)
            <div style="margin-top: 1rem; background: #fffbe6; padding: 0.75rem; border-radius: 6px;">
                <strong>Catatan Pembeli:</strong><br>
                {{ $order->catatan }}
            </div>
        @endif
    </div>

    <!-- Payment & Shipping -->
    <div class="card">
        <h3 style="border-bottom: 1px solid #eee; padding-bottom: 0.5rem; margin-bottom: 1rem;">Pembayaran & Pengiriman</h3>
        <table style="width: 100%;">
            <tr>
                <td style="padding: 0.5rem 0; color: #666; width: 150px;">Metode Bayar</td>
                <td>{{ config('erp.payment_methods')[$order->metode_pembayaran] ?? $order->metode_pembayaran }}</td>
            </tr>
            @if($order->bank_tujuan)
            <tr>
                <td style="padding: 0.5rem 0; color: #666;">Bank Tujuan</td>
                <td>{{ config('erp.payment_gateway.banks')[$order->bank_tujuan] ?? $order->bank_tujuan }}</td>
            </tr>
            @endif
            <tr>
                <td style="padding: 0.5rem 0; color: #666;">Metode Kirim</td>
                <td>{{ config('erp.shipping_methods')[$order->metode_pengiriman] ?? $order->metode_pengiriman }}</td>
            </tr>
            <tr>
                <td style="padding: 0.5rem 0; color: #666;">Ongkir</td>
                <td>Rp {{ number_format($order->ongkir, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="padding: 0.5rem 0; color: #666;">Total Tagihan</td>
                <td style="color: var(--primary); font-size: 1.25rem; font-weight: 700;">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</div>

<!-- Order Items -->
<div class="card">
    <h3 style="margin-bottom: 1rem;">Rincian Barang</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th style="text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->nama_produk }}</td>
                    <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td style="text-align: right;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align: right; border-top: 2px solid #eee; padding-top: 1rem;"><strong>Subtotal</strong></td>
                <td style="text-align: right; border-top: 2px solid #eee; padding-top: 1rem;">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Ongkos Kirim</strong></td>
                <td style="text-align: right;">Rp {{ number_format($order->ongkir, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right; font-size: 1.1rem;"><strong>Total Akhir</strong></td>
                <td style="text-align: right; font-size: 1.1rem; color: var(--primary); font-weight: 700;">
                    Rp {{ number_format($order->total, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
