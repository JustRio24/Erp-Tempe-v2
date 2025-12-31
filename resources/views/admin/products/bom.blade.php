@extends('layouts.admin')

@section('title', 'Atur Resep (BOM) - ' . $product->nama)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.products.index') }}" class="text-primary hover:underline">← Kembali ke Produk</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Atur Komposisi Bahan: {{ $product->nama }}</h1>
    <p class="text-gray-600">Tentukan berapa banyak bahan baku yang dibutuhkan untuk menghasilkan <strong>1 {{ $product->satuan }}</strong> produk jadi.</p>
</div>

<div class="card max-w-2xl">
    <form action="{{ route('admin.products.update-bom', $product) }}" method="POST">
        @csrf
        <div id="bom-container" class="space-y-4 mb-6">
            @foreach($product->consumptions as $index => $consumption)
            <div class="bom-item grid grid-cols-12 gap-4 items-end bg-gray-50 p-3 rounded-lg border border-gray-200">
                <div class="col-span-6">
                    <label class="form-label text-xs">Bahan Baku</label>
                    <select name="materials[{{ $index }}][id]" class="form-control" required>
                        @foreach($materials as $material)
                            <option value="{{ $material->id }}" {{ $consumption->material_id == $material->id ? 'selected' : '' }}>
                                {{ $material->nama }} ({{ $material->satuan }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-4">
                    <label class="form-label text-xs">Jumlah Dibutuhkan</label>
                    <input type="number" step="0.0001" name="materials[{{ $index }}][jumlah_konsumsi]" class="form-control" value="{{ $consumption->jumlah_konsumsi }}" required>
                </div>
                <div class="col-span-2">
                    <button type="button" onclick="removeBomItem(this)" class="btn btn-secondary w-full text-red-600 border-red-200 hover:bg-red-50">Hapus</button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="flex flex-col gap-4">
            <button type="button" onclick="addBomItem()" class="btn btn-secondary border-dashed border-2">+ Tambah Bahan ke Resep</button>
            <hr>
            <button type="submit" class="btn btn-primary">Simpan Resep (BOM)</button>
        </div>
    </form>
</div>

<template id="bom-template">
    <div class="bom-item grid grid-cols-12 gap-4 items-end bg-gray-50 p-3 rounded-lg border border-gray-200">
        <div class="col-span-6">
            <label class="form-label text-xs">Bahan Baku</label>
            <select name="materials[__INDEX__][id]" class="form-control" required>
                @foreach($materials as $material)
                    <option value="{{ $material->id }}">{{ $material->nama }} ({{ $material->satuan }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-4">
            <label class="form-label text-xs">Jumlah Dibutuhkan</label>
            <input type="number" step="0.0001" name="materials[__INDEX__][jumlah_konsumsi]" class="form-control" required>
        </div>
        <div class="col-span-2">
            <button type="button" onclick="removeBomItem(this)" class="btn btn-secondary w-full text-red-600 border-red-200 hover:bg-red-50">Hapus</button>
        </div>
    </div>
</template>

<script>
    let itemIndex = {{ $product->consumptions->count() }};

    function addBomItem() {
        const container = document.getElementById('bom-container');
        const template = document.getElementById('bom-template').innerHTML;
        const newItem = template.replace(/__INDEX__/g, itemIndex);
        container.insertAdjacentHTML('beforeend', newItem);
        itemIndex++;
    }

    function removeBomItem(button) {
        button.closest('.bom-item').remove();
    }
</script>
@endsection
