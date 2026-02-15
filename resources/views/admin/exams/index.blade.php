@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">

    <!-- 1. TAB NAVIGASI (Hanya Muncul untuk Super Admin) -->
    @if(Auth::user()->role === 'super_admin')
    <div class="flex items-center gap-2 mb-8 border-b border-slate-200 pb-1">
        <!-- Tab User (Link ke Users - Warna Netral) -->
        <a href="{{ route('super.users.index') }}" class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-slate-700 hover:bg-slate-50 rounded-t-lg transition">
            <i class="fa-solid fa-users-gear mr-2"></i> Manajemen User
        </a>

        <!-- Tab Ujian (AKTIF - Warna Biru) -->
        <a href="{{ route('admin.exams.index') }}" class="px-4 py-2 text-sm font-bold text-blue-600 border-b-2 border-blue-600 bg-blue-50/50 rounded-t-lg transition">
            <i class="fa-solid fa-file-pen mr-2"></i> Manajemen Ujian
        </a>
    </div>
    @endif

    <!-- 2. HEADER HALAMAN -->
    <!-- Menggunakan Gradient Slate-900 ke Blue-900 agar konsisten dengan Dashboard -->
    <div class="bg-gradient-to-r from-slate-900 to-blue-900 rounded-2xl p-8 mb-8 text-white shadow-xl relative overflow-hidden">
        <!-- Dekorasi Background -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl -mr-16 -mt-16"></div>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative z-10">
            <div>
                <h1 class="text-3xl font-bold flex items-center gap-3">
                    <i class="fa-solid fa-layer-group text-blue-300"></i> Daftar Paket Ujian
                </h1>
                <p class="text-slate-300 mt-2">Buat, edit, dan kelola bank soal untuk peserta ujian.</p>
            </div>

            <!-- Tombol Tambah Ujian (Putih Text Biru agar kontras) -->
            <a href="{{ route('admin.exams.create') }}" class="bg-white hover:bg-blue-50 text-blue-900 px-6 py-3 rounded-xl font-bold shadow-lg shadow-blue-900/20 flex items-center gap-2 transition transform hover:scale-105">
                <i class="fa-solid fa-plus"></i> Buat Ujian Baru
            </a>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3 shadow-sm">
        <div class="bg-emerald-100 p-2 rounded-full"><i class="fa-solid fa-check"></i></div>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <!-- 3. TABEL DAFTAR UJIAN -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-5">Judul Ujian</th>
                        <th class="px-6 py-5">Durasi</th>
                        <th class="px-6 py-5">Jumlah Soal</th>
                        <th class="px-6 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($exams as $exam)
                    <tr class="hover:bg-slate-50/80 transition duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold shadow-sm border border-blue-100">
                                    <i class="fa-solid fa-book"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-base">{{ $exam->title }}</p>
                                    <p class="text-xs text-slate-500 truncate max-w-xs">{{ Str::limit($exam->description, 50) }}</p>

                                    <!-- Indikator Tanggal (Optional jika ingin ditampilkan di list) -->
                                    @if($exam->start_date || $exam->end_date)
                                        <div class="mt-1 text-[10px] text-slate-400 flex gap-2">
                                            @if($exam->start_date) <span class="bg-slate-100 px-1.5 rounded">Mulai: {{ $exam->start_date->format('d/m H:i') }}</span> @endif
                                            @if($exam->end_date) <span class="bg-red-50 text-red-600 px-1.5 rounded">Selesai: {{ $exam->end_date->format('d/m H:i') }}</span> @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-700 px-2.5 py-1 rounded text-xs font-medium border border-slate-200">
                                <i class="fa-regular fa-clock"></i> {{ $exam->duration_minutes }} Menit
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 px-2.5 py-1 rounded text-xs font-bold border border-blue-100">
                                <i class="fa-solid fa-list-ol"></i> {{ $exam->questions_count }} Soal
                            </span>
                        </td>

                        <!-- KOLOM AKSI (Lengkap dengan Edit) -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">

                                <!-- 1. Edit Detail (Judul, Waktu) -->
                                <a href="{{ route('admin.exams.edit', $exam->id) }}" class="bg-white border border-slate-300 text-slate-500 hover:bg-slate-50 hover:text-blue-600 hover:border-blue-300 px-2.5 py-1.5 rounded-lg text-xs font-bold transition shadow-sm" title="Edit Informasi Ujian">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <!-- 2. Kelola Soal (Bank Soal) -->
                                <a href="{{ route('admin.exams.show', $exam->id) }}" class="bg-blue-50 text-blue-600 hover:bg-blue-100 border border-blue-200 px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1 shadow-sm">
                                    <i class="fa-solid fa-list-check"></i> Soal
                                </a>

                                <!-- 3. Hapus -->
                                <form action="{{ route('admin.exams.destroy', $exam->id) }}" method="POST" onsubmit="return confirm('Hapus ujian ini beserta seluruh soalnya?');">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 px-2.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1 shadow-sm" title="Hapus Paket Ujian">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <div class="bg-slate-50 p-4 rounded-full mb-3">
                                    <i class="fa-solid fa-folder-open text-4xl text-slate-300"></i>
                                </div>
                                <p class="font-medium text-slate-600">Belum ada paket ujian.</p>
                                <p class="text-xs mt-1">Klik tombol "Buat Ujian Baru" di pojok kanan atas.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
