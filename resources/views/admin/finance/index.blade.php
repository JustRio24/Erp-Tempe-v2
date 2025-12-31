@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="color: var(--primary); margin-bottom: 0.5rem;">Keuangan</h1>
        <p style="color: #666;">Ringkasan profit dan pencatatan pengeluaran</p>
    </div>
    
    <a href="{{ route('admin.finance.reports') }}" class="btn btn-secondary">📄 Lihat Laporan Lengkap</a>
</div>

<!-- Summary Cards -->
<div class="grid grid-4" style="margin-bottom: 2rem;">
    <div class="card" style="margin-bottom: 0;">
        <div style="color: #666; font-size: 0.875rem;">Pendapatan Hari Ini</div>
        <div style="font-size: 1.5rem; font-weight: 700; color: var(--success);">
            Rp {{ number_format($todayIncome, 0, ',', '.') }}
        </div>
    </div>
    <div class="card" style="margin-bottom: 0;">
        <div style="color: #666; font-size: 0.875rem;">Pengeluaran Hari Ini</div>
        <div style="font-size: 1.5rem; font-weight: 700; color: var(--danger);">
            Rp {{ number_format($todayExpense, 0, ',', '.') }}
        </div>
    </div>
    <div class="card" style="margin-bottom: 0;">
        <div style="color: #666; font-size: 0.875rem;">Pendapatan Bulan Ini</div>
        <div style="font-size: 1.5rem; font-weight: 700; color: var(--success);">
            Rp {{ number_format($monthlyIncome, 0, ',', '.') }}
        </div>
    </div>
    <div class="card" style="margin-bottom: 0;">
        <div style="color: #666; font-size: 0.875rem;">Laba Bersih Bulan Ini</div>
        <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">
            Rp {{ number_format($monthlyIncome - $monthlyExpense, 0, ',', '.') }}
        </div>
    </div>
</div>

<div class="grid grid-2">
    <!-- Expense Entry Form -->
    <div class="card">
        <h3 style="margin-bottom: 1.5rem;">💰 Catat Pengeluaran Baru</h3>
        
        <form action="{{ route('admin.finance.store-expense') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-control" required>
                    <option value="Bahan Baku (Kedelai)">Bahan Baku (Kedelai)</option>
                    <option value="Bahan Penolong">Bahan Penolong (Ragi/Plastik)</option>
                    <option value="Operasional">Operasional (Gas/Listrik)</option>
                    <option value="Gaji Karyawan">Gaji Karyawan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Jumlah (Rp)</label>
                <input type="number" name="jumlah" class="form-control" min="100" required placeholder="0">
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="2" placeholder="Contoh: Beli kedelai 50kg" required></textarea>
            </div>

            <button type="submit" class="btn btn-danger" style="width: 100%;">Simpan Pengeluaran</button>
        </form>
    </div>

    <!-- Recent Transactions -->
    <div class="card">
        <h3 style="margin-bottom: 1.5rem;">Riwayat Transaksi Terakhir</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Ket / Kategori</th>
                    <th style="text-align: right;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentRecords as $record)
                    <tr>
                        <td>{{ $record->tanggal->format('d/m') }}</td>
                        <td>
                            @if($record->tipe == 'pemasukan')
                                <div>Order #{{ $record->referensi_id }}</div>
                            @else
                                <div>{{ $record->kategori }}</div>
                            @endif
                            <small style="color: #888;">{{ Str::limit($record->deskripsi, 20) }}</small>
                        </td>
                        <td style="text-align: right; font-weight: 600; color: {{ $record->tipe == 'pemasukan' ? 'var(--success)' : 'var(--danger)' }};">
                            {{ $record->tipe == 'pemasukan' ? '+' : '-' }}
                            Rp {{ number_format($record->jumlah, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 2rem; color: #666;">Belum ada transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
