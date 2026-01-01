@extends('layouts.admin')

@section('title', 'Detail Batch ' . $production->kode_batch)

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('admin.production.index') }}" style="color: #666; font-size: 0.875rem;">← Kembali ke Daftar Produksi</a>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
        <h1 style="color: var(--primary); margin: 0;">Batch: {{ $production->kode_batch }}</h1>
        <span class="badge" style="background: {{ $production->status === 'Selesai' ? '#4CAF50' : '#1E88E5' }}; font-size: 1rem; padding: 0.5rem 1rem;">
            {{ $production->status }}
        </span>
    </div>
</div>

<div class="grid grid-2">
    <!-- Status & Information -->
    <div class="card">
        <h3 style="border-bottom: 1px solid #eee; padding-bottom: 0.5rem; margin-bottom: 1rem;">Informasi Batch</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
                <small style="color: #666;">Tanggal Mulai</small>
                <div style="font-weight: 600;">{{ $production->tanggal_mulai->format('d M Y') }}</div>
            </div>
            <div>
                <small style="color: #666;">Estimasi Panen</small>
                <div style="font-weight: 600;">{{ $production->tanggal_mulai->addDays(3)->format('d M Y') }}</div>
            </div>
            <div>
                <small style="color: #666;">Total Target</small>
                <div style="font-weight: 600;">{{ $production->jumlah_target }} Unit</div>
            </div>
            <div>
                <small style="color: #666;">Kegagalan</small>
                <div style="font-weight: 600; color: var(--danger);">{{ $production->jumlah_gagal }} Unit</div>
            </div>
        </div>
        
        @if($production->catatan)
            <div style="margin-top: 1rem; background: #fffbe6; padding: 0.75rem; border-radius: 6px;">
                <strong>Catatan:</strong> {{ $production->catatan }}
            </div>
        @endif
    </div>

    <!-- Controls -->
    <div class="card">
        <h3 style="border-bottom: 1px solid #eee; padding-bottom: 0.5rem; margin-bottom: 1rem;">Kontrol Produksi</h3>
        
        @if($production->status !== 'Selesai')
            <div class="alert alert-info">
                Saat ini batch berada di <strong>Hari ke-{{ $production->hari_ke }}</strong>.
            </div>

            <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                <!-- Advance Day -->
                @if($production->hari_ke < 4)
                    <form action="{{ route('admin.production.advance', $production) }}" method="POST" style="flex: 1;">
                        @csrf
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            ⏩ Maju ke Hari {{ $production->hari_ke + 1 }}
                        </button>
                    </form>
                @endif

                <!-- Complete Batch -->
                @if($production->hari_ke >= 3)
                    <form action="{{ route('admin.production.complete', $production) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Selesaikan batch? Stok produk akan bertambah otomatis.');">
                        @csrf
                        <button type="submit" class="btn btn-success" style="width: 100%;">
                            ✅ Panen / Selesai
                        </button>
                    </form>
                @endif
            </div>

            <hr style="margin: 1.5rem 0; border: 0; border-top: 1px solid #eee;">

            <!-- Failure Recording -->
            <h4>Catat Kegagalan (Rusak/Busuk)</h4>
            <form action="{{ route('admin.production.record-failure', $production) }}" method="POST">
                @csrf
                <div style="display: flex; gap: 0.5rem;">
                    <select name="product_id" class="form-control" required style="flex: 2;">
                        <option value="">Pilih Produk Gagal</option>
                        @foreach($production->products as $prod)
                            <option value="{{ $prod->id }}">{{ $prod->nama }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="jumlah" class="form-control" placeholder="Jml" required style="width: 80px;">
                    <button type="submit" class="btn btn-danger">Simpan</button>
                </div>
            </form>
        @else
            <div class="alert alert-success">
                ✅ Batch ini telah selesai diproduksi. Stok telah ditambahkan ke inventori.
            </div>
        @endif
    </div>
</div>

<!-- Product List -->
<div class="card">
    <h3 style="margin-bottom: 1rem;">Daftar Produk Batch Ini</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Target Produksi</th>
                <th style="color: var(--danger);">Gagal (Busuk/Rusak)</th>
                <th>Hasil Netto (Stok)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($production->products as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->pivot->jumlah }} {{ $item->satuan }}</td>
                    <td style="color: var(--danger);">{{ $item->pivot->jumlah_gagal ?? 0 }} {{ $item->satuan }}</td>
                    <td>
                        @if($production->status === 'Selesai')
                            @php $netto = max(0, $item->pivot->jumlah - ($item->pivot->jumlah_gagal ?? 0)); @endphp
                            <span style="color: var(--success); font-weight: bold;">
                                {{ $netto }} {{ $item->satuan }}
                            </span>
                        @else
                            @php $est = max(0, $item->pivot->jumlah - ($item->pivot->jumlah_gagal ?? 0)); @endphp
                            <span style="color: #666;">Estimasi: {{ $est }} {{ $item->satuan }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- History/Timeline -->
@if($production->stockMovements->count() > 0)
<div class="card">
    <h3 style="margin-bottom: 1rem;">Riwayat Perubahan Stok</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Produk</th>
                <th>Tipe</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($production->stockMovements as $move)
                <tr>
                    <td>{{ $move->created_at->format('d M H:i') }}</td>
                    <td>{{ $move->product->nama }}</td>
                    <td>
                        <span class="badge" style="background: {{ $move->tipe == 'masuk' ? '#4CAF50' : '#F44336' }}; color: white;">
                             {{ ucfirst($move->tipe) }}
                        </span>
                    </td>
                    <td>{{ $move->jumlah }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection
