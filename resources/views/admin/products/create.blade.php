@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('admin.products.index') }}" style="color: #666; font-size: 0.875rem;">← Kembali ke Daftar Produk</a>
    <h1 style="color: var(--primary); margin-top: 0.5rem;">Tambah Produk Baru</h1>
</div>

<div class="card">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-2">
            <div>
                <div class="form-group">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Satuan</label>
                    <select name="satuan" class="form-control" required>
                        <option value="pcs">Pcs (Biji)</option>
                        <option value="pack">Pack</option>
                        <option value="kg">Kg</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Masa Kadaluarsa (Hari)</label>
                    <input type="number" name="batas_kadaluarsa_hari" class="form-control" value="{{ old('batas_kadaluarsa_hari', 5) }}" required>
                    <small style="color: #666;">Standar tempe: 3-5 hari</small>
                </div>
            </div>

            <div>
                <div class="form-group">
                    <label class="form-label">Harga Normal (Rp)</label>
                    <input type="number" name="harga_normal" class="form-control" value="{{ old('harga_normal') }}" required>
                </div>

                <div class="card" style="background: #f9fafb; border: 1px solid #eee;">
                    <h4 style="margin-bottom: 1rem;">Opsi Grosir (Opsional)</h4>
                    <div class="form-group">
                        <label class="form-label">Harga Grosir (Rp)</label>
                        <input type="number" name="harga_grosir" class="form-control" value="{{ old('harga_grosir') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Minimal Beli untuk Grosir</label>
                        <input type="number" name="minimal_grosir" class="form-control" value="{{ old('minimal_grosir') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Stok Awal</label>
                    <input type="number" name="stok_tersedia" class="form-control" value="{{ old('stok_tersedia', 0) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Gambar Produk</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*">
                </div>

                <div class="form-group" style="margin-top: 1rem;">
                    <label style="display: flex; align-items: center; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width: 20px; height: 20px; margin-right: 0.5rem;">
                        <span>Aktifkan Produk (Tampil di Katalog)</span>
                    </label>
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #eee; text-align: right;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">Simpan Produk</button>
        </div>
    </form>
</div>
@endsection
