@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.users.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 text-gray-400 hover:text-primary transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-serif font-bold text-gray-900">Edit Pengguna</h2>
            <p class="text-sm text-gray-500">Sesuaikan informasi akun untuk {{ $user->name }}.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" placeholder="628..."
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none">
                    @error('whatsapp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Role / Akses</label>
                    <div class="flex items-center gap-4 mt-1 bg-gray-50 p-1 rounded-xl w-fit">
                        <label class="relative flex items-center gap-2 px-6 py-2 rounded-lg cursor-pointer transition {{ !$user->is_admin ? 'bg-white shadow-sm ring-1 ring-gray-200' : '' }}">
                            <input type="radio" name="is_admin" value="0" class="sr-only" {{ !$user->is_admin ? 'checked' : '' }}>
                            <span class="text-sm font-bold {{ !$user->is_admin ? 'text-primary' : 'text-gray-400' }}">Pelanggan</span>
                        </label>
                        <label class="relative flex items-center gap-2 px-6 py-2 rounded-lg cursor-pointer transition {{ $user->is_admin ? 'bg-white shadow-sm ring-1 ring-gray-200' : '' }}">
                            <input type="radio" name="is_admin" value="1" class="sr-only" {{ $user->is_admin ? 'checked' : '' }}>
                            <span class="text-sm font-bold {{ $user->is_admin ? 'text-purple-600' : 'text-gray-400' }}">Admin</span>
                        </label>
                    </div>
                    @error('is_admin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-gray-50 flex gap-4">
                <button type="submit" class="flex-1 bg-primary hover:bg-[#25462b] text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-green-900/10">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.users.index') }}" class="px-8 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-xl transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Simple UI interaction for radio buttons
    document.querySelectorAll('input[name="is_admin"]').forEach(input => {
        input.addEventListener('change', () => {
            document.querySelectorAll('input[name="is_admin"]').forEach(inner => {
                const label = inner.parentElement;
                label.classList.remove('bg-white', 'shadow-sm', 'ring-1', 'ring-gray-200');
                const span = label.querySelector('span');
                span.classList.remove('text-primary', 'text-purple-600');
                span.classList.add('text-gray-400');
            });

            const currentLabel = input.parentElement;
            currentLabel.classList.add('bg-white', 'shadow-sm', 'ring-1', 'ring-gray-200');
            const currentSpan = currentLabel.querySelector('span');
            currentSpan.classList.remove('text-gray-400');
            currentSpan.classList.add(input.value == '1' ? 'text-purple-600' : 'text-primary');
        });
    });
</script>
@endsection
