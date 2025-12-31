@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<section class="mb-16 md:mb-24">
    <div
        class="bg-[#F3F6F4] rounded-2xl md:rounded-3xl p-6 md:p-12 flex flex-col-reverse md:flex-row items-center gap-8 md:gap-16 relative overflow-hidden">

        <div
            class="absolute top-0 right-0 w-32 h-32 md:w-64 md:h-64 bg-green-200 rounded-full blur-3xl opacity-40 -z-10 translate-x-1/2 -translate-y-1/2">
        </div>

        <div class="w-full md:w-1/2 text-center md:text-left z-10">
            <span
                class="inline-block py-1 px-3 rounded-full bg-green-100 text-primary text-xs font-bold tracking-wide mb-4">
                🌿 Pilihan Keluarga Sehat
            </span>
            <h1 class="text-3xl md:text-5xl font-serif font-bold text-gray-900 leading-tight mb-4 md:mb-6">
                Rasa Otentik <br>
                <span class="text-primary">Warisan Nusantara</span>
            </h1>
            <p class="text-gray-600 text-base md:text-lg mb-6 md:mb-8 leading-relaxed">
                Tempe berkualitas premium dari kedelai pilihan. Diproses secara higienis tanpa bahan pengawet,
                menghadirkan kelezatan alami di setiap gigitan.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center md:justify-start">
                <a href="{{ route('catalog.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3.5 text-sm font-semibold text-white bg-primary rounded-lg hover:bg-green-800 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                    Belanja Sekarang
                </a>
                <a href="#about"
                    class="inline-flex items-center justify-center px-6 py-3.5 text-sm font-semibold text-primary bg-white border border-green-200 rounded-lg hover:bg-green-50 transition-all">
                    Tentang Kami
                </a>
            </div>
        </div>

        <div class="w-full md:w-1/2 relative">
            <div
                class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-white aspect-video md:aspect-auto md:h-80 lg:h-96">
                <img src="{{ asset('storage/images/Tempe.jpg') }}"
                    alt="Tempe Premium"
                    class="w-full h-full object-cover transform hover:scale-105 transition duration-700">
            </div>

            <div
                class="absolute -bottom-4 right-4 md:-bottom-6 md:-left-6 bg-white p-3 md:p-4 rounded-xl shadow-xl border border-gray-100 flex items-center gap-3 animate-bounce-slow max-w-[200px]">
                <div class="bg-yellow-100 p-2 rounded-full text-secondary">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                        </path>
                    </svg>
                </div>
                <div>
                    <div class="text-xs text-gray-500 font-bold uppercase">Terjual</div>
                    <div class="text-sm md:text-lg font-bold text-gray-900">1000+ pcs</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mb-20">
    <div class="text-center max-w-2xl mx-auto mb-10">
        <h2 class="text-2xl md:text-3xl font-serif font-bold text-gray-900 mb-3">Kualitas Terbaik</h2>
        <p class="text-gray-500 text-sm md:text-base">Standar produksi tinggi untuk menjaga nutrisi kedelai tetap utuh.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition text-center">
            <div class="w-12 h-12 bg-green-50 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 mb-1">100% Alami</h3>
            <p class="text-xs text-gray-500">Bebas bahan kimia berbahaya.</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition text-center">
            <div class="w-12 h-12 bg-green-50 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 mb-1">Selalu Segar</h3>
            <p class="text-xs text-gray-500">Produksi baru setiap pagi.</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition text-center">
            <div class="w-12 h-12 bg-green-50 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3">
                    </path>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 mb-1">Harga Terjangkau</h3>
            <p class="text-xs text-gray-500">Ramah di kantong keluarga.</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition text-center">
            <div class="w-12 h-12 bg-green-50 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900 mb-1">Proses Cepat</h3>
            <p class="text-xs text-gray-500">Pesan langsung kirim.</p>
        </div>
    </div>
</section>

