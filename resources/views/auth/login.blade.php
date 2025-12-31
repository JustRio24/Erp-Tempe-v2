@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-surface py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row">

        <div class="hidden md:block md:w-1/2 relative bg-primary">
            <img src="https://images.unsplash.com/photo-1626505776602-57b16c52bb88?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                alt="Tempe Masak" class="absolute inset-0 w-full h-full object-cover opacity-80 mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-t from-primary to-transparent opacity-90"></div>

            <div class="absolute bottom-0 left-0 p-12 text-white">
                <h2 class="text-3xl font-serif font-bold mb-2">Selamat Datang Kembali</h2>
                <p class="text-green-100 text-sm leading-relaxed">
                    Nikmati kelezatan tempe asli yang diproses dengan standar kebersihan tinggi untuk keluarga tercinta.
                </p>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 relative">
            <div class="text-center md:text-left mb-8">
                <h1 class="text-2xl font-serif font-bold text-gray-900">Login Akun</h1>
                <p class="text-gray-500 text-sm mt-1">Masuk untuk mulai berbelanja.</p>
            </div>

            @if (session('status'))
            <div class="mb-4 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r">
                <p class="text-sm text-blue-700">{{ session('status') }}</p>
            </div>
            @endif

            @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none"
                        placeholder="nama@email.com">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-xs font-semibold text-secondary hover:text-orange-600">
                            Lupa password?
                        </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded cursor-pointer">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-600 cursor-pointer">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-green-100 text-sm font-bold text-white bg-primary hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all transform hover:-translate-y-0.5">
                        Masuk Sekarang
                    </button>
                </div>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}"
                            class="font-bold text-primary hover:text-green-800 transition-colors">
                            Daftar Gratis
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection