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
                                           style="width: 18px; height: 18px;" onchange="toggleInput(this, {{ $loop->index }})">
                                </td>
                                <td>
                                    <strong>{{ $product->nama }}</strong>
                                    <div style="font-size: 0.875rem; color: #666;">Stok saat ini: {{ $product->stok_tersedia }} {{ $product->satuan }}</div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <input type="number" name="products[{{ $loop->index }}][jumlah]" class="form-control qty-input" 
                                               min="1" disabled placeholder="0" style="width: 100px;">
                                        <span>{{ $product->satuan }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
}
</script>
@endsection
