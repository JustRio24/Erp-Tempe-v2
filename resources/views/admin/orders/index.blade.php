@extends('layouts.admin')

@section('title', 'Daftar Pesanan')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="color: var(--primary); margin-bottom: 0.5rem;">Daftar Pesanan</h1>
        <p style="color: #666;">Kelola pesanan masuk dan status pengiriman</p>
    </div>
    
    <div style="border: 1px solid #ddd; padding: 0.25rem; border-radius: 6px; background: white;">
        <a href="{{ route('admin.orders.index') }}" class="btn {{ !request('status') || request('status') == 'all' ? 'btn-primary' : '' }}" style="padding: 0.5rem 1rem; border-radius: 4px; display: inline-block;">Semua</a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn {{ request('status') == 'pending' ? 'btn-primary' : '' }}" style="padding: 0.5rem 1rem; border-radius: 4px; display: inline-block;">Pending</a>
        <a href="{{ route('admin.orders.index', ['status' => 'diproses']) }}" class="btn {{ request('status') == 'diproses' ? 'btn-primary' : '' }}" style="padding: 0.5rem 1rem; border-radius: 4px; display: inline-block;">Diproses</a>
        <a href="{{ route('admin.orders.index', ['status' => 'selesai']) }}" class="btn {{ request('status') == 'selesai' ? 'btn-primary' : '' }}" style="padding: 0.5rem 1rem; border-radius: 4px; display: inline-block;">Selesai</a>
    </div>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>No. Pesanan</th>
                <th>Tanggal</th>
                <th>Pembeli</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>
                        <strong>{{ $order->nomor_pesanan }}</strong>
                        <div style="font-size: 0.8rem; color: #888;">{{ $order->items_count }} item</div>
                    </td>
                    <td>{{ $order->created_at->format('d M H:i') }}</td>
                    <td>
                        {{ $order->nama_pembeli }}
                        <div style="font-size: 0.8rem; color: #888;">{{ $order->telepon_pembeli }}</div>
                    </td>
                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $colors = [
                                'pending' => '#FFC107',
                                'diproses' => '#2196F3',
                                'dikirim' => '#9C27B0',
                                'selesai' => '#4CAF50',
                                'dibatalkan' => '#F44336'
                            ];
                        @endphp
                        <span class="badge" style="background: {{ $colors[$order->status] ?? '#999' }}; padding: 0.35rem 0.75rem; border-radius: 12px; color: black; color: white;">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-accent" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Lihat</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2rem; color: #666;">
                        {{ request('status') ? 'Tidak ada pesanan dengan status '.request('status') : 'Belum ada pesanan masuk' }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="padding: 1rem;">
        {{ $orders->links() }}
    </div>
</div>
@endsection
