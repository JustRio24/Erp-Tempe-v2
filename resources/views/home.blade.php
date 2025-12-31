@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <section style="text-align: center; padding: 4rem 0; background: linear-gradient(135deg, #2D5F3F, #1e4329); color: white; border-radius: 16px; margin-bottom: 3rem;">
        <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">Selamat Datang di Tempe 3 Puteri</h1>
        <p style="font-size: 1.25rem; margin-bottom: 2rem; opacity: 0.9;">Tempe Berkualitas Premium untuk Keluarga Indonesia</p>
        <a href="{{ route('catalog.index') }}" class="btn btn-secondary" style="font-size: 1.125rem; padding: 1rem 2rem;">
            Lihat Produk Kami
        </a>
    </section>

    <!-- Featured Products -->
    <section>
        <h2 style="text-align: center; margin-bottom: 2rem; color: var(--primary);">Produk Unggulan Kami</h2>
        <div class="grid grid-3">
            @forelse($featuredProducts as $product)
                <div class="product-card">
                    @if($product->gambar)
                        <img src="{{ asset('storage/'.$product->gambar) }}" alt="{{ $product->nama }}" class="product-image">
                    @else
                        <div class="product-image" style="background: linear-gradient(135deg, #2D5F3F, #4CAF50); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                            🌿
                        </div>
                    @endif
                    <div class="product-body">
                        <h3 class="product-title">{{ $product->nama }}</h3>
                        <p style="color: #666; font-size: 0.875rem; margin-bottom: 1rem;">{{ Str::limit($product->deskripsi, 80) }}</p>
                        <div class="product-price">Rp {{ number_format($product->harga_normal, 0, ',', '.') }}</div>
                        <a href="{{ route('catalog.show', $product) }}" class="btn btn-primary" style="width: 100%;">Lihat Detail</a>
                    </div>
                </div>
            @empty
                <p style="grid-column: 1 / -1; text-align: center; color: #666;">Belum ada produk tersedia</p>
            @endforelse
        </div>
    </section>

    <!-- About Section -->
    <section style="margin-top: 4rem; padding: 3rem; background: white; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08);">
        <div class="grid grid-2">
            <div>
                <h2 style="color: var(--primary); margin-bottom: 1rem;">Tentang Tempe 3 Puteri</h2>
                <p style="line-height: 1.8; color: #555; margin-bottom: 1rem;">
                    UMKM Tempe 3 Puteri telah berpengalaman lebih dari 10 tahun dalam memproduksi tempe berkualitas tinggi.
                    Kami menggunakan kedelai pilihan dan proses fermentasi tradisional yang terjaga kualitasnya.
                </p>
                <p style="line-height: 1.8; color: #555;">
                    Setiap batch tempe kami diproduksi dengan penuh perhatian, memastikan cita rasa autentik dan nilai gizi
                    yang optimal untuk keluarga Indonesia.
                </p>
            </div>
            <div>
                <h3 style="color: var(--primary); margin-bottom: 1rem;">Kenapa Memilih Kami?</h3>
                <ul style="list-style: none;">
                    <li style="padding: 0.75rem 0; border-bottom: 1px solid #eee;">✓ Kedelai premium pilihan</li>
                    <li style="padding: 0.75rem 0; border-bottom: 1px solid #eee;">✓ Proses fermentasi higienis</li>
                    <li style="padding: 0.75rem 0; border-bottom: 1px solid #eee;">✓ Tanpa bahan pengawet</li>
                    <li style="padding: 0.75rem 0; border-bottom: 1px solid #eee;">✓ Harga terjangkau</li>
                    <li style="padding: 0.75rem 0;">✓ Pengiriman cepat & aman</li>
                </ul>
            </div>
        </div>
    </section>
</div>
@endsection
