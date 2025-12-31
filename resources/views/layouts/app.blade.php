<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tempe 3 Puteri') - Sistem ERP UMKM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <div class="navbar-brand">
                    <a href="{{ route('home') }}">
                        <h1>Tempe 3 Puteri</h1>
                    </a>
                </div>
                <div class="navbar-menu">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('catalog.index') }}" class="{{ request()->routeIs('catalog.*') ? 'active' : '' }}">Produk</a>
                    <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'active' : '' }}">
                        Keranjang
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="badge">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                    
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="btn-admin">Admin Dashboard</a>
                        @else
                            <span>{{ auth()->user()->name }}</span>
                        @endif
                        
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: none; border: none; cursor: pointer; color: var(--danger); font-weight: 500;">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" style="font-weight: 600;">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 0.5rem 1rem;">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success">{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="container">
                <div class="alert alert-error">{{ session('error') }}</div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} UMKM Tempe 3 Puteri. Tempe Berkualitas untuk Keluarga Indonesia.</p>
        </div>
    </footer>
</body>
</html>
