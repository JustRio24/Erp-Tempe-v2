@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.index') }}"
                class="p-2 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition shadow-sm">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-serif font-bold text-gray-900">Edit Produk</h1>
                <p class="text-sm text-gray-500">Perbarui data: <strong>{{ $product->nama }}</strong></p>
            </div>
        </div>

        <div class="flex gap-3 w-full sm:w-auto">
            <a href="{{ route('admin.products.index') }}"
                class="flex-1 sm:flex-none py-2.5 px-5 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 text-center transition">
                Kembali
            </a>
            <button type="submit" form="edit-product-form"
                class="flex-1 sm:flex-none py-2.5 px-6 bg-[#1e4329] hover:bg-[#163320] text-white font-bold rounded-xl shadow-lg shadow-green-900/20 transition-all text-center">
                Simpan
            </button>
        </div>
    </div>

    <form id="edit-product-form" action="{{ route('admin.products.update', $product) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 mb-10">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3
                        class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2 pb-4 border-b border-gray-50">
                        <span class="w-1 h-6 bg-secondary rounded-full"></span> Informasi Dasar
                    </h3>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk</label>
                            <input type="text" name="nama" value="{{ old('nama', $product->nama) }}" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-gray-800">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                            <textarea name="deskripsi" rows="5" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-gray-800 leading-relaxed">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Satuan</label>
                                <select name="satuan"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white">
                                    <option value="pcs" {{ $product->satuan == 'pcs' ? 'selected' : '' }}>Pcs (Biji)
                                    </option>
                                    <option value="pack" {{ $product->satuan == 'pack' ? 'selected' : '' }}>Pack
                                    </option>
                                    <option value="kg" {{ $product->satuan == 'kg' ? 'selected' : '' }}>Kg</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Ketahanan (Hari)</label>
                                <input type="number" name="batas_kadaluarsa_hari"
                                    value="{{ old('batas_kadaluarsa_hari', $product->batas_kadaluarsa_hari) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3
                        class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2 pb-4 border-b border-gray-50">
                        <span class="w-1 h-6 bg-secondary rounded-full"></span> Harga
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Jual (Satuan)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-400 font-bold">Rp</span>
                                <input type="number" name="harga_normal"
                                    value="{{ old('harga_normal', $product->harga_normal) }}" required
                                    class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-bold text-lg text-gray-800">
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                        <h4 class="text-xs font-bold text-gray-500 uppercase mb-4 tracking-wider">Opsi Grosir</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Harga Grosir</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2.5 text-gray-400 text-xs font-bold">Rp</span>
                                    <input type="number" name="harga_grosir"
                                        value="{{ old('harga_grosir', $product->harga_grosir) }}"
                                        class="w-full pl-8 pr-3 py-2 rounded-lg border border-gray-300 text-sm bg-white focus:border-primary focus:ring-1 focus:ring-primary">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Min. Pembelian</label>
                                <input type="number" name="minimal_grosir"
                                    value="{{ old('minimal_grosir', $product->minimal_grosir) }}"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm bg-white focus:border-primary focus:ring-1 focus:ring-primary">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <label class="flex items-center justify-between cursor-pointer group select-none">
                        <span class="font-bold text-gray-900 text-sm">Status Aktif</span>
                        <div class="relative">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{
                                $product->is_active ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600">
                            </div>
                        </div>
                    </label>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3
                        class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wider border-b border-gray-50 pb-2">
                        Gambar Produk</h3>

                    @if($product->gambar)
                    <div class="relative w-full h-48 rounded-xl overflow-hidden mb-4 group border border-gray-200">
                        <img src="{{ asset('storage/'.$product->gambar) }}" class="w-full h-full object-cover">
                        <div
                            class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-white text-xs font-bold">
                            Gambar Saat Ini
                        </div>
                    </div>
                    @endif

                    <div class="w-full">
                        <label
                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-green-50 hover:border-primary transition-all">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <p class="text-xs text-gray-500 font-medium">Ganti Gambar (Opsional)</p>
                            </div>
                            <input name="gambar" type="file" class="hidden" accept="image/*" />
                        </label>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200">
                    <button type="button"
                        onclick="if(confirm('Yakin ingin menghapus?')) document.getElementById('delete-form').submit();"
                        class="w-full py-3 text-red-600 font-bold text-sm hover:bg-red-50 rounded-xl transition">
                        Hapus Produk Ini
                    </button>
                </div>

            </div>
        </div>
    </form>

    <div class="mt-8 max-w-4xl mx-auto">
        <h3 class="text-xl font-bold text-gray-900 mb-4 text-center">Manajemen Stok Cepat</h3>
        <div class="bg-white rounded-2xl shadow-lg shadow-blue-900/5 border border-blue-100 p-6 sm:p-8">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900">Penyesuaian Stok Manual</h3>
                    <p class="text-xs text-gray-500">Stok Sistem Saat Ini: <span
                            class="text-blue-700 font-bold text-sm">{{ $product->stok_tersedia }} {{ $product->satuan
                            }}</span></p>
                </div>
            </div>

            <form action="{{ route('admin.products.adjust-stock', $product) }}" method="POST"
                class="flex flex-col md:flex-row gap-4 items-end">
                @csrf
                <div class="w-full md:w-1/3">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tipe</label>
                    <select name="tipe"
                        class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
                        <option value="masuk">➕ Barang Masuk (Restock)</option>
                        <option value="keluar">➖ Barang Keluar (Rusak/Hilang)</option>
                    </select>
                </div>
                <div class="w-full md:w-1/4">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Jumlah</label>
                    <input type="number" name="jumlah"
                        class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm"
                        placeholder="0" required min="1">
                </div>
                <div class="w-full md:w-1/3">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Catatan</label>
                    <input type="text" name="keterangan"
                        class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm"
                        placeholder="Cth: Stok Opname" required>
                </div>
                <div class="w-full md:w-auto">
                    <button type="submit"
                        class="w-full py-2.5 px-6 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md transition text-sm">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <form id="delete-form" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection