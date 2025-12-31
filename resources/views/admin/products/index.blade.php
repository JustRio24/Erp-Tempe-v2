@extends('layouts.admin')

@section('title', 'Daftar Produk')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="color: var(--primary); margin-bottom: 0.5rem;">Kelola Produk</h1>
        <p style="color: #666;">Manajemen produk dan inventori</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Tambah Produk Baru</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>
                        <strong>{{ $product->nama }}</strong>
                        @if(!$product->is_active)
                            <span class="badge" style="background: #999; margin-left: 0.5rem;">Nonaktif</span>
                        @endif
                    </td>
                    <td>{{ $product->satuan }}</td>
                    <td>Rp {{ number_format($product->harga_normal, 0, ',', '.') }}</td>
                    <td>{{ $product->stok_tersedia }} {{ $product->satuan }}</td>
                    <td>
                        @php
                            $status = $product->checkStockStatus();
                            $colors = ['aman' => '#4CAF50', 'menipis' => '#FF9800', 'habis' => '#F44336'];
                        @endphp
                        <span class="badge" style="background: {{ $colors[$status] ?? '#999' }}; padding: 0.25rem 0.75rem; border-radius: 12px; color: white;">
                            {{ $status }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('admin.products.bom', $product) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Atur Resep</a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-accent" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Edit</a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2rem; color: #666;">Belum ada produk</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="padding: 1rem;">
        {{ $products->links() }}
    </div>
</div>
@endsection
