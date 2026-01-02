<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Admin Tempe 3 Puteri</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
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
                        primary: '#2E5635', /* Hijau Brand */
                        secondary: '#E89B25', /* Kuning Aksen */
                        surface: '#F3F4F6',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .sidebar-active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #E89B25;
            color: #ffffff;
        }

        .sidebar-item {
            border-left: 4px solid transparent;
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
    </style>
</head>

<body class="bg-surface font-sans text-gray-800 antialiased flex h-screen overflow-hidden">

    <div id="sidebar-overlay" onclick="toggleSidebar()"
        class="fixed inset-0 bg-black/50 z-20 hidden md:hidden transition-opacity backdrop-blur-sm"></div>

    <aside id="sidebar"
        class="fixed md:relative z-30 w-64 h-full bg-[#1e4329] text-white flex flex-col transition-transform transform -translate-x-full md:translate-x-0 shadow-2xl flex-shrink-0">

        <div class="h-16 flex items-center gap-3 px-6 bg-[#173320] border-b border-white/5 shrink-0">
            <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center text-secondary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                    </path>
                </svg>
            </div>
            <div>
                <h2 class="font-serif font-bold text-lg tracking-wide leading-none">Admin Panel</h2>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-0.5">Tempe 3 Puteri</p>
            </div>
            <button onclick="toggleSidebar()" class="md:hidden ml-auto text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 space-y-1 custom-scrollbar">

            <div class="px-6 mb-2 mt-2">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Utama</span>
            </div>

            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-item flex items-center gap-3 px-6 py-3 text-sm font-medium hover:bg-white/5 transition-all {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : 'text-gray-300' }}">
                <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
                Dashboard
            </a>

            <div class="px-6 mb-2 mt-6">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Manajemen</span>
            </div>

            <a href="{{ route('admin.products.index') }}"
                class="sidebar-item flex items-center gap-3 px-6 py-3 text-sm font-medium hover:bg-white/5 transition-all {{ request()->routeIs('admin.products.*') ? 'sidebar-active' : 'text-gray-300' }}">
                <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                Produk Jadi
            </a>

            <a href="{{ route('admin.materials.index') }}"
                class="sidebar-item flex items-center gap-3 px-6 py-3 text-sm font-medium hover:bg-white/5 transition-all {{ request()->routeIs('admin.materials.*') ? 'sidebar-active' : 'text-gray-300' }}">
                <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                    </path>
                </svg>
                Bahan Baku
            </a>

            <a href="{{ route('admin.production.index') }}"
                class="sidebar-item flex items-center gap-3 px-6 py-3 text-sm font-medium hover:bg-white/5 transition-all {{ request()->routeIs('admin.production.*') ? 'sidebar-active' : 'text-gray-300' }}">
                <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                    </path>
                </svg>
                Produksi
            </a>

            <div class="px-6 mb-2 mt-6">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Transaksi</span>
            </div>

            <a href="{{ route('admin.orders.index') }}"
                class="sidebar-item flex items-center gap-3 px-6 py-3 text-sm font-medium hover:bg-white/5 transition-all {{ request()->routeIs('admin.orders.*') ? 'sidebar-active' : 'text-gray-300' }}">
                <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Pesanan
            </a>

            <a href="{{ route('admin.finance.index') }}"
                class="sidebar-item flex items-center gap-3 px-6 py-3 text-sm font-medium hover:bg-white/5 transition-all {{ request()->routeIs('admin.finance.*') ? 'sidebar-active' : 'text-gray-300' }}">
                <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
                Keuangan
            </a>

        </nav>

        <div class="p-4 border-t border-white/10 shrink-0">
            <a href="{{ route('home') }}"
                class="flex items-center justify-center gap-2 w-full bg-white/5 hover:bg-white/10 text-gray-300 hover:text-white py-2.5 rounded-lg text-sm font-medium transition-colors border border-white/5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                Ke Website Utama
            </a>
        </div>
    </aside>

    <div class="flex-1 flex flex-col h-full overflow-hidden">

        <header
            class="bg-white h-16 flex items-center justify-between px-6 sticky top-0 z-20 shadow-sm border-b border-gray-100 shrink-0">
            <button onclick="toggleSidebar()" class="md:hidden text-gray-500 hover:text-primary focus:outline-none p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7">
                    </path>
                </svg>
            </button>

            <div class="hidden md:flex flex-col">
                <h1 class="text-lg font-bold text-gray-800 leading-none">@yield('title')</h1>
                <span class="text-[10px] text-gray-400 mt-1">Administrator Area</span>
            </div>

            <div class="flex items-center gap-5">

                <div class="relative group h-full flex items-center">
                    <button class="flex items-center gap-3 focus:outline-none py-2">
                        <div
                            class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm border border-primary/20">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="hidden sm:block text-left">
                            <p class="text-sm font-bold text-gray-700 leading-none">{{ auth()->user()->name ?? 'Admin'
                                }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">Super Admin</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500 transition" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <div class="absolute right-0 top-full pt-2 w-48 hidden group-hover:block z-50">
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                            <div class="px-4 py-3 border-b border-gray-50 bg-gray-50">
                                <p class="text-xs text-gray-400 uppercase tracking-wider">Signed in as</p>
                                <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->email ??
                                    'admin@email.com' }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 font-medium transition-colors">Log
                                    Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto bg-gray-50 p-6 custom-scrollbar">
            @yield('content')

            <footer class="mt-8 pt-4 border-t border-gray-200 text-center md:text-left text-xs text-gray-400">
                &copy; {{ date('Y') }} Tempe 3 Puteri ERP System.
            </footer>
        </main>

    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
        @endif
        @if(session('error'))
            Toast.fire({ icon: 'error', title: '{{ session('error') }}' });
        @endif
        @if($errors->any())
            Toast.fire({ icon: 'error', title: '{!! $errors->first() !!}' });
        @endif
    </script>
    @stack('scripts')
</body>

</html>