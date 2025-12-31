@extends('layouts.app')

@section('title', 'Pesanan Berhasil')

@section('content')
<div class="container">
    <div class="card" style="max-width: 800px; margin: 0 auto; text-align: center; padding: 3rem;">
        <div style="font-size: 4rem; margin-bottom: 1rem;">✅</div>
        <h1 style="color: var(--success); margin-bottom: 1rem;">Pesanan Berhasil Dibuat!</h1>
        <p style="font-size: 1.125rem; color: #666; margin-bottom: 2rem;">
            Terima kasih telah berbelanja di Tempe 3 Puteri
        </p>

        <div style="background: #f9fafb; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
            <div style="margin-bottom: 1rem;">
                <strong>Nomor Pesanan:</strong>
                <div style="font-size: 1.5rem; color: var(--primary); font-weight: 700;">{{ $order->nomor_pesanan }}</div>
            </div>
            <div style="margin-bottom: 1rem;">
                <strong>Total Pembayaran:</strong>
                <div style="font-size: 2rem; color: var(--primary); font-weight: 700;">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
            </div>
            <div>
                <strong>Metode Pembayaran:</strong>
                <div>{{ config('erp.payment_methods')[$order->metode_pembayaran] ?? $order->metode_pembayaran }}</div>
                @if($order->bank_tujuan)
                    <div style="color: #666; margin-top: 0.25rem;">{{ config('erp.payment_gateway.banks')[$order->bank_tujuan] ?? $order->bank_tujuan }}</div>
                @endif
            </div>
        </div>

        @if($order->metode_pembayaran === 'transfer_bank')
            <div class="alert alert-info" style="text-align: left;">
                <strong>Instruksi Pembayaran:</strong>
                <ol style="margin-top: 0.5rem; padding-left: 1.25rem;">
                    <li>Transfer ke rekening {{ $order->bank_tujuan }} atas nama UMKM Tempe 3 Puteri</li>
                    <li>Jumlah: Rp {{ number_format($order->total, 0, ',', '.') }}</li>
                    <li>Konfirmasi pembayaran via WhatsApp/Email</li>
                </ol>
            </div>
        @endif

        <div style="margin-top: 2rem;">
            <a href="{{ route('home') }}" class="btn btn-primary" style="padding: 1rem 2rem;">Kembali ke Beranda</a>
            <a href="{{ route('catalog.index') }}" class="btn btn-secondary" style="padding: 1rem 2rem; margin-left: 1rem;">Belanja Lagi</a>
        </div>
    </div>
</div>
@endsection
