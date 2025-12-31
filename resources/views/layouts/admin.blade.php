<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Admin Tempe 3 Puteri</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="admin-body">
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
                <p>Tempe 3 Puteri</p>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    📊 Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    📦 Produk & Inventori
                </a>
                <a href="{{ route('admin.production.index') }}" class="{{ request()->routeIs('admin.production.*') ? 'active' : '' }}">
                    🏭 Produksi
                </a>
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    🛒 Pesanan
                </a>
                <a href="{{ route('admin.finance.index') }}" class="{{ request()->routeIs('admin.finance.*') ? 'active' : '' }}">
                    💰 Keuangan
                </a>
                <hr>
                <a href="{{ route('home') }}">🏠 Kembali ke Website</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="admin-main">
            <div class="admin-content">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-error">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])
</body>
</html>
