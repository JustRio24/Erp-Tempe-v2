@extends('layouts.app')

@section('title', $product->nama)

@section('content')
<div class="container">
    <div class="grid grid-2">
        <div>
            @if($product->gambar)
                <img src="{{ asset('storage/'.$product->gambar) }}" alt="{{ $product->nama }}" style="width: 100%; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            @else
                <div style="width: 100%; height: 400px; background: linear-gradient(135deg, #2D5F3F, #4CAF50); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 5rem;">
                    🌿
                </div>
            @endif
        </div>

        <div>
            <h1 style="color: var(--primary); margin-bottom: 1rem;">{{ $product->nama }}</h1>
            
            <div style="margin-bottom: 1.5rem;">
                <span class="badge" style="background: {{ $product->is_active ? 'var(--success)' : '#999' }}; padding: 0.5rem 1rem;">
                    {{ $product->is_active ? 'Tersedia' : 'Tidak Tersedia' }}
                </span>
            </div>

            <p style="font-size: 1.125rem; line-height: 1.8; color: #555; margin-bottom: 1.5rem;">
                {{ $product->deskripsi }}
            </p>

            <div class="card">
                <div style="margin-bottom: 1.5rem;">
                    <div style="font-size: 2rem; font-weight: 700; color: var(--primary); margin-bottom: 0.5rem;">
                        Rp {{ number_format($product->harga_normal, 0, ',', '.') }}
                    </div>
                    @if($product->harga_grosir && $product->minimal_grosir)
                        <div style="color: var(--secondary); font-weight: 600;">
                            Harga Grosir: Rp {{ number_format($product->harga_grosir, 0, ',', '.') }}
                            <small style="color: #666;">(min. {{ $product->minimal_grosir }} {{ $product->satuan }})</small>
                        </div>
                    @endif
                </div>

                <div style="padding: 1rem; background: #f9fafb; border-radius: 8px; margin-bottom: 1.5rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <strong>Satuan:</strong>
                            <div>{{ $product->satuan }}</div>
                        </div>
                        <div>
                            <strong>Stok:</strong>
                            <div style="color: {{ $product->stok_tersedia > 10 ? 'var(--success)' : 'var(--warning)' }};">
                                {{ $product->stok_tersedia }} {{ $product->satuan }}
                            </div>
                        </div>
                        <div>
                            <strong>Ketahanan:</strong>
                            <div>{{ $product->batas_kadaluarsa_hari }} hari</div>
                        </div>
                    </div>
                </div>

                @if($product->is_active && $product->stok_tersedia > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                            <div style="flex: 1;">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stok_tersedia }}" class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.125rem;">
                            🛒 Tambah ke Keranjang
                        </button>
                    </form>
                @else
                    <div class="alert alert-warning">Produk sedang tidak tersedia</div>
                @endif
            </div>
        </div>
    </div>

    @if($relatedProducts->count() > 0)
        <div style="margin-top: 4rem;">
            <h2 style="color: var(--primary); margin-bottom: 2rem;">Produk Terkait</h2>
            <div class="grid grid-4">
                @foreach($relatedProducts as $related)
                    <div class="product-card">
                        @if($related->gambar)
                            <img src="{{ asset('storage/'.$related->gambar) }}" alt="{{ $related->nama }}" class="product-image">
                        @else
                            <div class="product-image" style="background: linear-gradient(135deg, #2D5F3F, #4CAF50); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                                🌿
                            </div>
                        @endif
                        <div class="product-body">
                            <h3 class="product-title">{{ $related->nama }}</h3>
                            <div class="product-price">Rp {{ number_format($related->harga_normal, 0, ',', '.') }}</div>
                            <a href="{{ route('catalog.show', $related) }}" class="btn btn-primary" style="width: 100%;">Lihat Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
