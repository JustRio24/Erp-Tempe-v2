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
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga/Unit (HPP)</th>
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
                    @if($material->satuan_beli)
                    <div class="text-[10px] text-gray-400">1 {{ $material->satuan_beli }} = {{ number_format($material->rasio_konversi, 0) }} {{ $material->satuan }}</div>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    Rp {{ number_format($material->harga_beli_terakhir, 0, ',', '.') }}
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
                    <button onclick="openRestockModal({{ $material->id }}, '{{ $material->nama }}', '{{ $material->satuan }}', '{{ $material->satuan_beli }}', {{ $material->harga_beli_terakhir }}, {{ $material->rasio_konversi }})" class="text-green-600 hover:text-green-900">Beli Bahan</button>
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
                <label class="form-label">Jumlah Dibeli</label>
                <div class="flex gap-2 items-center">
                    <input type="number" step="0.01" name="jumlah" id="restockJumlah" class="form-control" oninput="calculateTotal()" required>
                    <span id="modalUnitDisplay" class="text-sm font-bold text-gray-700"></span>
                </div>
            </div>
            @if(true) {{-- We will handle visibility via JS --}}
            <div id="bulkOptionContainer" class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-100 hidden">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="use_bulk" id="useBulk" value="1" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" onchange="toggleBulkUnit(this); calculateTotal();">
                    <span class="ml-2 text-sm font-medium text-blue-800">Beli dalam satuan besar (<span id="modalBulkUnit"></span>)</span>
                </label>
                <p class="text-[10px] text-blue-600 mt-1">* Stok akan otomatis dikonversi ke <span id="modalBaseUnit"></span></p>
            </div>
            @endif
            <div class="mb-4">
                <label class="form-label">Total Harga (Rp)</label>
                <input type="number" name="harga_total" id="restockTotal" class="form-control" placeholder="Akan masuk ke Pengeluaran" required>
                <p class="text-[10px] text-gray-400 mt-1 italic">* Diisi otomatis berdasarkan harga beli terakhir</p>
            </div>
            <div class="mb-4">
                <label class="form-label">Keterangan (Opsional)</label>
                <textarea name="keterangan" class="form-control" rows="2" placeholder="Misal: Beli di Pasar Induk"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeRestockModal()" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan & Catat Biaya</button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentBaseUnit = '';
    let currentBulkUnit = '';
    let currentPrice = 0;
    let currentRatio = 1;

    function openRestockModal(id, name, unit, bulkUnit = null, price = 0, ratio = 1) {
        const modal = document.getElementById('restockModal');
        const form = document.getElementById('restockForm');
        document.getElementById('modalMaterialName').innerText = name;
        
        currentBaseUnit = unit;
        currentBulkUnit = bulkUnit;
        currentPrice = price;
        currentRatio = ratio;
        
        document.getElementById('modalUnitDisplay').innerText = unit;
        document.getElementById('modalBaseUnit').innerText = unit;
        
        const bulkContainer = document.getElementById('bulkOptionContainer');
        if (bulkUnit && bulkUnit !== '') {
            bulkContainer.classList.remove('hidden');
            document.getElementById('modalBulkUnit').innerText = bulkUnit;
        } else {
            bulkContainer.classList.add('hidden');
        }

        form.action = `/admin/materials/${id}/restock`;
        modal.classList.remove('hidden');
    }

    function calculateTotal() {
        const jumlahInput = document.getElementById('restockJumlah').value;
        const useBulk = document.getElementById('useBulk').checked;
        const totalInput = document.getElementById('restockTotal');
        
        if (!jumlahInput || jumlahInput <= 0) {
            totalInput.value = '';
            return;
        }

        if (currentPrice > 0) {
            let total = 0;
            if (useBulk) {
                total = jumlahInput * currentRatio * currentPrice;
            } else {
                total = jumlahInput * currentPrice;
            }
            totalInput.value = Math.round(total);
        }
    }

    function toggleBulkUnit(checkbox) {
        const display = document.getElementById('modalUnitDisplay');
        display.innerText = checkbox.checked ? currentBulkUnit : currentBaseUnit;
    }

    function closeRestockModal() {
        document.getElementById('restockModal').classList.add('hidden');
        document.getElementById('restockForm').reset();
    }
</script>
@endsection
