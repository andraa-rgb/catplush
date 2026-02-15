@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <div class="mb-6">
        <a href="{{ route('super.users.index') }}" class="text-gray-500 hover:text-purple-600 text-sm flex items-center gap-1">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke List
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Tambah User Baru</h1>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
        <form action="{{ route('super.users.store') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <!-- Nama -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500" required placeholder="Contoh: Panitia CPNS 2024">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500" required placeholder="admin@contoh.com">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" class="w-full rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500" required placeholder="Minimal 8 karakter">
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Hak Akses (Role)</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="admin" class="peer sr-only" checked>
                            <div class="p-4 rounded-lg border-2 border-gray-200 hover:bg-gray-50 peer-checked:border-yellow-400 peer-checked:bg-yellow-50 peer-checked:text-yellow-800 transition text-center">
                                <div class="font-bold mb-1"><i class="fa-solid fa-user-gear"></i> Admin Ujian</div>
                                <div class="text-xs text-gray-500">Kelola soal & peserta</div>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="student" class="peer sr-only">
                            <div class="p-4 rounded-lg border-2 border-gray-200 hover:bg-gray-50 peer-checked:border-gray-400 peer-checked:bg-gray-100 peer-checked:text-gray-800 transition text-center">
                                <div class="font-bold mb-1"><i class="fa-solid fa-user-graduate"></i> Peserta</div>
                                <div class="text-xs text-gray-500">Hanya mengerjakan ujian</div>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="super_admin" class="peer sr-only">
                            <div class="p-4 rounded-lg border-2 border-gray-200 hover:bg-gray-50 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-800 transition text-center">
                                <div class="font-bold mb-1"><i class="fa-solid fa-shield-halved"></i> Super Admin</div>
                                <div class="text-xs text-gray-500">Akses penuh sistem</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full bg-gray-900 text-white font-bold py-3 rounded-xl hover:bg-gray-800 transition shadow-lg">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection