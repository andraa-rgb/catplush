@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">

    <!-- 1. TAB NAVIGASI (AGAR BISA BALIK KE UJIAN) -->
    <!-- Ini adalah kunci agar panel terasa menyatu -->
    <div class="flex items-center gap-2 mb-8 border-b border-gray-200 pb-1">

        <!-- Tab 1: User (AKTIF DISINI - Warna Merah) -->
        <a href="{{ route('super.users.index') }}" class="px-4 py-2 text-sm font-bold text-red-600 border-b-2 border-red-600 bg-red-50/50 rounded-t-lg transition">
            <i class="fa-solid fa-users-gear mr-2"></i> Manajemen User
        </a>

        <!-- Tab 2: Ujian (LINK KE UJIAN - Warna Abu/Netral) -->
        <a href="{{ route('admin.exams.index') }}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 rounded-t-lg transition">
            <i class="fa-solid fa-file-pen mr-2"></i> Manajemen Ujian
        </a>
    </div>

    <!-- 2. HEADER PAGE -->
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl p-8 mb-8 text-white shadow-xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl -mr-16 -mt-16"></div>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative z-10">
            <div>
                <h1 class="text-3xl font-bold flex items-center gap-3">
                    <i class="fa-solid fa-users-gear text-red-400"></i> Daftar Pengguna Sistem
                </h1>
                <p class="text-gray-400 mt-2">Kelola hak akses Admin Ujian, Super Admin, dan Peserta.</p>
            </div>
            <a href="{{ route('super.users.create') }}" class="bg-red-600 hover:bg-red-500 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-red-600/20 flex items-center gap-2 transition transform hover:scale-105">
                <i class="fa-solid fa-user-plus"></i> Tambah User Baru
            </a>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3 shadow-sm">
        <div class="bg-green-100 p-2 rounded-full"><i class="fa-solid fa-check"></i></div>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center gap-3 shadow-sm">
        <div class="bg-red-100 p-2 rounded-full"><i class="fa-solid fa-xmark"></i></div>
        <span class="font-medium">{{ session('error') }}</span>
    </div>
    @endif

    <!-- 3. TABEL USER -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-50/50 text-gray-500 font-bold uppercase tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-5">Profil User</th>
                        <th class="px-6 py-5">Role Access</th>
                        <th class="px-6 py-5">Status / Tanggal</th>
                        <th class="px-6 py-5 text-right">Kontrol</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50/80 transition duration-200 group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-lg font-bold shadow-sm
                                    {{ $user->role == 'super_admin' ? 'bg-[#4B0082] text-white' : ($user->role == 'admin' ? 'bg-[#0B3C5D] text-white' : 'bg-[#E9ECEF] text-[#212529]')}}">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 text-base">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500 font-mono">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->role == 'super_admin')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-red-50 text-red-600 border border-red-100">
                                    <i class="fa-solid fa-shield-halved"></i> Super Admin
                                </span>
                            @elseif($user->role == 'admin')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-yellow-50 text-yellow-700 border border-yellow-100">
                                    <i class="fa-solid fa-user-gear"></i> Admin Ujian
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-purple-50 text-purple-700 border border-purple-100">
                                    <i class="fa-solid fa-user-graduate"></i> Peserta
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-gray-700">Terdaftar</span>
                                <span class="text-xs text-gray-400">{{ $user->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('super.users.edit', $user->id) }}" class="bg-white border border-gray-200 text-blue-600 hover:bg-blue-50 hover:border-blue-200 p-2 rounded-lg transition shadow-sm" title="Edit Data">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                @if($user->role !== 'super_admin')
                                <form action="{{ route('super.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini selamanya?');">
                                    @csrf @method('DELETE')
                                    <button class="bg-white border border-gray-200 text-red-500 hover:bg-red-50 hover:border-red-200 p-2 rounded-lg transition shadow-sm" title="Hapus User">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                            <i class="fa-solid fa-users-slash text-4xl mb-3"></i>
                            <p>Belum ada data user lain.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 text-xs text-gray-500 flex justify-between items-center">
            <span>Total Pengguna: <strong>{{ $users->count() }}</strong></span>
            <span><i class="fa-solid fa-info-circle mr-1"></i> Data diurutkan berdasarkan prioritas role.</span>
        </div>
    </div>
</div>
@endsection
