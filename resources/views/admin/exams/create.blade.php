@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    
    <!-- Breadcrumb & Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <a href="{{ route('admin.exams.index') }}" class="text-slate-500 hover:text-blue-600 text-sm font-bold flex items-center gap-2 mb-2 transition">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
            </a>
            <h1 class="text-3xl font-extrabold text-slate-800">Buat Paket Ujian Baru</h1>
            <p class="text-slate-500 text-sm mt-1">Isi detail lengkap untuk membuat modul simulasi baru.</p>
        </div>
        <!-- Tombol Action Atas (Optional) -->
        <div class="flex gap-3">
            <button type="submit" form="create-exam-form" class="bg-slate-900 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-bold shadow-lg shadow-slate-300 transition flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Simpan
            </button>
        </div>
    </div>

    <form id="create-exam-form" action="{{ route('admin.exams.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- KOLOM KIRI: Informasi Utama (Judul & Deskripsi) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2 border-b border-slate-100 pb-4">
                        <i class="fa-solid fa-file-signature text-blue-500"></i> Informasi Umum
                    </h3>

                    <!-- Judul -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Judul Paket Ujian <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i class="fa-solid fa-heading text-slate-400"></i>
                            </div>
                            <input type="text" name="title" class="w-full pl-10 pr-4 py-3 rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 font-medium text-slate-700 shadow-sm transition placeholder-slate-400" placeholder="Misal: Simulasi SKD CPNS Paket 1 - 2025" required>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi & Keterangan</label>
                        <div class="relative">
                            <div class="absolute top-3.5 left-3.5 pointer-events-none">
                                <i class="fa-solid fa-align-left text-slate-400"></i>
                            </div>
                            <textarea name="description" rows="5" class="w-full pl-10 pr-4 py-3 rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-slate-700 shadow-sm transition placeholder-slate-400" placeholder="Tuliskan detail ujian, materi yang diujikan, atau instruksi khusus untuk peserta..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: Pengaturan (Waktu & Durasi) -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Card Pengaturan Waktu -->
                <div class="bg-slate-50 rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-sm font-bold text-slate-800 mb-4 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-sliders text-slate-500"></i> Konfigurasi
                    </h3>

                    <div class="space-y-5">
                        
                        <!-- Durasi -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Durasi (Menit) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="fa-regular fa-clock text-slate-400"></i>
                                </div>
                                <input type="number" name="duration_minutes" class="w-full pl-10 pr-12 py-2.5 rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 font-bold text-slate-700 shadow-sm" placeholder="100" required>
                                <span class="absolute right-4 top-2.5 text-xs font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded">Min</span>
                            </div>
                        </div>

                        <hr class="border-slate-200">

                        <!-- Jadwal Buka -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Jadwal Dibuka (Opsional)</label>
                            <div class="relative">
                                <input type="datetime-local" name="start_date" class="w-full rounded-lg border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 text-slate-600">
                            </div>
                        </div>

                        <!-- Jadwal Tutup -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Jadwal Ditutup (Opsional)</label>
                            <div class="relative">
                                <input type="datetime-local" name="end_date" class="w-full rounded-lg border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 text-slate-600">
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="bg-blue-100 border border-blue-200 rounded-lg p-3 text-xs text-blue-800 leading-relaxed">
                            <i class="fa-solid fa-circle-info mr-1"></i>
                            Jika jadwal dikosongkan, ujian dapat diakses kapan saja oleh peserta (Mode Latihan Bebas).
                        </div>

                    </div>
                </div>

                <!-- Tombol Mobile (Hanya muncul di layar kecil) -->
                <div class="block lg:hidden">
                    <button type="submit" class="w-full bg-slate-900 text-white py-3 rounded-xl font-bold shadow-lg">Simpan Paket</button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection