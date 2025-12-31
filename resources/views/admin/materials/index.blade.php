@extends('layouts.admin')

@section('title', 'Manajemen Bahan Baku')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Inventori Bahan Baku</h1>
    <a href="{{ route('admin.materials.create') }}" class="btn btn-primary">
        + Tambah Bahan Baru
    </a>
</div>

<div class="card overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Bahan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok Saat Ini</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Satuan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Stok</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($materials as $material)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="font-medium text-gray-900">{{ $material->nama }}</div>
                    <div class="text-xs text-gray-500">Min: {{ number_format($material->stok_minimal, 2) }} {{ $material->satuan }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                    {{ number_format($material->stok_tersedia, 2) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $material->satuan }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($material->stok_tersedia <= 0)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Habis</span>
                    @elseif($material->stok_tersedia <= $material->stok_minimal)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menipis</span>
                    @else
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aman</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                    <button onclick="openRestockModal({{ $material->id }}, '{{ $material->nama }}', '{{ $material->satuan }}')" class="text-green-600 hover:text-green-900">Beli Bahan</button>
                    <a href="{{ route('admin.materials.edit', $material) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    <form action="{{ route('admin.materials.destroy', $material) }}" method="POST" class="inline" onsubmit="return confirm('Hapus bahan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-gray-500">Belum ada data bahan baku.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Restock Modal -->
<div id="restockModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
        <h3 class="text-lg font-bold mb-4">Mencatat Pembelian <span id="modalMaterialName"></span></h3>
        <form id="restockForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label">Jumlah Dibeli (<span id="modalUnit"></span>)</label>
                <input type="number" step="0.01" name="jumlah" class="form-control" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Total Harga (Rp)</label>
                <input type="number" name="harga_total" class="form-control" placeholder="Akan masuk ke Pengeluaran" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Keterangan (Opsional)</label>
                <textarea name="keterangan" class="form-control" rows="2" placeholder="Misal: Beli di Pasar Induk"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeRestockModal()" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan & Berkurang Kas</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRestockModal(id, name, unit) {
        const modal = document.getElementById('restockModal');
        const form = document.getElementById('restockForm');
        document.getElementById('modalMaterialName').innerText = name;
        document.getElementById('modalUnit').innerText = unit;
        form.action = `/admin/materials/${id}/restock`;
        modal.classList.remove('hidden');
    }

    function closeRestockModal() {
        document.getElementById('restockModal').classList.add('hidden');
    }
</script>
@endsection
