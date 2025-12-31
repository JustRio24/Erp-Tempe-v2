@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container">
    <h1 style="color: var(--primary); margin-bottom: 2rem;">Checkout Pesanan</h1>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="grid grid-2">
            <div>
                <div class="card">
                    <h3 style="margin-bottom: 1.5rem;">Data Pembeli</h3>
                    
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap *</label>
                        <input type="text" name="nama_pembeli" class="form-control" value="{{ old('nama_pembeli') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email_pembeli" class="form-control" value="{{ old('email_pembeli') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor Telepon *</label>
                        <input type="tel" name="telepon_pembeli" class="form-control" value="{{ old('telepon_pembeli') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap *</label>
                        <textarea name="alamat_pembeli" class="form-control" rows="4" required>{{ old('alamat_pembeli') }}</textarea>
                    </div>
                </div>

                <div class="card">
                    <h3 style="margin-bottom: 1.5rem;">Metode Pengiriman</h3>
                    
                    @foreach($shippingMethods as $key => $method)
                        <label style="display: block; padding: 1rem; border: 2px solid #ddd; border-radius: 8px; margin-bottom: 0.75rem; cursor: pointer;">
                            <input type="radio" name="metode_pengiriman" value="{{ $key }}" {{ old('metode_pengiriman', 'ambil_sendiri') === $key ? 'checked' : '' }} required>
                            <strong style="margin-left: 0.5rem;">{{ $method }}</strong>
                            @if($key === 'kurir')
                                <span style="color: #666; display: block; margin-left: 1.75rem; font-size: 0.875rem;">+ Rp 15.000</span>
                            @endif
                        </label>
                    @endforeach
                </div>

                <div class="card">
                    <h3 style="margin-bottom: 1.5rem;">Metode Pembayaran</h3>
                    
                    <label style="display: block; padding: 1rem; border: 2px solid #ddd; border-radius: 8px; margin-bottom: 0.75rem; cursor: pointer;">
                        <input type="radio" name="metode_pembayaran" value="transfer_bank" {{ old('metode_pembayaran', 'transfer_bank') === 'transfer_bank' ? 'checked' : '' }} required>
                        <strong style="margin-left: 0.5rem;">Transfer Bank</strong>
                    </label>

                    <div id="bank-selection" style="margin-left: 1.75rem; margin-bottom: 1rem;">
                        <label class="form-label">Pilih Bank</label>
                        <select name="bank_tujuan" class="form-control">
                            <option value="">Pilih Bank</option>
                            @foreach($banks as $key => $bank)
                                <option value="{{ $key }}" {{ old('bank_tujuan') === $key ? 'selected' : '' }}>{{ $bank }}</option>
                            @endforeach
                        </select>
                    </div>

                    <label style="display: block; padding: 1rem; border: 2px solid #ddd; border-radius: 8px; cursor: pointer;">
                        <input type="radio" name="metode_pembayaran" value="cod" {{ old('metode_pembayaran') === 'cod' ? 'checked' : '' }}>
                        <strong style="margin-left: 0.5rem;">Bayar di Tempat (COD)</strong>
                    </label>
                </div>

                <div class="card">
                    <label class="form-label">Catatan (Opsional)</label>
                    <textarea name="catatan" class="form-control" rows="3">{{ old('catatan') }}</textarea>
                </div>
            </div>

            <div>
                <div class="card" style="position: sticky; top: 100px;">
                    <h3 style="margin-bottom: 1.5rem;">Ringkasan Pesanan</h3>
                    
                    @foreach($cartItems as $item)
                        <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #f0f0f0;">
                            <div>
                                <strong>{{ $item['product']->nama }}</strong>
                                <br>
                                <small style="color: #666;">{{ $item['quantity'] }} x Rp {{ number_format($item['harga'], 0, ',', '.') }}</small>
                            </div>
                            <div style="text-align: right;">
                                <strong>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    @endforeach

                    <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 2px solid #ddd;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span>Subtotal:</span>
                            <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                            <span>Ongkir:</span>
                            <strong id="shipping-cost">Rp 0</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 1.25rem;">
                            <strong>Total:</strong>
                            <strong style="color: var(--primary);" id="grand-total">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.125rem; margin-top: 1.5rem;">
                        Buat Pesanan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Update shipping cost dynamically
document.querySelectorAll('input[name="metode_pengiriman"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const shippingCost = this.value === 'kurir' ? 15000 : 0;
        const subtotal = {{ $subtotal }};
        const total = subtotal + shippingCost;
        
        document.getElementById('shipping-cost').textContent = 'Rp ' + shippingCost.toLocaleString('id-ID');
        document.getElementById('grand-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
    });
});
</script>
@endsection
