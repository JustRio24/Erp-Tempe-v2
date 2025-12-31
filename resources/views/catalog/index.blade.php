@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="color: var(--primary);">Katalog Produk Kami</h1>
        <p style="color: #666;">Tempe berbagai variant terbaik untuk keluarga Anda</p>
    </div>

    <div class="grid grid-3">
        @forelse($products as $product)
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
                    <p style="color: #666; font-size: 0.875rem; margin-bottom: 0.5rem;">{{ Str::limit($product->deskripsi, 100) }}</p>
                    <div style="margin-bottom: 0.75rem;">
                        <span style="font-size: 0.875rem; color: #888;">Stok: {{ $product->stok_tersedia }} {{ $product->satuan }}</span>
                    </div>
                    <div class="product-price">Rp {{ number_format($product->harga_normal, 0, ',', '.') }}</div>
                    @if($product->harga_grosir && $product->minimal_grosir)
                        <p style="font-size: 0.875rem; color: var(--secondary); margin-bottom: 1rem;">
                            Grosir ({{ $product->minimal_grosir }}+ {{ $product->satuan }}): Rp {{ number_format($product->harga_grosir, 0, ',', '.') }}
                        </p>
                    @endif
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <div style="display: flex; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stok_tersedia }}" class="form-control" style="width: 80px;">
                            <button type="submit" class="btn btn-primary" style="flex: 1;">Tambah</button>
                        </div>
                    </form>
                    <a href="{{ route('catalog.show', $product) }}" style="font-size: 0.875rem;">Lihat Detail →</a>
                </div>
            </div>
        @empty
            <p style="grid-column: 1 / -1; text-align: center; color: #666; padding: 3rem;">Belum ada produk tersedia</p>
        @endforelse
    </div>

    <div style="margin-top: 2rem;">
        {{ $products->links() }}
    </div>
</div>
@endsection
