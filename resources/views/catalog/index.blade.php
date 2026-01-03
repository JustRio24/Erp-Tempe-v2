@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="text-center mb-10 max-w-2xl mx-auto">
        <h1 class="text-3xl md:text-4xl font-serif font-bold text-primary mb-3">Katalog Produk Kami</h1>
        <p class="text-gray-500 text-sm md:text-base">Temukan berbagai varian tempe terbaik, diolah secara higienis
            untuk kebutuhan nutrisi keluarga Anda.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
        @forelse($products as $product)
        <div
            class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden group">

            <a href="{{ route('catalog.show', $product) }}" class="relative h-56 bg-gray-100 overflow-hidden block">
                @if($product->gambar)
                <img src="{{ asset('storage/'.$product->gambar) }}" alt="{{ $product->nama }}"
                    class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                @else
                <div
                    class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-[#2D5F3F] to-[#4CAF50] text-white">
                    <span class="text-5xl mb-2">🌿</span>
                    <span class="text-xs font-medium opacity-80">Foto Belum Tersedia</span>
                </div>
                @endif

                @if($product->harga_grosir && $product->minimal_grosir)
                <div
                    class="absolute top-3 left-3 bg-secondary text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-md">
                    Grosir Tersedia
                </div>
                @endif
            </a>

            <div class="p-5 flex flex-col flex-grow">
                <div class="mb-4">
                    <a href="{{ route('catalog.show', $product) }}">
                        <h3
                            class="text-lg font-bold text-gray-900 group-hover:text-primary transition-colors line-clamp-1 mb-1">
                            {{ $product->nama }}</h3>
                    </a>
                    <p class="text-gray-500 text-xs leading-relaxed line-clamp-2 h-8">{{ Str::limit($product->deskripsi,
                        80) }}</p>
                </div>

                <div
                    class="flex items-center justify-between mb-3 text-xs font-medium text-gray-400 bg-gray-50 p-2 rounded-lg">
                    <span>Stok: <span class="{{ $product->stok_tersedia > 5 ? 'text-primary' : 'text-red-500' }}">{{
                            $product->stok_tersedia }}</span></span>
                    <span>/ {{ $product->satuan }}</span>
                </div>

                <div class="mb-4">
                    <div class="text-xl font-bold text-primary">Rp {{ number_format($product->harga_normal, 0, ',', '.')
                        }}</div>
                    @if($product->harga_grosir)
                    <div class="text-[10px] text-secondary font-medium">
                        Beli {{ $product->minimal_grosir }}+ : Rp {{ number_format($product->harga_grosir, 0, ',', '.')
                        }}
                    </div>
                    @endif
                </div>

                <div class="mt-auto pt-4 border-t border-gray-100">
                    @if($product->stok_tersedia > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="ajax-cart-form flex gap-2">
                            @csrf
                            <div class="w-16 relative">
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stok_tersedia }}"
                                    class="w-full text-center text-sm font-semibold border border-gray-300 rounded-lg py-2 focus:ring-1 focus:ring-primary focus:border-primary">
                            </div>
                            <button type="submit"
                                class="flex-1 bg-primary hover:bg-green-800 text-white text-sm font-semibold rounded-lg py-2 transition-colors flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Tambah
                            </button>
                        </form>
                    @else
                        <button type="button" disabled
                            class="w-full bg-gray-300 text-gray-500 text-sm font-semibold rounded-lg py-2 cursor-not-allowed flex items-center justify-center gap-2">
                            Habis
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center">
            <div class="bg-gray-50 rounded-2xl border border-dashed border-gray-300 p-10 inline-block">
                <span class="text-4xl block mb-3">🍃</span>
                <p class="text-gray-500 font-medium">Belum ada produk yang tersedia saat ini.</p>
            </div>
        </div>
        @endforelse
    </div>

    <div class="mt-12 flex justify-center">
        {{ $products->links() }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.ajax-cart-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalContent = submitBtn.innerHTML;
            
            // Set loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            `;
            
            const formData = new FormData(form);
            const url = form.getAttribute('action');
            const quantityInput = form.querySelector('input[name="quantity"]');
            const quantity = parseInt(quantityInput.value);
            const maxStock = parseInt(quantityInput.getAttribute('max'));

            if (quantity > maxStock) {
                submitBtn.classList.remove('bg-primary', 'hover:bg-green-800');
                submitBtn.classList.add('bg-red-600');
                submitBtn.innerHTML = 'Stok Melebihi!';
                
                setTimeout(() => {
                    submitBtn.classList.remove('bg-red-600');
                    submitBtn.classList.add('bg-primary', 'hover:bg-green-800');
                    submitBtn.innerHTML = originalContent;
                    submitBtn.disabled = false;
                }, 2000);
                return;
            }
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Update badge
                    const badgeContainers = [
                        document.getElementById('cart-badge-container'),
                        document.getElementById('cart-badge-container-mobile')
                    ];
                    
                    badgeContainers.forEach((container, index) => {
                        if (container) {
                            const isMobile = index === 1;
                            const badgeClass = isMobile ? 'cart-badge-mobile px-1.5 py-0.5 rounded-full shadow-sm bg-secondary text-white text-[9px] w-4 h-4 flex items-center justify-center absolute -top-1 -right-1' 
                                                        : 'cart-badge absolute -top-2 -right-3 bg-secondary text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-sm';
                            
                            container.innerHTML = `<span class="${badgeClass}">${data.cart_count}</span>`;
                        }
                    });
                    
                    // Success feedback
                    submitBtn.classList.remove('bg-primary', 'hover:bg-green-800');
                    submitBtn.classList.add('bg-green-600');
                    submitBtn.innerHTML = 'Berhasil!';
                    
                    setTimeout(() => {
                        submitBtn.classList.remove('bg-green-600');
                        submitBtn.classList.add('bg-primary', 'hover:bg-green-800');
                        submitBtn.innerHTML = originalContent;
                        submitBtn.disabled = false;
                    }, 2000);
                } else {
                    submitBtn.classList.remove('bg-primary', 'hover:bg-green-800');
                    submitBtn.classList.add('bg-red-600');
                    submitBtn.innerHTML = data.message || 'Gagal!';
                    
                    setTimeout(() => {
                        submitBtn.classList.remove('bg-red-600');
                        submitBtn.classList.add('bg-primary', 'hover:bg-green-800');
                        submitBtn.innerHTML = originalContent;
                        submitBtn.disabled = false;
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitBtn.classList.remove('bg-primary', 'hover:bg-green-800');
                submitBtn.classList.add('bg-red-600');
                submitBtn.innerHTML = 'Sistem Error';
                
                setTimeout(() => {
                    submitBtn.classList.remove('bg-red-600');
                    submitBtn.classList.add('bg-primary', 'hover:bg-green-800');
                    submitBtn.innerHTML = originalContent;
                    submitBtn.disabled = false;
                }, 2000);
            });
        });
    });
});
</script>
@endsection