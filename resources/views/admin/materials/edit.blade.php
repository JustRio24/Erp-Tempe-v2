@extends('layouts.admin')

@section('title', 'Edit Bahan Baku')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex items-center gap-3 mb-8 text-sm text-gray-500">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.materials.index') }}" class="hover:text-primary">Bahan Baku</a>
        <span>/</span>
        <span class="text-gray-900 font-bold">Edit</span>
    </div>

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-serif font-bold text-gray-900">Edit Bahan Baku</h1>
            <p class="text-sm text-gray-500">Perbarui data: <strong>{{ $material->nama }}</strong></p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.materials.index') }}"
                class="px-5 py-2.5 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" form="edit-material-form"
                class="px-6 py-2.5 bg-[#1e4329] hover:bg-[#163320] text-white font-bold rounded-xl shadow-lg shadow-green-900/20 transition-all transform hover:-translate-y-0.5">
                Simpan Perubahan
            </button>
        </div>
    </div>

    <form id="edit-material-form" action="{{ route('admin.materials.update', $material) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-1 h-6 bg-secondary rounded-full"></span> Informasi Dasar
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Bahan Baku <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama', $material->nama) }}" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-medium text-gray-800">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Beli Terakhir (HPP)
                                <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-400 font-bold">Rp</span>
                                <input type="number" name="harga_beli_terakhir"
                                    value="{{ old('harga_beli_terakhir', round($material->harga_beli_terakhir)) }}"
                                    required
                                    class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-bold text-gray-800 text-lg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wider">Spesifikasi Stok</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Satuan Dasar <span
                                    class="text-red-500">*</span></label>
                            <select name="satuan"
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white font-medium"
                                required>
                                <option value="kg" {{ $material->satuan == 'kg' ? 'selected' : '' }}>Kg</option>
                                <option value="gram" {{ $material->satuan == 'gram' ? 'selected' : '' }}>Gram</option>
                                <option value="liter" {{ $material->satuan == 'liter' ? 'selected' : '' }}>Liter
                                </option>
                                <option value="pcs" {{ $material->satuan == 'pcs' ? 'selected' : '' }}>Pcs / Buah
                                </option>
                                <option value="ball" {{ $material->satuan == 'ball' ? 'selected' : '' }}>Ball</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Stok Minimal
                                (Alert)</label>
                            <input type="number" step="0.01" name="stok_minimal"
                                value="{{ old('stok_minimal', $material->stok_minimal) }}" required
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50/50 rounded-2xl shadow-sm border border-blue-100 p-6">
                    <div class="flex items-center gap-2 mb-4 border-b border-blue-100 pb-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        <h4 class="text-sm font-bold text-blue-800 uppercase tracking-wide">Konversi Satuan Beli</h4>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Satuan Beli Besar</label>
                            <input type="text" name="satuan_beli"
                                value="{{ old('satuan_beli', $material->satuan_beli) }}" placeholder="Misal: Karung"
                                class="w-full px-3 py-2 rounded-lg border border-blue-200 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Isi per Satuan Beli</label>
                            <input type="number" step="0.01" name="rasio_konversi"
                                value="{{ old('rasio_konversi', $material->rasio_konversi) }}"
                                class="w-full px-3 py-2 rounded-lg border border-blue-200 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-white">
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200">
                    <button type="button"
                        onclick="if(confirm('Yakin ingin menghapus bahan ini? Data historis juga akan terhapus.')) document.getElementById('delete-form').submit();"
                        class="w-full py-3 text-red-600 font-bold text-sm hover:bg-red-50 rounded-xl transition">
                        Hapus Bahan Ini
                    </button>
                </div>

            </div>
        </div>
    </form>

    <form id="delete-form" action="{{ route('admin.materials.destroy', $material) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection