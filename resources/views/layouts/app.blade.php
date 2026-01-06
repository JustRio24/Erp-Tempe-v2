<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tempe 3 Puteri') - Segar & Berkualitas</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" type="image/webp" href="{{ asset('logo.webp') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2E5635', /* Hijau Hutan (Brand Color) */
                        secondary: '#E89B25', /* Kuning Emas (Accent) */
                        surface: '#F9FAFB',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="font-sans antialiased text-gray-800 bg-surface flex flex-col min-h-screen">

    <nav
        class="fixed top-0 w-full z-50 bg-white/95 backdrop-blur-sm border-b border-gray-200 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                        <div
                            class="w-10 h-10 text-primary rounded-full flex items-center justify-center border border-green-100 group-hover:text-white transition-colors duration-300">
                            <img src="{{ asset('logo.webp') }}" style="height: 40px; margin-right: 10px;">
                        </div>
                        <div class="flex flex-col">
                            <h1 class="text-xl font-serif font-bold text-gray-900 leading-none">Tempe 3 Puteri</h1>
                            <span class="text-[10px] uppercase tracking-wider text-primary font-semibold mt-0.5">Asli &
                                Higienis</span>
                        </div>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}"
                        class="text-sm font-medium {{ request()->routeIs('home') ? 'text-primary' : 'text-gray-500 hover:text-gray-900' }} transition">Beranda</a>
                    <a href="{{ route('catalog.index') }}"
                        class="text-sm font-medium {{ request()->routeIs('catalog.*') ? 'text-primary' : 'text-gray-500 hover:text-gray-900' }} transition">Produk</a>
                    <a href="{{ route('cart.index') }}"
                        id="cart-link"
                        class="relative text-sm font-medium {{ request()->routeIs('cart.*') ? 'text-primary' : 'text-gray-500 hover:text-gray-900' }} transition">
                        Keranjang
                        <div id="cart-badge-container">
                            @if(session('cart') && count(session('cart')) > 0)
                            <span
                                class="cart-badge absolute -top-2 -right-3 bg-secondary text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-sm">{{
                                count(session('cart')) }}</span>
                            @endif
                        </div>
                    </a>

                    @auth
                        @if(!auth()->user()->is_admin)
                        <a href="{{ route('history.index') }}"
                            class="text-sm font-medium {{ request()->routeIs('history.*') ? 'text-primary' : 'text-gray-500 hover:text-gray-900' }} transition">Riwayat</a>
                        @endif
                    @endauth

                    <div class="flex items-center gap-3 pl-6 border-l border-gray-200">
                        @auth
                        <div class="relative group h-full flex items-center">
                            <button
                                class="flex items-center gap-2 text-sm font-semibold text-gray-700 hover:text-primary focus:outline-none py-2">
                                <span>{{ Str::limit(auth()->user()->name, 10) }}</span>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-primary transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div class="absolute right-0 top-full pt-2 w-48 hidden group-hover:block z-50">
                                <div class="bg-white rounded-md shadow-lg py-1 border border-gray-100">
                                    
                                    {{-- MENU KHUSUS ADMIN --}}
                                    @if(auth()->user()->is_admin)
                                        <a href="{{ route('dashboard') }}" 
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-primary transition-colors">
                                            Admin Dashboard
                                        </a>
                                    @endif

                                    <a href="{{ route('profile.edit') }}" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-primary transition-colors">
                                        Profil Saya
                                    </a>
                            
                                    {{-- LOGOUT (Muncul untuk semua) --}}
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-semibold text-gray-900 hover:text-primary transition">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="text-sm font-semibold bg-primary text-white px-5 py-2 rounded-full hover:bg-green-800 shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">Daftar</a>
                        @endauth
                    </div>
                </div>

                <div class="flex items-center md:hidden">
                    <a href="{{ route('cart.index') }}" class="mr-4 relative text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <div id="cart-badge-container-mobile">
                            @if(session('cart') && count(session('cart')) > 0)
                            <span
                                class="cart-badge-mobile absolute -top-1 -right-1 bg-secondary text-white text-[9px] w-4 h-4 flex items-center justify-center rounded-full">{{
                                count(session('cart')) }}</span>
                            @endif
                        </div>
                    </a>
                    <button id="mobile-menu-btn" type="button"
                        class="text-gray-500 hover:text-gray-900 focus:outline-none">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 px-4 pt-2 pb-6 shadow-lg">
            <div class="flex flex-col space-y-3 mt-2">
                <a href="{{ route('home') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-green-50 text-primary' : 'text-gray-600 hover:bg-gray-50' }}">Beranda</a>
                <a href="{{ route('catalog.index') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('catalog.*') ? 'bg-green-50 text-primary' : 'text-gray-600 hover:bg-gray-50' }}">Produk</a>

                @auth
                    @if(!auth()->user()->is_admin)
                    <a href="{{ route('history.index') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('history.*') ? 'bg-green-50 text-primary' : 'text-gray-600 hover:bg-gray-50' }}">Riwayat Pesanan</a>
                    @endif
                @endauth

                <div class="border-t border-gray-100 my-2 pt-2">
                    @auth
                    <div class="px-3 py-2 text-base font-semibold text-gray-800">Hi, {{ auth()->user()->name }}</div>
                    @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}"
                        class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-50">Admin Dashboard</a>
                    @endif
                    <a href="{{ route('profile.edit') }}"
                        class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-50">Profil Saya</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">Logout</button>
                    </form>
                    @else
                    <div class="grid grid-cols-2 gap-3 mt-2">
                        <a href="{{ route('login') }}"
                            class="flex justify-center items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="flex justify-center items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-primary hover:bg-green-800">Daftar</a>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow pt-24 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r shadow-sm flex items-start gap-3">
            <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
        @endif
        @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-[#1F2937] text-gray-300 py-12 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
                <div class="text-center md:text-left">
                    <h3 class="text-white text-lg font-serif font-bold mb-4">Tempe 3 Puteri</h3>
                    <p class="text-sm leading-relaxed text-gray-400">
                        Menghadirkan tempe berkualitas premium, diolah secara higienis untuk gizi terbaik keluarga
                        Indonesia.
                    </p>
                </div>
                <div class="text-center md:text-left">
                    <h3 class="text-white text-sm font-bold uppercase tracking-wider mb-4">Navigasi</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-secondary transition">Beranda</a></li>
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-secondary transition">Produk
                                Kami</a></li>
                        <li><a href="#" class="hover:text-secondary transition">Tentang Kami</a></li>
                    </ul>
                </div>
                <div class="text-center md:text-left">
                    <h3 class="text-white text-sm font-bold uppercase tracking-wider mb-4">Hubungi Kami</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>WhatsApp: 0812-3456-7890</li>
                        <li>Email: hello@tempe3puteri.com</li>
                        <li>Lokasi: Sumatera Selatan, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-10 pt-6 text-center text-xs text-gray-500">
                &copy; {{ date('Y') }} Tempe 3 Puteri. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
</body>

</html>