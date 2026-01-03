@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-surface py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row-reverse">

        <div class="hidden md:block md:w-1/2 relative bg-primary">
            <img src="{{ asset('kedelai.webp') }}"
                alt="Kedelai Berkualitas"
                class="absolute inset-0 w-full h-full object-cover opacity-50">
            <div class="absolute "></div>

            <div class="absolute bottom-0 left-0 p-12 text-white">
                <h2 class="text-3xl font-serif font-bold mb-2">Bergabung Bersama Kami</h2>
                <p class="text-green-100 text-sm leading-relaxed">
                    Dapatkan akses ke berbagai produk olahan kedelai terbaik langsung dari produsen terpercaya.
                </p>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 relative">
            <div class="text-center md:text-left mb-8">
                <h1 class="text-2xl font-serif font-bold text-gray-900">Buat Akun Baru</h1>
                <p class="text-gray-500 text-sm mt-1">Isi data diri Anda untuk mendaftar.</p>
            </div>

            @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none"
                        placeholder="Nama Lengkap Anda">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none"
                        placeholder="nama@email.com">
                </div>

                <div>
                    <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                    <input id="whatsapp" type="tel" name="whatsapp" value="{{ old('whatsapp') }}" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none"
                        placeholder="0812...">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none"
                        placeholder="Minimal 8 karakter">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi
                        Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none"
                        placeholder="Ulangi password">
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-yellow-100 text-sm font-bold text-white bg-secondary hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary transition-all transform hover:-translate-y-0.5">
                        Daftar Sekarang
                    </button>
                </div>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                            class="font-bold text-primary hover:text-green-800 transition-colors">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection