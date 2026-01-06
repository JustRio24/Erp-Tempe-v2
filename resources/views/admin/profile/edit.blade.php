@extends('layouts.admin')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 pb-12">

    <div class="bg-gradient-to-r from-primary to-[#3d7045] rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-white/10 rounded-full blur-3xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
            <div class="w-24 h-24 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-4xl font-bold border-4 border-white/30 shadow-inner">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="text-center md:text-left">
                <h1 class="text-3xl font-serif font-bold">{{ auth()->user()->name }}</h1>
                <p class="text-green-100/80 mt-1 uppercase tracking-widest text-xs font-bold">Administrator Tempe 3 Puteri</p>
                <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-4">
                    <div class="flex items-center gap-2 text-sm bg-white/10 px-3 py-1.5 rounded-full border border-white/10">
                        <span>📧</span> {{ auth()->user()->email }}
                    </div>
                    @if(auth()->user()->whatsapp)
                    <div class="flex items-center gap-2 text-sm bg-white/10 px-3 py-1.5 rounded-full border border-white/10">
                        <span>📱</span> {{ auth()->user()->whatsapp }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="bg-green-100 border border-green-200 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3 animate-bounce">
            <span class="text-xl">✅</span>
            <span class="font-medium">Profil berhasil diperbarui.</span>
        </div>
    @endif

    @if (session('status') === 'password-updated')
        <div class="bg-green-100 border border-green-200 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3 animate-bounce">
            <span class="text-xl">🔒</span>
            <span class="font-medium">Password berhasil diganti.</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Informasi Profil -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            <h3 class="text-xl font-bold text-gray-900 font-serif mb-6 flex items-center gap-2">
                <span class="p-2 bg-blue-50 rounded-lg text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </span>
                Informasi Dasar
            </h3>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('patch')

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">WhatsApp</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">+</span>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', auth()->user()->whatsapp) }}" placeholder="62812345678"
                            class="w-full pl-8 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none">
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1">Gunakan kode negara (contoh: 628...)</p>
                    @error('whatsapp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-primary hover:bg-[#25462b] text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-green-900/10">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Update Password -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            <h3 class="text-xl font-bold text-gray-900 font-serif mb-6 flex items-center gap-2">
                <span class="p-2 bg-orange-50 rounded-lg text-orange-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </span>
                Keamanan
            </h3>

            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                @method('put')

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Password Saat Ini</label>
                    <input type="password" name="current_password" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all outline-none">
                    @error('current_password', 'updatePassword') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all outline-none">
                    @error('password', 'updatePassword') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all outline-none">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-orange-900/10">
                        Ganti Password
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
