@extends('layouts.admin')

@section('title', 'Produksi')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="color: var(--primary); margin-bottom: 0.5rem;">Produksi Tempe</h1>
        <p style="color: #666;">Kelola siklus produksi batch 4 hari</p>
    </div>
    <a href="{{ route('admin.production.create') }}" class="btn btn-primary">+ Mulai Batch Baru</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Kode Batch</th>
                <th>Tanggal Mulai</th>
                <th>Status / Hari Ke</th>
                <th>Target Produksi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($batches as $batch)
                <tr>
                    <td>
                        <strong>{{ $batch->kode_batch }}</strong>
                        <div style="font-size: 0.8rem; color: #888;">{{ $batch->products_count }} jenis produk</div>
                    </td>
                    <td>{{ $batch->tanggal_mulai->format('d M Y') }}</td>
                    <td>
                        <span class="badge" style="background: {{ $batch->status === 'Selesai' ? '#4CAF50' : '#1E88E5' }}; padding: 0.35rem 0.75rem; border-radius: 12px; color: white;">
                            {{ $batch->status }}
                        </span>
                        @if($batch->status !== 'Selesai')
                            <div style="font-size: 0.8rem; margin-top: 0.25rem;">
                                Estimasi Jadi: {{ $batch->tanggal_mulai->addDays(4)->format('d M') }}
                            </div>
                        @endif
                    </td>
                    <td>{{ $batch->jumlah_target }} unit</td>
                    <td>
                        <a href="{{ route('admin.production.show', $batch) }}" class="btn btn-accent" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Kelola</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 2rem; color: #666;">Belum ada data produksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="padding: 1rem;">
        {{ $batches->links() }}
    </div>
</div>
@endsection
