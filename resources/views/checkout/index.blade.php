@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">

    <div class="mb-8">
        <h1 class="text-3xl font-serif font-bold text-primary">Checkout Pesanan</h1>
        <p class="text-gray-500 text-sm mt-1">Lengkapi data diri Anda untuk menyelesaikan pesanan.</p>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">

            <div class="lg:col-span-7 space-y-8">

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span
                            class="w-8 h-8 rounded-full bg-green-100 text-primary flex items-center justify-center text-sm">1</span>
                        Data Pembeli
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_pembeli"
                                class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary transition-colors"
                                value="{{ old('nama_pembeli') }}" placeholder="Contoh: Budi Santoso" required>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon (WhatsApp) <span
                                    class="text-red-500">*</span></label>
                            <input type="tel" name="telepon_pembeli"
                                class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary transition-colors"
                                value="{{ old('telepon_pembeli') }}" placeholder="0812..." required>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email <span
                                    class="text-red-500">*</span></label>
                            <input type="email" name="email_pembeli"
                                class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary transition-colors"
                                value="{{ old('email_pembeli') }}" placeholder="email@contoh.com" required>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap <span
                                    class="text-red-500">*</span></label>
                            <textarea name="alamat_pembeli" rows="3"
                                class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary transition-colors"
                                placeholder="Nama Jalan, RT/RW, Kelurahan, Kecamatan..."
                                required>{{ old('alamat_pembeli') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span
                            class="w-8 h-8 rounded-full bg-green-100 text-primary flex items-center justify-center text-sm">2</span>
                        Metode Pengiriman
                    </h3>

                    <div class="space-y-3">
                        @foreach($shippingMethods as $key => $method)
                        <label
                            class="relative flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition-colors group has-[:checked]:border-primary has-[:checked]:bg-green-50">
                            <input type="radio" name="metode_pengiriman" value="{{ $key }}"
                                class="h-4 w-4 text-primary border-gray-300 focus:ring-primary" {{
                                old('metode_pengiriman', 'ambil_sendiri' )===$key ? 'checked' : '' }} required>
                            <div class="ml-3 flex-1">
                                <span class="block text-sm font-bold text-gray-900">{{ $method }}</span>
                                @if($key === 'kurir')
                                <span class="block text-xs text-gray-500 mt-1">Estimasi pengiriman 1-2 hari kerja</span>
                                @else
                                <span class="block text-xs text-gray-500 mt-1">Ambil langsung di lokasi produksi
                                    kami</span>
                                @endif
                            </div>
                            @if($key === 'kurir')
                            <span class="text-sm font-bold text-gray-900">+ Rp 15.000</span>
                            @else
                            <span class="text-sm font-bold text-green-600">Gratis</span>
                            @endif
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span
                            class="w-8 h-8 rounded-full bg-green-100 text-primary flex items-center justify-center text-sm">3</span>
                        Metode Pembayaran
                    </h3>

                    <div class="space-y-4">
                        <div
                            class="border rounded-xl p-4 has-[:checked]:border-primary has-[:checked]:bg-green-50 transition-colors">
                            <label class="flex items-center cursor-pointer mb-3">
                                <input type="radio" name="metode_pembayaran" value="transfer_bank"
                                    class="h-4 w-4 text-primary border-gray-300 focus:ring-primary" {{
                                    old('metode_pembayaran', 'transfer_bank' )==='transfer_bank' ? 'checked' : '' }}
                                    onchange="toggleBankSelect(true)">
                                <span class="ml-3 font-bold text-gray-900">Transfer Bank</span>
                            </label>

                            <div id="bank-selection-container" class="ml-7 mt-2 transition-all duration-300">
                                <select name="bank_tujuan"
                                    class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary text-sm bg-white">
                                    <option value="">-- Pilih Bank Tujuan --</option>
                                    @foreach($banks as $key => $bank)
                                    <option value="{{ $key }}" {{ old('bank_tujuan')===$key ? 'selected' : '' }}>{{
                                        $bank }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div
                            class="border rounded-xl p-4 has-[:checked]:border-primary has-[:checked]:bg-green-50 transition-colors">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="metode_pembayaran" value="cod"
                                    class="h-4 w-4 text-primary border-gray-300 focus:ring-primary" {{
                                    old('metode_pembayaran')==='cod' ? 'checked' : '' }}
                                    onchange="toggleBankSelect(false)">
                                <span class="ml-3 font-bold text-gray-900">Bayar di Tempat (COD)</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Pesanan (Opsional)</label>
                    <textarea name="catatan"
                        class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary transition-colors"
                        rows="2"
                        placeholder="Contoh: Tolong pilihkan tempe yang benar-benar matang.">{{ old('catatan') }}</textarea>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="bg-gray-50 rounded-2xl p-6 lg:p-8 border border-gray-200 sticky top-24">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 font-serif">Ringkasan Pesanan</h3>

                    <div class="space-y-4 mb-6 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cartItems as $item)
                        <div class="flex gap-4">
                            <div
                                class="w-16 h-16 bg-white rounded-lg border border-gray-200 flex-shrink-0 overflow-hidden">
                                @if($item['product']->gambar)
                                <img src="{{ asset('storage/'.$item['product']->gambar) }}"
                                    class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center text-xl">🌿</div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-gray-900 line-clamp-1">{{ $item['product']->nama }}
                                </h4>
                                <p class="text-xs text-gray-500">{{ $item['quantity'] }} x Rp {{
                                    number_format($item['harga'], 0, ',', '.') }}</p>
                            </div>
                            <div class="text-sm font-bold text-gray-700">
                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Subtotal Produk</span>
                            <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Biaya Pengiriman</span>
                            <span class="font-medium" id="shipping-display">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                            <span class="text-base font-bold text-gray-900">Total Pembayaran</span>
                            <span class="text-2xl font-bold text-primary" id="grand-total-display">Rp {{
                                number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full mt-8 bg-primary hover:bg-green-800 text-white font-bold py-4 rounded-xl shadow-lg shadow-green-200 transition-all transform hover:-translate-y-1 flex justify-center items-center gap-2">
                        <span>Buat Pesanan</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>

                    <p class="text-xs text-gray-400 text-center mt-4">
                        Dengan membuat pesanan, Anda menyetujui Syarat & Ketentuan kami.
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    const subtotal = {{ $subtotal }};
    const shippingRadios = document.querySelectorAll('input[name="metode_pengiriman"]');
    const shippingDisplay = document.getElementById('shipping-display');
    const grandTotalDisplay = document.getElementById('grand-total-display');
    const bankContainer = document.getElementById('bank-selection-container');
    const paymentRadios = document.querySelectorAll('input[name="metode_pembayaran"]');

    // Logic: Hitung Ongkir
    function updateTotals() {
        let shippingCost = 0;
        shippingRadios.forEach(radio => {
            if (radio.checked && radio.value === 'kurir') {
                shippingCost = 15000;
            }
        });

        const total = subtotal + shippingCost;
        
        // Format Currency IDR
        const formatIDR = (num) => 'Rp ' + num.toLocaleString('id-ID');

        shippingDisplay.textContent = shippingCost === 0 ? 'Gratis' : formatIDR(shippingCost);
        grandTotalDisplay.textContent = formatIDR(total);
    }

    // Logic: Toggle Bank Dropdown
    function toggleBankSelect(show) {
        if (show) {
            bankContainer.classList.remove('hidden', 'opacity-0', 'h-0');
            bankContainer.classList.add('opacity-100', 'h-auto', 'mt-2');
        } else {
            bankContainer.classList.add('hidden', 'opacity-0', 'h-0');
            bankContainer.classList.remove('opacity-100', 'h-auto', 'mt-2');
        }
    }

    // Event Listeners
    shippingRadios.forEach(radio => radio.addEventListener('change', updateTotals));
    
    // Initialize
    updateTotals();
    // Check initial state for bank dropdown
    const isTransfer = document.querySelector('input[name="metode_pembayaran"]:checked')?.value === 'transfer_bank';
    toggleBankSelect(isTransfer);

</script>
@endsection