@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-surface py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-gray-100 p-8 relative overflow-hidden">

        <div class="absolute top-0 left-0 w-full h-2 bg-primary"></div>

        <div class="text-center mb-8">
            <div class="mx-auto flex items-center justify-center w-16 h-16 bg-green-50 rounded-full mb-4 text-primary">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11.536 11 9 13.536 7.464 12 5 14.464 2.536 12 5 9.536 7.464 11 9.929 8.536 11.536 11 15 7z">
                    </path>
                </svg>
            </div>
            <h2 class="text-2xl font-serif font-bold text-gray-900">Lupa Password?</h2>
            <p class="text-gray-500 text-sm mt-2 leading-relaxed">
                Jangan khawatir. Masukkan email Anda di bawah ini, dan kami akan mengirimkan link untuk mereset password
                Anda.
            </p>
        </div>

        @if (session('status'))
        <div
            class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-start gap-2">
            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('status') }}</span>
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none"
                    placeholder="nama@email.com">
            </div>

            <div class="flex flex-col gap-3 pt-2">
                <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-green-100 text-sm font-bold text-white bg-primary hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all transform hover:-translate-y-0.5">
                    Kirim Link Reset Password
                </button>

                <a href="{{ route('login') }}"
                    class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    Kembali ke Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection