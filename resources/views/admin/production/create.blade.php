@extends('layouts.admin')

@section('title', 'Mulai Batch Produksi')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="flex items-center gap-3 mb-8 text-sm text-gray-500 overflow-x-auto whitespace-nowrap pb-2">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.production.index') }}" class="hover:text-primary transition-colors">Produksi</a>
        <span>/</span>
        <span class="text-gray-900 font-bold">Batch Baru</span>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-serif font-bold text-gray-900">Mulai Batch Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Pilih produk dan tentukan target produksi untuk memulai.</p>
        </div>
        <div class="flex gap-3 w-full md:w-auto">
            <a href="{{ route('admin.production.index') }}"
                class="flex-1 md:flex-none px-6 py-3 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 text-center transition shadow-sm">
                Batal
            </a>
            <button type="submit" form="create-production-form"
                class="flex-1 md:flex-none px-6 py-3 bg-[#1e4329] hover:bg-[#163320] text-white font-bold rounded-xl shadow-lg shadow-green-900/20 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                Mulai Produksi
            </button>
        </div>
    </div>

    <form id="create-production-form" action="{{ route('admin.production.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h3
                        class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2 pb-4 border-b border-gray-50">
                        <span class="w-1 h-6 bg-secondary rounded-full"></span> Informasi Dasar
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai
                                (Peragian)</label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <input type="date" name="tanggal_mulai" value="{{ date('Y-m-d') }}" required
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-medium text-gray-800">
                            </div>
                            <p class="text-xs text-gray-400 mt-2 ml-1">Hari ini dihitung sebagai Hari ke-1.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Pilih Produk & Target
                                Output</label>

                            <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm text-left">
                                        <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-xs">
                                            <tr>
                                                <th class="px-4 py-3 text-center w-12">#</th>
                                                <th class="px-4 py-3 min-w-[150px]">Produk</th>
                                                <th class="px-4 py-3 w-40">Target</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 bg-white">
                                            @foreach($products as $product)
                                            <tr class="group hover:bg-gray-50 transition-colors">
                                                <td class="px-4 py-4 text-center">
                                                    <div class="flex justify-center">
                                                        <input type="checkbox" name="products[{{ $loop->index }}][id]"
                                                            value="{{ $product->id }}"
                                                            data-hpp="{{ $product->calculateHpp() }}"
                                                            class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer transition-transform transform group-hover:scale-110"
                                                            onchange="toggleInput(this, {{ $loop->index }})">
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <div
                                                            class="w-8 h-8 rounded-lg bg-gray-100 flex-shrink-0 flex items-center justify-center text-gray-400 border border-gray-200">
                                                            @if($product->gambar)
                                                            <img src="{{ asset('storage/'.$product->gambar) }}"
                                                                class="w-full h-full object-cover rounded-lg">
                                                            @else
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                                            </svg>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <span class="font-bold text-gray-800 block">{{
                                                                $product->nama }}</span>
                                                            <span class="text-xs text-gray-500">Stok: {{
                                                                $product->stok_tersedia }} {{ $product->satuan }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4">
                                                    <div class="relative opacity-50 transition-opacity"
                                                        id="input-container-{{ $loop->index }}">
                                                        <input type="number" name="products[{{ $loop->index }}][jumlah]"
                                                            class="qty-input w-full pl-3 pr-10 py-2 rounded-lg border border-gray-200 text-sm focus:border-primary focus:ring-1 focus:ring-primary disabled:bg-gray-50 disabled:cursor-not-allowed font-bold"
                                                            min="1" disabled placeholder="0"
                                                            oninput="updateEstimation()">
                                                        <span
                                                            class="absolute right-3 top-2 text-xs text-gray-400 font-bold">{{
                                                            $product->satuan }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Batch
                                (Opsional)</label>
                            <textarea name="catatan" rows="2"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 placeholder-gray-400 transition-all leading-relaxed"
                                placeholder="Contoh: Kedelai supplier A, cuaca mendung..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">

                <div
                    class="bg-gradient-to-br from-green-50 to-white rounded-2xl shadow-sm border border-green-100 p-6 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 -mt-4 -mr-4 w-20 h-20 bg-green-100 rounded-full blur-xl opacity-50">
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-4 pb-4 border-b border-green-100">
                            <div
                                class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-green-600 shadow-sm border border-green-50">
                                💰
                            </div>
                            <h4 class="font-bold text-green-800 text-sm uppercase tracking-wide">Estimasi Biaya</h4>
                        </div>

                        <div class="text-center py-2">
                            <p class="text-xs text-green-600 font-medium mb-1">Total Modal Bahan Baku (HPP)</p>
                            <p id="totalCost" class="text-3xl font-serif font-bold text-green-900">Rp 0</p>
                        </div>

                        <div class="mt-4 flex items-start gap-2 bg-green-100/50 p-3 rounded-lg">
                            <svg class="w-4 h-4 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-[10px] text-green-700 leading-snug">
                                Biaya dihitung otomatis berdasarkan Resep (BOM) setiap produk dan harga beli bahan baku
                                terakhir.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-6">Workflow Produksi</h4>

                    <div class="space-y-0 relative pl-2">
                        <div class="absolute left-[9px] top-2 bottom-6 w-0.5 bg-gray-100"></div>

                        <div class="flex gap-4 relative z-10 pb-6">
                            <div
                                class="flex-shrink-0 w-5 h-5 rounded-full bg-blue-600 border-2 border-white shadow-sm mt-0.5 ring-4 ring-blue-50">
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">Inisiasi (Pending)</p>
                                <p class="text-xs text-gray-500 leading-snug mt-0.5">Batch dibuat. Stok bahan baku
                                    <strong class="text-gray-700">belum</strong> dikurangi.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4 relative z-10 pb-6">
                            <div
                                class="flex-shrink-0 w-5 h-5 rounded-full bg-gray-200 border-2 border-white shadow-sm mt-0.5">
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-400">Proses</p>
                                <p class="text-xs text-gray-400 leading-snug mt-0.5">Saat mulai, stok bahan baku
                                    otomatis terpotong sesuai resep.</p>
                            </div>
                        </div>

                        <div class="flex gap-4 relative z-10">
                            <div
                                class="flex-shrink-0 w-5 h-5 rounded-full bg-gray-200 border-2 border-white shadow-sm mt-0.5">
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-400">Selesai (Panen)</p>
                                <p class="text-xs text-gray-400 leading-snug mt-0.5">Stok produk jadi bertambah ke
                                    gudang.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    function toggleInput(checkbox, index) {
    const inputContainer = document.getElementById(`input-container-${index}`);
    const inputs = document.querySelectorAll(`input[name="products[${index}][jumlah]"]`);
    
    inputs.forEach(input => {
        input.disabled = !checkbox.checked;
        if (checkbox.checked) {
            inputContainer.classList.remove('opacity-50');
            input.focus();
            input.required = true;
        } else {
            inputContainer.classList.add('opacity-50');
            input.value = '';
            input.required = false;
        }
    });
    updateEstimation();
}

function updateEstimation() {
    let total = 0;
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const checkbox = row.querySelector('input[type="checkbox"]');
        const qtyInput = row.querySelector('.qty-input');
        
        if (checkbox && checkbox.checked) {
            const hpp = parseFloat(checkbox.dataset.hpp) || 0;
            const qty = parseFloat(qtyInput.value) || 0;
            total += hpp * qty;
        }
    });
    
    document.getElementById('totalCost').innerText = 'Rp ' + total.toLocaleString('id-ID');
}
</script>
@endsection