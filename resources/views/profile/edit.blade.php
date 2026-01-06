@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="bg-primary p-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-white/10 rounded-full blur-3xl"></div>
            <div class="relative z-10 flex items-center gap-6">
                <div class="w-20 h-20 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-3xl font-bold border-4 border-white/30 truncate">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-2xl font-serif font-bold">{{ auth()->user()->name }}</h1>
                    <p class="text-green-100/80 text-sm">Pelanggan Tempe 3 Puteri</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Info Section -->
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 border-b pb-2">Informasi Akun</h3>
                    <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
                        @csrf
                        @method('patch')

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                                class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                                class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">WhatsApp</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', auth()->user()->whatsapp) }}" placeholder="628..."
                                class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition">
                            @error('whatsapp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="w-full bg-primary text-white font-bold py-2 rounded-lg hover:bg-green-800 transition shadow-md">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

                <!-- Password Section -->
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 border-b pb-2">Ganti Password</h3>
                    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                        @csrf
                        @method('put')

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Password Saat Ini</label>
                            <input type="password" name="current_password" required
                                class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition">
                            @error('current_password', 'updatePassword') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Password Baru</label>
                            <input type="password" name="password" required
                                class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition">
                            @error('password', 'updatePassword') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition">
                        </div>

                        <button type="submit" class="w-full bg-secondary text-white font-bold py-2 rounded-lg hover:bg-orange-600 transition shadow-md">
                            Ganti Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
