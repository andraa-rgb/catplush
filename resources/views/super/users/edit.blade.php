@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">

    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('super.users.index') }}" class="text-gray-500 hover:text-purple-600 text-sm font-medium flex items-center gap-2 transition">
            <i class="fa-solid fa-arrow-left-long"></i> Kembali ke Daftar User
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">

        <!-- Header Form -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h1 class="text-xl font-semibold text-gray-900 tracking-tight">Edit Data Pengguna</h1>
                <p class="text-sm text-gray-500 mt-1">Perbarui informasi profil dan hak akses.</p>
            </div>
            <div class="w-11 h-11 rounded-full bg-indigo-200 text-indigo-700 flex items-center justify-center font-semibold text-lg shadow-sm">{{ substr($user->name, 0, 1) }} </div>
        </div>


        <form action="{{ route('super.users.update', $user->id) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">

                <!-- Grid Nama & Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50/50" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               class="w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50/50" required>
                    </div>
                </div>

                <!-- Ganti Password -->
                <div class="bg-white rounded-xl p-5 ">
                    <label class="block text-xs font-bold text-yellow-700 uppercase mb-2">
                        <i class="fa-solid fa-key mr-1"></i> Ganti Password (Opsional)
                    </label>
                    <input type="password" name="password"
                           class="w-full rounded-xl border-yellow-200 focus:ring-yellow-500 focus:border-yellow-500 placeholder-gray-400 text-sm"
                           placeholder="Kosongkan jika tidak ingin mengubah password...">
                    <p class="text-[10px] text-yellow-600 mt-2">*Minimal 8 karakter jika diisi.</p>
                </div>

                <!-- Role Selection -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-3">Hak Akses (Role)</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <!-- Pilihan Admin -->
                        <label class="cursor-pointer relative group">
                            <input type="radio" name="role" value="admin" class="peer sr-only" {{ $user->role == 'admin' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl border-2 border-gray-200 bg-white hover:border-[#C2A24A] peer-checked:border-[#B8962E] peer-checked:bg-[#F6F2E6] transition text-center h-full">
                                <div class="text-2xl text-gray-300 peer-checked:text-[#B8962E] mb-2 group-hover:text-[#C2A24A]"><i class="fa-solid fa-user-gear"></i></div>
                                <div class="font-bold text-gray-700 peer-checked:text-[#7A5F12]">Admin Ujian</div>
                                <div class="text-[10px] text-gray-400 mt-1">Mengelola ujian dan soal</div>
                            </div>
                        </label>


                        <!-- Pilihan Student -->
                        <label class="cursor-pointer relative group">
                            <input type="radio" name="role" value="student" class="peer sr-only" {{ $user->role == 'student' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl border-2 border-gray-200 bg-white hover:border-[#7B6FA3] peer-checked:border-[#6B5B95] peer-checked:bg-[#F1EEF7] transition text-center h-full">
                                <div class="text-2xl text-gray-300 peer-checked:text-[#6B5B95] mb-2 group-hover:text-[#7B6FA3]"><i class="fa-solid fa-user-graduate"></i></div>
                                <div class="font-bold text-gray-700 peer-checked:text-[#4B3F72]">Peserta</div>
                                <div class="text-[10px] text-gray-400 mt-1">Hanya mengikuti ujian</div>
                            </div>
                        </label>


                        <!-- Pilihan Super Admin -->
                        <label class="cursor-pointer relative group">
                            <input type="radio" name="role" value="super_admin" class="peer sr-only" {{ $user->role == 'super_admin' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl border-2 border-gray-200 bg-white hover:border-[#A12A2A] peer-checked:border-[#7A1A1A] peer-checked:bg-[#F3EAEA] transition text-center h-full">
                                <div class="text-2xl text-gray-300 peer-checked:text-[#8B1E1E] mb-2 group-hover:text-[#A12A2A]"><i class="fa-solid fa-shield-halved"></i></div>
                                <div class="font-bold text-gray-700 peer-checked:text-[#5F1414]">Super Admin</div>
                                <div class="text-[10px] text-gray-400 mt-1">Full akses sistem</div>
                            </div>
                        </label>


                    </div>
                </div>

            </div>

            <!-- Footer Buttons -->
            <div class="mt-8 pt-6 border-t border-gray-100 flex gap-3">
                <button type="submit" class="flex-1 bg-gray-900 text-white font-bold py-3 rounded-xl hover:bg-black transition shadow-lg flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
                <a href="{{ route('super.users.index') }}" class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
