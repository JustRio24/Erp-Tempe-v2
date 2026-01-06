@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-serif font-bold text-gray-900">Daftar Pengguna</h2>
            <p class="text-sm text-gray-500">Kelola akun admin dan pelanggan yang terdaftar di sistem.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-[10px] font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Nama & Email</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">WhatsApp</th>
                        <th class="px-6 py-4">Terdaftar</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-sm">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->is_admin)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-100 text-purple-700">
                                    Admin
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                    Pelanggan
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $user->whatsapp ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                   title="Edit User">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus User">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
