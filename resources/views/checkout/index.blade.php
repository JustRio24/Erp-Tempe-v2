@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">

    <div class="mb-8">
        <h1 class="text-3xl font-serif font-bold text-primary">Checkout Pesanan</h1>
        <p class="text-gray-500 text-sm mt-1">Lengkapi data diri Anda untuk menyelesaikan pesanan.</p>
    </div>

    {{-- ID FORM SANGAT PENTING: id="checkout-form" --}}
    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">

            <div class="lg:col-span-7 space-y-8">

                {{-- 1. DATA PEMBELI --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-green-100 text-primary flex items-center justify-center text-sm">1</span>
                        Data Pembeli
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_pembeli" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary transition-colors p-2" value="{{ old('nama_pembeli', auth()->user()->name ?? '') }}" placeholder="Contoh: Budi Santoso" required>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon (WhatsApp) <span class="text-red-500">*</span></label>
                            <input type="tel" name="telepon_pembeli" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary transition-colors p-2" value="{{ old('telepon_pembeli', auth()->user()->whatsapp ?? '') }}" placeholder="0812..." required>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email_pembeli" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary transition-colors p-2" value="{{ old('email_pembeli', auth()->user()->email ?? '') }}" placeholder="email@contoh.com" required>
                        </div>

                        <div class="col-span-2 {{ old('metode_pengiriman', 'ambil_sendiri') === 'kurir' ? '' : 'hidden' }}" id="address-container">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="alamat_pembeli" id="alamat_pembeli" rows="3" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary transition-colors p-2" placeholder="Nama Jalan, RT/RW, Kelurahan, Kecamatan..." {{ old('metode_pengiriman') === 'kurir' ? 'required' : '' }}>{{ old('alamat_pembeli') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- 2. METODE PENGIRIMAN --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-green-100 text-primary flex items-center justify-center text-sm">2</span>
                        Metode Pengiriman
                    </h3>

                    <div class="space-y-3">
                        @foreach ($shippingMethods as $key => $method)
                        <label class="relative flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition-colors group has-[:checked]:border-primary has-[:checked]:bg-green-50">
                            <input type="radio" name="metode_pengiriman" value="{{ $key }}" class="h-4 w-4 text-primary border-gray-300 focus:ring-primary" {{ old('metode_pengiriman', 'ambil_sendiri') === $key ? 'checked' : '' }} required>
                            <div class="ml-3 flex-1">
                                <span class="block text-sm font-bold text-gray-900">{{ $method }}</span>
                                @if ($key === 'kurir')
                                <span class="block text-xs text-gray-500 mt-1">Estimasi pengiriman 1-2 hari kerja</span>
                                @else
                                <span class="block text-xs text-gray-500 mt-1">Ambil langsung di lokasi produksi kami</span>
                                @endif
                            </div>
                            @if ($key === 'kurir')
                            <span class="text-sm font-bold text-gray-900">+ Rp 15.000</span>
                            @else
                            <span class="text-sm font-bold text-green-600">Gratis</span>
                            @endif
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- 3. METODE PEMBAYARAN --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-green-100 text-primary flex items-center justify-center text-sm">3</span>
                        Metode Pembayaran
                    </h3>

                    <div class="space-y-4">
                        {{-- E-Payment (Midtrans) --}}
                        <div class="border rounded-xl p-4 has-[:checked]:border-primary has-[:checked]:bg-green-50 transition-colors">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="metode_pembayaran" value="transfer_bank" class="h-4 w-4 text-primary border-gray-300 focus:ring-primary" {{ old('metode_pembayaran', 'transfer_bank') === 'transfer_bank' ? 'checked' : '' }}>
                                <div class="ml-3">
                                    <span class="block font-bold text-gray-900">E-Payment (Otomatis)</span>
                                    <span class="block text-xs text-gray-500 mt-0.5">QRIS, GoPay, ShopeePay, Transfer Bank (VA)</span>
                                </div>
                            </label>
                        </div>

                        {{-- COD --}}
                        <div class="border rounded-xl p-4 has-[:checked]:border-primary has-[:checked]:bg-green-50 transition-colors">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="metode_pembayaran" value="cod" class="h-4 w-4 text-primary border-gray-300 focus:ring-primary" {{ old('metode_pembayaran') === 'cod' ? 'checked' : '' }}>
                                <span class="ml-3 font-bold text-gray-900">Bayar di Tempat (COD)</span>
                            </label>
                        </div>
                    </div>
                    
                    {{-- CATATAN: Saya menghapus bagian dropdown bank manual karena Anda menggunakan Midtrans Snap. Midtrans akan memunculkan pilihan bank secara otomatis di Popup. --}}
                </div>

                {{-- CATATAN --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Pesanan (Opsional)</label>
                    <textarea name="catatan" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary transition-colors p-2" rows="2" placeholder="Contoh: Tolong pilihkan tempe yang benar-benar matang.">{{ old('catatan') }}</textarea>
                </div>
            </div>

            {{-- SIDEBAR RINGKASAN --}}
            <div class="lg:col-span-5">
                <div class="bg-gray-50 rounded-2xl p-6 lg:p-8 border border-gray-200 sticky top-24">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 font-serif">Ringkasan Pesanan</h3>

                    <div class="space-y-4 mb-6 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach ($cartItems as $item)
                        <div class="flex gap-4">
                            <div class="w-16 h-16 bg-white rounded-lg border border-gray-200 flex-shrink-0 overflow-hidden">
                                @if ($item['product']->gambar)
                                <img src="{{ asset('storage/' . $item['product']->gambar) }}" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center text-xl">🌿</div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-gray-900 line-clamp-1">{{ $item['product']->nama }}</h4>
                                <p class="text-xs text-gray-500">{{ $item['quantity'] }} x Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
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
                            <span class="text-2xl font-bold text-primary" id="grand-total-display">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="submit" id="btn-submit-order" class="w-full mt-8 bg-primary hover:bg-green-800 text-white font-bold py-4 rounded-xl shadow-lg shadow-green-200 transition-all transform hover:-translate-y-1 flex justify-center items-center gap-2">
                        <span id="btn-text">Buat Pesanan</span>
                        <span id="btn-loading" class="hidden">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>

                    <p class="text-xs text-gray-400 text-center mt-4">
                        Dengan membuat pesanan, Anda menyetujui Syarat & Ketentuan kami.
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- SCRIPT AREA --}}
<script src="https://app.{{ env('MIDTRANS_IS_PRODUCTION') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // --- 1. SETUP VARIABEL ---
        const subtotal = {{ $subtotal }};
        const shippingRadios = document.querySelectorAll('input[name="metode_pengiriman"]');
        const shippingDisplay = document.getElementById('shipping-display');
        const grandTotalDisplay = document.getElementById('grand-total-display');
        
        const checkoutForm = document.getElementById('checkout-form');
        const btnSubmit = document.getElementById('btn-submit-order');
        const btnText = document.getElementById('btn-text');
        const btnLoading = document.getElementById('btn-loading');

        const addressContainer = document.getElementById('address-container');
        const addressTextarea = document.getElementById('alamat_pembeli');

        // --- 2. LOGIC ONGKIR & ALAMAT (Aman) ---
        function updateTotals() {
            let shippingCost = 0;
            let showAddress = false;
            
            if (shippingRadios.length > 0) {
                shippingRadios.forEach(radio => {
                    if (radio.checked) {
                        if (radio.value === 'kurir') {
                            shippingCost = 15000;
                            showAddress = true;
                        }
                    }
                });
            }

            // Toggle Address Visibility
            if (showAddress) {
                addressContainer.classList.remove('hidden');
                addressTextarea.required = true;
            } else {
                addressContainer.classList.add('hidden');
                addressTextarea.required = false;
                addressTextarea.value = ''; // Opsional: bersihkan alamat jika ambil sendiri
            }

            const total = subtotal + shippingCost;
            const formatIDR = (num) => 'Rp ' + num.toLocaleString('id-ID');

            if (shippingDisplay) shippingDisplay.textContent = shippingCost === 0 ? 'Gratis' : formatIDR(shippingCost);
            if (grandTotalDisplay) grandTotalDisplay.textContent = formatIDR(total);
        }

        // Jalankan saat load & saat radio berubah
        if (shippingRadios.length > 0) {
            shippingRadios.forEach(radio => radio.addEventListener('change', updateTotals));
            updateTotals();
        }

        // --- 3. LOGIC SUBMIT (AJAX + MIDTRANS) ---
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', async function(e) {
                e.preventDefault(); // MENCEGAH RELOAD HALAMAN
                
                // UI Loading
                btnSubmit.disabled = true;
                btnText.textContent = 'Memproses...';
                btnLoading.classList.remove('hidden');

                const formData = new FormData(checkoutForm);

                try {
                    const response = await fetch("{{ route('checkout.process') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json"
                        },
                        body: formData
                    });

                    const result = await response.json();
                    console.log("Response Server:", result);

                    if (!response.ok) {
                        // Handle Error Validasi Laravel
                        if(result.errors) {
                            let msg = "Mohon periksa input Anda:\n";
                            for(let key in result.errors) {
                                msg += "- " + result.errors[key][0] + "\n";
                            }
                            alert(msg);
                        } else {
                            alert(result.message || "Terjadi kesalahan pada server.");
                        }
                        throw new Error('Server returned error');
                    }

                    // SUKSES
                    if (result.status === 'success') {
                        if (result.snap_token) {
                            // --- POPUP MIDTRANS MUNCUL DISINI ---
                            window.snap.pay(result.snap_token, {
                                onSuccess: function(paymentResult){
                                    window.location.href = result.redirect_url;
                                },
                                onPending: function(paymentResult){
                                    window.location.href = result.redirect_url;
                                },
                                onError: function(paymentResult){
                                    alert("Pembayaran gagal atau dibatalkan.");
                                    resetBtn();
                                },
                                onClose: function(){
                                    alert('Anda belum menyelesaikan pembayaran.');
                                    // Opsional: Tetap di halaman ini atau redirect
                                    // window.location.href = result.redirect_url;
                                }
                            });
                        } else {
                            // KASUS COD
                            window.location.href = result.redirect_url;
                        }
                    } else {
                        alert(result.message || "Gagal memproses pesanan.");
                        resetBtn();
                    }

                } catch (error) {
                    console.error("Error JS:", error);
                    // Jangan alert jika error validasi (sudah dihandle diatas)
                    if(error.message !== 'Server returned error') {
                        alert("Terjadi kesalahan sistem. Silakan coba lagi.");
                    }
                    resetBtn();
                }
            });
        }

        function resetBtn() {
            btnSubmit.disabled = false;
            btnText.textContent = 'Buat Pesanan';
            btnLoading.classList.add('hidden');
        }

    });
</script>
@endsection