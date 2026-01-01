@extends('layouts.admin')

@section('title', 'Mulai Batch Produksi')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('admin.production.index') }}" style="color: #666; font-size: 0.875rem;">← Kembali ke Daftar Produksi</a>
    <h1 style="color: var(--primary); margin-top: 0.5rem;">Mulai Batch Produksi Baru</h1>
</div>

<div class="card">
    <form action="{{ route('admin.production.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Tanggal Mulai (Peragian)</label>
            <input type="date" name="tanggal_mulai" class="form-control" value="{{ date('Y-m-d') }}" style="max-width: 200px;" required>
            <small style="color: #666;">Hari ini dihitung sebagai Hari ke-1</small>
        </div>

        <div class="form-group">
            <label class="form-label">Pilih Produk & Jumlah Target</label>
            <div style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
                <table class="table">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th style="width: 50px;">Pilih</th>
                            <th>Produk</th>
                            <th style="width: 200px;">Jumlah Target (Unit)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td style="text-align: center;">
                                    <input type="checkbox" name="products[{{ $loop->index }}][id]" value="{{ $product->id }}" 
                                           data-hpp="{{ $product->calculateHpp() }}"
                                           style="width: 18px; height: 18px;" onchange="toggleInput(this, {{ $loop->index }})">
                                </td>
                                <td>
                                    <strong>{{ $product->nama }}</strong>
                                    <div style="font-size: 0.875rem; color: #666;">Stok saat ini: {{ $product->stok_tersedia }} {{ $product->satuan }}</div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <input type="number" name="products[{{ $loop->index }}][jumlah]" class="form-control qty-input" 
                                               min="1" disabled placeholder="0" style="width: 100px;" oninput="updateEstimation()">
                                        <span>{{ $product->satuan }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-group" style="background: #f1f8e9; padding: 1.5rem; border-radius: 12px; margin-top: 1rem; border-left: 5px solid #4caf50;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h4 style="margin: 0; color: #2e7d32; display: flex; align-items: center; gap: 0.5rem;">
                        💰 Estimasi Biaya Bahan Baku
                    </h4>
                    <p style="margin: 0.25rem 0 0 0; font-size: 0.875rem; color: #666;">Berdasarkan BOM dan Harga Beli Terakhir</p>
                </div>
                <div style="text-align: right;">
                    <div id="totalCost" style="font-size: 1.5rem; font-weight: 800; color: #1b5e20;">Rp 0</div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Catatan Batch (Opsional)</label>
            <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: Kedelai supplier A, cuaca mendung, dll"></textarea>
        </div>

        <div style="margin-top: 2rem; text-align: right;">
            <button type="submit" class="btn btn-primary" style="padding: 1rem 2rem; font-size: 1.1rem;">🚀 Mulai Produksi</button>
        </div>
    </form>
</div>

<script>
function toggleInput(checkbox, index) {
    const inputs = document.querySelectorAll(`input[name="products[${index}][jumlah]"]`);
    inputs.forEach(input => {
        input.disabled = !checkbox.checked;
        if (checkbox.checked) {
            input.focus();
            input.required = true;
        } else {
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
