@extends('layouts.admin')

@section('title', 'Edit Bahan Baku')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.materials.index') }}" class="text-primary hover:underline">← Kembali ke Daftar</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Edit Bahan Baku: {{ $material->nama }}</h1>
</div>

<div class="card max-w-lg">
    <form action="{{ route('admin.materials.update', $material) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="form-label">Nama Bahan Baku</label>
            <input type="text" name="nama" class="form-control" value="{{ $material->nama }}" required>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="form-label">Satuan</label>
                <select name="satuan" class="form-control" required>
                    <option value="kg" {{ $material->satuan == 'kg' ? 'selected' : '' }}>Kg</option>
                    <option value="gram" {{ $material->satuan == 'gram' ? 'selected' : '' }}>Gram</option>
                    <option value="liter" {{ $material->satuan == 'liter' ? 'selected' : '' }}>Liter</option>
                    <option value="pcs" {{ $material->satuan == 'pcs' ? 'selected' : '' }}>Pcs / Buah</option>
                    <option value="ball" {{ $material->satuan == 'ball' ? 'selected' : '' }}>Ball</option>
                </select>
            </div>
            <div>
                <label class="form-label">Stok Minimal</label>
                <input type="number" step="0.01" name="stok_minimal" class="form-control" value="{{ $material->stok_minimal }}" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-full">Perbarui Bahan Baku</button>
    </form>
</div>
@endsection
