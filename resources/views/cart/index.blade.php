@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container">
    <h1 style="color: var(--primary); margin-bottom: 2rem;">Keranjang Belanja</h1>

    @if(empty($cartItems))
        <div class="card" style="text-align: center; padding: 3rem;">
            <p style="font-size: 1.25rem; color: #666; margin-bottom: 1.5rem;">Keranjang belanja Anda kosong</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary">Mulai Belanja</a>
        </div>
    @else
        <div class="grid grid-2">
            <div>
                @foreach($cartItems as $item)
                    <div class="card">
                        <div style="display: flex; gap: 1.5rem;">
                            @if($item['product']->gambar)
                                <img src="{{ asset('storage/'.$item['product']->gambar) }}" alt="{{ $item['product']->nama }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #2D5F3F, #4CAF50); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                                    🌿
                                </div>
                            @endif
                            <div style="flex: 1;">
                                <h3 style="margin-bottom: 0.5rem;">{{ $item['product']->nama }}</h3>
                                <p style="color: #666; margin-bottom: 0.5rem;">Rp {{ number_format($item['harga'], 0, ',', '.') }} / {{ $item['product']->satuan }}</p>
                                
                                <form action="{{ route('cart.update', $item['product']) }}" method="POST" style="display: flex; gap: 0.5rem; align-items: center; margin-bottom: 0.5rem;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stok_tersedia }}" class="form-control" style="width: 80px;">
                                    <button type="submit" class="btn btn-accent" style="padding: 0.5rem 1rem;">Update</button>
                                </form>

                                <form action="{{ route('cart.remove', $item['product']) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Hapus</button>
                                </form>
                            </div>
                            <div style="text-align: right;">
                                <p style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">
                                    Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

                <form action="{{ route('cart.clear') }}" method="POST" style="margin-top: 1rem;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-secondary">Kosongkan Keranjang</button>
                </form>
            </div>

            <div>
                <div class="card" style="position: sticky; top: 100px;">
                    <h3 style="margin-bottom: 1.5rem;">Ringkasan Belanja</h3>
                    <div style="border-bottom: 1px solid #ddd; padding-bottom: 1rem; margin-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Total Item:</span>
                            <strong>{{ count($cartItems) }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>Total Harga:</span>
                            <strong style="color: var(--primary); font-size: 1.5rem;">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.125rem;">
                        Lanjut ke Checkout
                    </a>
                    <a href="{{ route('catalog.index') }}" class="btn btn-secondary" style="width: 100%; margin-top: 0.75rem;">
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
