@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

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
                <h1 class="text-2xl font-serif font-bold text-gray-900">Tambah Produk</h1>
                <p class="text-sm text-gray-500">Isi detail produk baru.</p>
            </div>
        </div>

        <div class="flex gap-3 w-full sm:w-auto">
            <a href="{{ route('admin.products.index') }}"
                class="flex-1 sm:flex-none py-2.5 px-5 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 text-center transition">
                Batal
            </a>
            <button type="submit" form="create-product-form"
                class="flex-1 sm:flex-none py-2.5 px-6 bg-[#1e4329] hover:bg-[#163320] text-white font-bold rounded-xl shadow-lg shadow-green-900/20 transition-all text-center">
                Simpan
            </button>
        </div>
    </div>

    <form id="create-product-form" action="{{ route('admin.products.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3
                        class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2 pb-4 border-b border-gray-50">
                        <span class="w-1 h-6 bg-secondary rounded-full"></span> Informasi Dasar
                    </h3>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-gray-800 placeholder-gray-400">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                            <textarea name="deskripsi" rows="4" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-gray-800 placeholder-gray-400 leading-relaxed">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Satuan <span
                                        class="text-red-500">*</span></label>
                                <select name="satuan"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white">
                                    <option value="pcs">Pcs (Biji)</option>
                                    <option value="pack">Pack</option>
                                    <option value="kg">Kg</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Masa Kadaluarsa
                                    (Hari)</label>
                                <input type="number" name="batas_kadaluarsa_hari"
                                    value="{{ old('batas_kadaluarsa_hari', 5) }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3
                        class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2 pb-4 border-b border-gray-50">
                        <span class="w-1 h-6 bg-secondary rounded-full"></span> Harga & Stok
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Jual (Satuan) <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-400 font-bold">Rp</span>
                                <input type="number" name="harga_normal" value="{{ old('harga_normal') }}" required
                                    class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-800">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Stok Awal</label>
                            <input type="number" name="stok_tersedia" value="{{ old('stok_tersedia', 0) }}" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-800">
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                        <h4 class="text-xs font-bold text-gray-500 uppercase mb-4 tracking-wider">Opsi Grosir (Opsional)
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Harga Grosir</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2.5 text-gray-400 text-xs font-bold">Rp</span>
                                    <input type="number" name="harga_grosir" value="{{ old('harga_grosir') }}"
                                        class="w-full pl-8 pr-3 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary focus:ring-1 focus:ring-primary bg-white">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Min. Pembelian</label>
                                <input type="number" name="minimal_grosir" value="{{ old('minimal_grosir') }}"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary focus:ring-1 focus:ring-primary bg-white"
                                    placeholder="Cth: 10">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <label class="flex items-center justify-between cursor-pointer group select-none">
                        <span class="flex flex-col">
                            <span class="font-bold text-gray-900 text-sm">Status Aktif</span>
                            <span class="text-xs text-gray-500 mt-0.5">Tampilkan di katalog?</span>
                        </span>
                        <div class="relative">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
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
                    <div class="w-full">
                        <label
                            class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-green-50 hover:border-primary transition-all group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <div
                                    class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-gray-400 group-hover:text-primary" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="mb-1 text-sm text-gray-500 font-medium group-hover:text-primary">Klik untuk
                                    upload</p>
                                <p class="text-xs text-gray-400">PNG, JPG (Max. 2MB)</p>
                            </div>
                            <input name="gambar" type="file" class="hidden" accept="image/*" />
                        </label>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection