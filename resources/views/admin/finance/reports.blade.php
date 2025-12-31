@extends('layouts.admin')

@section('title', 'Laporan Keuangan Detail')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('admin.finance.index') }}" style="color: #666; font-size: 0.875rem;">← Kembali ke Ringkasan</a>
    <h1 style="color: var(--primary); margin-top: 0.5rem;">Laporan Laba Rugi</h1>
</div>

<!-- Filter -->
<div class="card">
    <form action="{{ route('admin.finance.reports') }}" method="GET" style="display: flex; gap: 1rem; align-items: end;">
        <div style="flex: 1;">
            <label class="form-label">Dari Tanggal</label>
            <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
        </div>
        <div style="flex: 1;">
            <label class="form-label">Sampai Tanggal</label>
            <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
        </div>
        <button type="submit" class="btn btn-primary" style="height: 46px;">Tampilkan Laporan</button>
    </form>
</div>

<div class="grid grid-2">
    <!-- Report Summary -->
    <div class="card">
        <h3 style="margin-bottom: 1.5rem; text-align: center;">Ringkasan Periode Ini</h3>
        
        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px dashed #ddd;">
            <span>Total Pemasukan (Omzet)</span>
            <span style="color: var(--success); font-weight: 600;">Rp {{ number_format($totalIncome, 0, ',', '.') }}</span>
        </div>
        
        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #ddd;">
            <span>Total Pengeluaran</span>
            <span style="color: var(--danger); font-weight: 600;">(Rp {{ number_format($totalExpense, 0, ',', '.') }})</span>
        </div>
        
        <div style="display: flex; justify-content: space-between; font-size: 1.5rem; font-weight: 700;">
            <span>Laba Bersih</span>
            <span style="color: {{ $profit >= 0 ? 'var(--primary)' : 'var(--danger)' }};">
                Rp {{ number_format($profit, 0, ',', '.') }}
            </span>
        </div>
    </div>

    <!-- Expense Breakdown -->
    <div class="card">
        <h3 style="margin-bottom: 1.5rem;">Rincian Pengeluaran</h3>
        
        @if(count($expensesByCategory) > 0)
            <table style="width: 100%;">
                @foreach($expensesByCategory as $category => $amount)
                    <tr>
                        <td style="padding: 0.5rem 0; border-bottom: 1px solid #eee;">{{ $category }}</td>
                        <td style="padding: 0.5rem 0; border-bottom: 1px solid #eee; text-align: right; color: var(--danger);">
                            Rp {{ number_format($amount, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <p style="text-align: center; color: #666; padding: 1rem;">Tidak ada pengeluaran pada periode ini</p>
        @endif
    </div>
</div>

<!-- Detailed Table -->
<div class="card">
    <h3 style="margin-bottom: 1rem;">Rincian Transaksi</h3>
    
    <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Tipe</th>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <!-- Income -->
                @foreach($income as $inc)
                    <tr>
                        <td>{{ $inc->tanggal->format('d/m/Y') }}</td>
                        <td><span class="badge" style="background: #E8F5E9; color: #2E7D32;">Pemasukan</span></td>
                        <td>{{ $inc->deskripsi }}</td>
                        <td style="text-align: right; color: var(--success);">Rp {{ number_format($inc->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                
                <!-- Expenses -->
                @foreach($expenses as $exp)
                    <tr>
                        <td>{{ $exp->tanggal->format('d/m/Y') }}</td>
                        <td><span class="badge" style="background: #FFEBEE; color: #C62828;">Pengeluaran</span></td>
                        <td>{{ $exp->kategori }} - {{ $exp->deskripsi }}</td>
                        <td style="text-align: right; color: var(--danger);">Rp {{ number_format($exp->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
