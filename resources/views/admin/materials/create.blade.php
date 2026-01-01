@extends('layouts.admin')

@section('title', 'Tambah Bahan Baku')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.materials.index') }}" class="text-primary hover:underline">← Kembali ke Daftar</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Tambah Bahan Baku Baru</h1>
</div>

<div class="card max-w-lg">
    <form action="{{ route('admin.materials.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="form-label">Nama Bahan Baku</label>
            <input type="text" name="nama" class="form-control" placeholder="Contoh: Kedelai Impor" required>
        </div>

        <div class="mb-4">
            <label class="form-label">Harga Beli Terakhir (Rp per Satuan Kecil)</label>
            <input type="number" step="1" name="harga_beli_terakhir" class="form-control" placeholder="Contoh: 9800" required>
            <p class="text-[10px] text-gray-400 mt-1">Harga ini akan menjadi acuan modal (HPP) produk.</p>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="form-label">Satuan</label>
                <select name="satuan" class="form-control" required>
                    <option value="kg">Kg</option>
                    <option value="gram">Gram</option>
                    <option value="liter">Liter</option>
                    <option value="pcs">Pcs / Buah</option>
                    <option value="ball">Ball</option>
                </select>
            </div>
            <div>
                <label class="form-label">Stok Minimal</label>
                <input type="number" step="0.01" name="stok_minimal" class="form-control" value="0" required>
                <p class="text-xs text-gray-500 mt-1">Peringatan jika stok di bawah angka ini.</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="form-label">Satuan Beli Besar (Opsional)</label>
                <input type="text" name="satuan_beli" class="form-control" placeholder="Misal: Karung">
            </div>
            <div>
                <label class="form-label">Isi per Satuan Beli</label>
                <input type="number" step="0.01" name="rasio_konversi" class="form-control" value="1">
                <p class="text-[10px] text-gray-400 mt-1">Contoh: 1 Karung = 50kg. Isi 50.</p>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-full">Simpan Bahan Baku</button>
    </form>
</div>
@endsection
