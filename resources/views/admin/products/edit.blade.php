@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('admin.products.index') }}" style="color: #666; font-size: 0.875rem;">← Kembali ke Daftar Produk</a>
    <h1 style="color: var(--primary); margin-top: 0.5rem;">Edit Produk: {{ $product->nama }}</h1>
</div>

<div class="card">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-2">
            <div>
                <div class="form-group">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $product->nama) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $product->deskripsi) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Satuan</label>
                    <select name="satuan" class="form-control" required>
                        <option value="pcs" {{ $product->satuan == 'pcs' ? 'selected' : '' }}>Pcs (Biji)</option>
                        <option value="pack" {{ $product->satuan == 'pack' ? 'selected' : '' }}>Pack</option>
                        <option value="kg" {{ $product->satuan == 'kg' ? 'selected' : '' }}>Kg</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Masa Kadaluarsa (Hari)</label>
                    <input type="number" name="batas_kadaluarsa_hari" class="form-control" value="{{ old('batas_kadaluarsa_hari', $product->batas_kadaluarsa_hari) }}" required>
                </div>
            </div>

            <div>
                <div class="form-group">
                    <label class="form-label">Harga Normal (Rp)</label>
                    <input type="number" name="harga_normal" class="form-control" value="{{ old('harga_normal', $product->harga_normal) }}" required>
                </div>

                <div class="card" style="background: #f9fafb; border: 1px solid #eee;">
                    <h4 style="margin-bottom: 1rem;">Opsi Grosir (Opsional)</h4>
                    <div class="form-group">
                        <label class="form-label">Harga Grosir (Rp)</label>
                        <input type="number" name="harga_grosir" class="form-control" value="{{ old('harga_grosir', $product->harga_grosir) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Minimal Beli untuk Grosir</label>
                        <input type="number" name="minimal_grosir" class="form-control" value="{{ old('minimal_grosir', $product->minimal_grosir) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Gambar Produk</label>
                    @if($product->gambar)
                        <div style="margin-bottom: 0.5rem;">
                            <img src="{{ asset('storage/'.$product->gambar) }}" alt="Current" style="height: 100px; border-radius: 4px;">
                        </div>
                    @endif
                    <input type="file" name="gambar" class="form-control" accept="image/*">
                    <small style="color: #666;">Biarkan kosong jika tidak ingin mengubah gambar</small>
                </div>

                <div class="form-group" style="margin-top: 1rem;">
                    <label style="display: flex; align-items: center; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} style="width: 20px; height: 20px; margin-right: 0.5rem;">
                        <span>Aktifkan Produk (Tampil di Katalog)</span>
                    </label>
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #eee; display: flex; justify-content: space-between;">
            <button type="button" onclick="if(confirm('Yakin ingin menghapus produk ini?')) document.getElementById('delete-form').submit();" class="btn btn-danger">Hapus Produk</button>
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">Simpan Perubahan</button>
        </div>
    </form>

    <form id="delete-form" action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>

<!-- Stock Adjustment Section -->
<div class="card" style="margin-top: 2rem;">
    <h3 style="margin-bottom: 1rem; color: var(--primary);">Penyesuaian Stok Manual</h3>
    <div style="background: #E3F2FD; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        <strong>Stok Saat Ini: {{ $product->stok_tersedia }} {{ $product->satuan }}</strong>
    </div>

    <form action="{{ route('admin.products.adjust-stock', $product) }}" method="POST">
        @csrf
        <div class="grid grid-3">
            <div class="form-group">
                <label class="form-label">Tipe Penyesuaian</label>
                <select name="type" class="form-control" required>
                    <option value="masuk">Stok Masuk (+)</option>
                    <option value="keluar">Stok Keluar (-)</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Jumlah</label>
                <input type="number" name="amount" class="form-control" min="1" required>
            </div>
            <div class="form-group">
                <label class="form-label">Keterangan</label>
                <input type="text" name="notes" class="form-control" placeholder="Contoh: Koreksi stok, rusak, dll" required>
            </div>
        </div>
        <button type="submit" class="btn btn-secondary">Update Stok</button>
    </form>
</div>
@endsection