<section class="mb-20">
    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
        <div>
            <h2 class="text-2xl md:text-3xl font-serif font-bold text-gray-900">Produk Terlaris</h2>
            <p class="text-gray-500 text-sm mt-2">Dapatkan tempe favorit pelanggan kami.</p>
        </div>
        <a href="{{ route('catalog.index') }}"
            class="text-primary font-semibold text-sm hover:text-green-700 flex items-center gap-1 transition">
            Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                </path>
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @forelse($featuredProducts as $product)
        <div
            class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col h-full">
            <div class="relative h-56 md:h-64 overflow-hidden bg-gray-100">
                @if($product->gambar)
                <img src="{{ asset('storage/'.$product->gambar) }}" alt="{{ $product->nama }}"
                    class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                @else
                <div class="w-full h-full flex flex-col items-center justify-center bg-green-50 text-green-700">
                    <span class="text-4xl mb-2">🌿</span>
                    <span class="text-xs font-medium">Foto Belum Tersedia</span>
                </div>
                @endif

                <div
                    class="absolute bottom-3 right-3 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="{{ route('catalog.show', $product) }}"
                        class="bg-white text-primary p-2.5 rounded-full shadow-lg hover:bg-primary hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="p-5 flex flex-col flex-grow">
                <div class="mb-auto">
                    <h3
                        class="text-lg font-bold text-gray-900 mb-1 group-hover:text-primary transition-colors line-clamp-1">
                        {{ $product->nama }}</h3>
                    <p class="text-gray-500 text-sm line-clamp-2 h-10 leading-relaxed">{{
                        Str::limit($product->deskripsi, 80) }}</p>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="text-xs text-gray-400">Harga</span>
                        <span class="text-lg font-bold text-primary">Rp {{ number_format($product->harga_normal, 0, ',',
                            '.') }}</span>
                    </div>
                    <a href="{{ route('catalog.show', $product) }}"
                        class="px-4 py-2 bg-green-50 text-primary text-xs font-bold uppercase tracking-wide rounded-lg hover:bg-primary hover:text-white transition-colors">
                        Beli
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center bg-gray-50 rounded-xl border border-dashed border-gray-300">
            <p class="text-gray-500 mb-2">Belum ada produk unggulan saat ini.</p>
            <a href="{{ route('catalog.index') }}" class="text-primary font-semibold text-sm hover:underline">Lihat
                semua produk</a>
        </div>
        @endforelse
    </div>
</section>

<section id="about"
    class="mb-10 bg-primary rounded-2xl md:rounded-3xl p-8 md:p-16 text-center text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10"
        style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>

    <div class="relative z-10 max-w-3xl mx-auto">
        <h2 class="text-2xl md:text-4xl font-serif font-bold mb-6">Cerita Tempe 3 Puteri</h2>
        <p class="text-green-100 text-base md:text-lg leading-loose mb-8">
            "Berawal dari dapur rumah tangga, kami tumbuh dengan satu keyakinan: bahwa makanan sehat harus enak dan
            terjangkau. Lebih dari 10 tahun, kami menjaga resep leluhur dalam setiap potong tempe yang kami buat."
        </p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 border-t border-green-700/50 pt-8">
            <div>
                <div class="text-2xl md:text-3xl font-bold text-secondary mb-1">10+</div>
                <div class="text-xs text-green-200 uppercase tracking-widest">Tahun</div>
            </div>
            <div>
                <div class="text-2xl md:text-3xl font-bold text-secondary mb-1">100%</div>
                <div class="text-xs text-green-200 uppercase tracking-widest">Lokal</div>
            </div>
            <div>
                <div class="text-2xl md:text-3xl font-bold text-secondary mb-1">5k+</div>
                <div class="text-xs text-green-200 uppercase tracking-widest">Pelanggan</div>
            </div>
            <div>
                <div class="text-2xl md:text-3xl font-bold text-secondary mb-1">24j</div>
                <div class="text-xs text-green-200 uppercase tracking-widest">Layanan</div>
            </div>
        </div>
    </div>
</section>

@endsection