@extends('layouts.admin')

@section('title', 'Atur Resep (BOM)')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <div class="text-center mb-10">
        <div
            class="inline-flex items-center justify-center w-16 h-16 bg-green-100 text-green-700 rounded-2xl mb-4 shadow-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                </path>
            </svg>
        </div>
        <h1 class="text-3xl font-serif font-bold text-gray-900 mb-2">Resep Produksi</h1>
        <p class="text-gray-500">
            Komposisi bahan untuk membuat <span class="font-bold text-gray-800">1 {{ $product->satuan }} {{
                $product->nama }}</span>
        </p>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/60 border border-gray-100 overflow-hidden">

        <div class="bg-gray-50 px-8 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-700 text-sm uppercase tracking-wide">Daftar Bahan Baku</h3>
            <span class="bg-white border border-gray-200 text-xs font-bold px-3 py-1 rounded-full text-gray-500">
                Total Bahan: <span id="item-count">{{ $product->consumptions->count() }}</span>
            </span>
        </div>

        <form action="{{ route('admin.products.update-bom', $product) }}" method="POST" class="p-8">
            @csrf

            <div id="bom-container" class="space-y-4 mb-8 min-h-[100px]">
                @forelse($product->consumptions as $index => $consumption)
                <div
                    class="bom-item group flex gap-4 items-center bg-white p-4 rounded-2xl border border-gray-200 shadow-sm hover:border-green-400 hover:shadow-md transition-all duration-300">
                    <div class="flex-1">
                        <label
                            class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Bahan</label>
                        <select name="materials[{{ $index }}][id]"
                            class="w-full border-none p-0 focus:ring-0 text-gray-800 font-bold bg-transparent cursor-pointer"
                            required>
                            @foreach($materials as $material)
                            <option value="{{ $material->id }}" {{ $consumption->material_id == $material->id ?
                                'selected' : '' }}>
                                {{ $material->nama }} ({{ $material->satuan }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-32 border-l border-gray-100 pl-4">
                        <label
                            class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Jumlah</label>
                        <input type="number" step="0.0001" name="materials[{{ $index }}][jumlah_konsumsi]"
                            class="w-full border-none p-0 focus:ring-0 text-gray-800 font-bold bg-transparent text-right"
                            value="{{ $consumption->jumlah_konsumsi }}" required>
                    </div>

                    <button type="button" onclick="removeBomItem(this)"
                        class="p-2 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-full transition ml-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </button>
                </div>
                @empty
                <div id="empty-state" class="text-center py-8">
                    <p class="text-gray-400 text-sm">Belum ada bahan baku yang ditambahkan.</p>
                </div>
                @endforelse
            </div>

            <div class="flex flex-col gap-3">
                <button type="button" onclick="addBomItem()"
                    class="w-full py-3 border-2 border-dashed border-gray-200 rounded-xl text-gray-500 font-bold hover:border-green-500 hover:text-green-600 hover:bg-green-50 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Bahan Baku
                </button>

                <div class="flex items-center gap-4 mt-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.products.index') }}"
                        class="flex-1 py-3 text-center text-gray-500 font-bold hover:bg-gray-50 rounded-xl transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex-[2] py-3 bg-[#1e4329] hover:bg-[#163320] text-white font-bold rounded-xl shadow-lg shadow-green-900/20 transition-all transform hover:-translate-y-0.5">
                        Simpan Resep
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<template id="bom-template">
    <div
        class="bom-item group flex gap-4 items-center bg-white p-4 rounded-2xl border border-gray-200 shadow-sm hover:border-green-400 hover:shadow-md transition-all duration-300 animate-fade-in-up">
        <div class="flex-1">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Bahan</label>
            <select name="materials[__INDEX__][id]"
                class="w-full border-none p-0 focus:ring-0 text-gray-800 font-bold bg-transparent cursor-pointer"
                required>
                <option value="" disabled selected>Pilih Bahan...</option>
                @foreach($materials as $material)
                <option value="{{ $material->id }}">{{ $material->nama }} ({{ $material->satuan }})</option>
                @endforeach
            </select>
        </div>

        <div class="w-32 border-l border-gray-100 pl-4">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Jumlah</label>
            <input type="number" step="0.0001" name="materials[__INDEX__][jumlah_konsumsi]"
                class="w-full border-none p-0 focus:ring-0 text-gray-800 font-bold bg-transparent text-right"
                placeholder="0" required>
        </div>

        <button type="button" onclick="removeBomItem(this)"
            class="p-2 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-full transition ml-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                </path>
            </svg>
        </button>
    </div>
</template>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.3s ease-out forwards;
    }
</style>

<script>
    let itemIndex = {{ $product->consumptions->count() }};

    function addBomItem() {
        // Remove empty state if exists
        const emptyState = document.getElementById('empty-state');
        if(emptyState) emptyState.remove();

        const container = document.getElementById('bom-container');
        const template = document.getElementById('bom-template').innerHTML;
        const newItem = template.replace(/__INDEX__/g, itemIndex);
        container.insertAdjacentHTML('beforeend', newItem);
        itemIndex++;
        updateCount();
    }

    function removeBomItem(button) {
        button.closest('.bom-item').remove();
        updateCount();
    }

    function updateCount() {
        const count = document.querySelectorAll('.bom-item').length;
        document.getElementById('item-count').textContent = count;
    }
</script>
@endsection