@extends('layouts.admin')

@section('title', 'Inventori Bahan Baku')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-serif font-bold text-gray-900 tracking-tight">Gudang Bahan Baku</h2>
            <p class="text-sm text-gray-500 mt-2 font-medium">Monitor stok, lakukan pembelian (restock), dan atur
                konversi satuan.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.materials.create') }}"
                class="px-5 py-2.5 bg-[#1e4329] hover:bg-[#163320] text-white font-bold rounded-xl shadow-lg shadow-green-900/20 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Bahan Baru
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-orange-600 text-xl">🌾
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Item</p>
                <p class="text-2xl font-bold text-gray-900">{{ $materials->count() }} Jenis</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-xl">💵
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Estimasi Aset</p>
                @php $totalAsset = $materials->sum(function($m) { return $m->harga_beli_terakhir * $m->stok_tersedia;
                }); @endphp
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalAsset / 1000000, 1, ',', '.') }}
                    Jt</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-red-600 text-xl">📉</div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Stok Menipis</p>
                <p class="text-2xl font-bold text-gray-900">{{ $materials->filter(fn($m) => $m->stok_tersedia <= $m->
                        stok_minimal)->count() }} Item</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-200 text-left">
                        <th class="px-8 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Bahan Baku</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Stok Tersedia
                        </th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider">Harga Beli (HPP)
                        </th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">
                            Status</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($materials as $material)
                    <tr class="group hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-orange-50 border border-orange-100 flex items-center justify-center text-2xl shadow-sm">
                                    📦
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 text-base">{{ $material->nama }}</div>
                                    @if($material->satuan_beli)
                                    <div class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                                        <span class="bg-gray-100 px-1.5 rounded text-gray-600">1 {{
                                            $material->satuan_beli }}</span>
                                        <span>=</span>
                                        <span class="font-medium">{{ number_format($material->rasio_konversi, 0) }} {{
                                            $material->satuan }}</span>
                                    </div>
                                    @else
                                    <div class="text-xs text-gray-400 mt-0.5">Satuan: {{ $material->satuan }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <span class="text-lg font-bold text-gray-800">{{ number_format($material->stok_tersedia,
                                    2) }}</span>
                                <span class="text-xs font-medium text-gray-500">{{ $material->satuan }}</span>
                            </div>
                            <div class="text-[10px] text-gray-400">Min: {{ number_format($material->stok_minimal, 0) }}
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="font-medium text-gray-900">Rp {{ number_format($material->harga_beli_terakhir,
                                0, ',', '.') }}</div>
                            <div class="text-xs text-gray-400">per {{ $material->satuan }}</div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($material->stok_tersedia <= 0) <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                Habis</span>
                                @elseif($material->stok_tersedia <= $material->stok_minimal)
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">Menipis</span>
                                    @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">Aman</span>
                                    @endif
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div
                                class="flex items-center justify-end gap-2 opacity-90 group-hover:opacity-100 transition-opacity">
                                <button
                                    onclick="openRestockModal({{ $material->id }}, '{{ $material->nama }}', '{{ $material->satuan }}', '{{ $material->satuan_beli }}', {{ $material->harga_beli_terakhir }}, {{ $material->rasio_konversi }})"
                                    class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-600 hover:text-white transition shadow-sm flex items-center gap-1 border border-blue-100">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Beli
                                </button>
                                <a href="{{ route('admin.materials.edit', $material) }}"
                                    class="p-2 bg-yellow-50 text-yellow-600 rounded-lg border border-yellow-100 hover:bg-yellow-500 hover:text-white transition shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            Belum ada data bahan baku.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="restockModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeRestockModal()"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">

            <div
                class="bg-gradient-to-r from-gray-50 to-white px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Catat Pembelian Stok</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Bahan: <span id="modalMaterialName"
                            class="font-bold text-primary"></span></p>
                </div>
                <button type="button" onclick="closeRestockModal()"
                    class="text-gray-400 hover:text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-full p-1 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form id="restockForm" method="POST" class="p-6 space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jumlah Dibeli</label>
                    <div class="flex rounded-xl shadow-sm">
                        <input type="number" step="0.01" name="jumlah" id="restockJumlah" oninput="calculateTotal()"
                            required
                            class="block w-full rounded-l-xl border-gray-300 focus:border-primary focus:ring-primary font-bold text-gray-900 text-lg placeholder-gray-300"
                            placeholder="0">
                        <span id="modalUnitDisplay"
                            class="inline-flex items-center px-5 rounded-r-xl border border-l-0 border-gray-300 bg-gray-50 text-gray-600 font-bold">
                            Kg
                        </span>
                    </div>
                </div>

                <div id="bulkOptionContainer" class="hidden">
                    <label
                        class="flex items-start cursor-pointer p-3 bg-blue-50 border border-blue-100 rounded-xl transition hover:bg-blue-100/50">
                        <input type="checkbox" name="use_bulk" id="useBulk" value="1"
                            class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                            onchange="toggleBulkUnit(this); calculateTotal();">
                        <div class="ml-3">
                            <span class="font-bold text-blue-800 text-sm block">Gunakan Satuan Besar (<span
                                    id="modalBulkUnit"></span>)</span>
                            <span class="text-blue-600 text-xs mt-0.5 block leading-relaxed">
                                Sistem akan otomatis mengonversi ke <strong id="modalBaseUnit"></strong> saat disimpan.
                            </span>
                        </div>
                    </label>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Total Biaya (Rp)</label>
                        <input type="number" name="harga_total" id="restockTotal" required
                            class="block w-full rounded-xl border-gray-300 focus:border-primary focus:ring-primary font-bold text-gray-900 bg-gray-50"
                            placeholder="0">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Sumber / Catatan</label>
                        <input type="text" name="keterangan"
                            class="block w-full rounded-xl border-gray-300 focus:border-primary focus:ring-primary text-sm"
                            placeholder="Cth: Pasar Induk">
                    </div>
                </div>

                <div class="mt-2 pt-4 border-t border-gray-100 flex gap-3">
                    <button type="button" onclick="closeRestockModal()"
                        class="flex-1 py-3 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-[2] py-3 bg-primary hover:bg-green-800 text-white font-bold rounded-xl shadow-lg shadow-green-900/20 transition transform hover:-translate-y-0.5 text-sm flex justify-center items-center gap-2">
                        <span>Simpan Stok Masuk</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
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
        const bulkCheckbox = document.getElementById('useBulk');
        
        // Reset checkbox state
        bulkCheckbox.checked = false;
        
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