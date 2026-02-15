@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">

    <!-- 1. HERO BANNER (Professional Slate/Blue Theme) -->
    <!-- Mengganti warna Ungu ke Slate/Blue agar senada dengan Welcome Page -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-blue-900 rounded-3xl p-8 md:p-10 text-white shadow-2xl relative overflow-hidden mb-8 border border-slate-700">
        
        <!-- Dekorasi Background (Sama dengan Welcome) -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-blue-500 opacity-10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 bg-indigo-500 opacity-20 rounded-full blur-2xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
            <!-- Teks Sambutan -->
            <div class="text-center md:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-bold mb-3 backdrop-blur-sm text-blue-200">
                    <i class="fa-solid fa-circle-check text-[10px]"></i>
                    <span>Sistem Siap Digunakan</span>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold mb-3 tracking-tight leading-tight">
                    Halo, {{ Auth::user()->name }}!
                </h1>
                <p class="text-slate-300 text-base md:text-lg max-w-xl leading-relaxed">
                    @if(Auth::user()->role == 'super_admin')
                        Akses <strong>Super Admin</strong>. Kontrol penuh atas user, sistem, dan konfigurasi global.
                    @elseif(Auth::user()->role == 'admin')
                        Akses <strong>Admin Ujian</strong>. Kelola bank soal dan monitoring peserta ujian.
                    @else
                        Selamat datang di platform ujian. Pilih modul ujian di bawah untuk memulai sesi.
                    @endif
                </p>
            </div>
            
            <!-- Kotak Statistik (Style Tech / Dark Mode) -->
            <div class="flex gap-4">
                <div class="bg-slate-800/50 backdrop-blur-md border border-slate-600 rounded-2xl p-4 text-center min-w-[110px] transform hover:scale-105 transition duration-300">
                    <div class="text-3xl font-bold text-white mb-1">{{ $totalExamFinished ?? 0 }}</div>
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Selesai</div>
                </div>
                <div class="bg-slate-800/50 backdrop-blur-md border border-slate-600 rounded-2xl p-4 text-center min-w-[110px] transform hover:scale-105 transition duration-300">
                    <div class="text-3xl font-bold text-blue-400 mb-1">{{ number_format($averageScore ?? 0, 1) }}</div>
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Rata-Rata</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. AKSES PANEL (Style Clean & Minimalis) -->
    @if(Auth::user()->role !== 'student')
    <div class="mb-10">
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden group hover:shadow-md transition duration-300">
            <!-- Dekorasi Hover -->
            <div class="absolute right-0 top-0 w-32 h-32 bg-slate-50 rounded-full blur-3xl -mr-10 -mt-10 group-hover:bg-blue-50 transition"></div>

            <div class="flex items-center gap-5 relative z-10">
                <!-- Icon: Slate Background (Sama seperti fitur di Welcome) -->
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shadow-sm border border-slate-100
                    {{ Auth::user()->role == 'super_admin' ? 'bg-slate-900 text-red-500' : 'bg-slate-900 text-yellow-500' }}">
                    @if(Auth::user()->role == 'super_admin')
                        <i class="fa-solid fa-user-shield"></i>
                    @else
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    @endif
                </div>
                
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">
                        Panel {{ Auth::user()->role == 'super_admin' ? 'Super Administrator' : 'Administrator' }}
                    </h3>
                    <p class="text-sm text-slate-500">
                        {{ Auth::user()->role == 'super_admin' ? 'Kelola pengguna, admin lain, dan pengaturan sistem.' : 'Kelola bank soal, jadwal, dan sesi ujian aktif.' }}
                    </p>
                </div>
            </div>
            
            <!-- Tombol Action -->
            <a href="{{ Auth::user()->role == 'super_admin' ? route('super.users.index') : route('admin.exams.index') }}" 
               class="relative z-10 px-8 py-3 rounded-full font-bold text-white shadow-lg transform hover:-translate-y-1 transition flex items-center gap-2 w-full md:w-auto justify-center
               {{ Auth::user()->role == 'super_admin' ? 'bg-red-600 hover:bg-red-700 shadow-red-200' : 'bg-slate-900 hover:bg-black shadow-slate-300' }}">
                <span>Masuk Panel</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
    @endif

    <!-- 3. KATALOG UJIAN -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($exams as $exam)
        
        @php
            $now = \Carbon\Carbon::now();
            $isUpcoming = $exam->start_date && $now->lt($exam->start_date); // Belum mulai
            $isExpired  = $exam->end_date && $now->gt($exam->end_date);    // Sudah lewat
            $isOpen     = !$isUpcoming && !$isExpired;                     // Sedang buka
        @endphp

        <div class="group bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:border-blue-200 hover:-translate-y-1 transition duration-300 flex flex-col h-full relative">
            
            <!-- Badge Status Ketersediaan -->
            <div class="absolute top-4 right-4 z-10">
                @if($isUpcoming)
                    <span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-yellow-200 uppercase tracking-wide flex items-center gap-1">
                        <i class="fa-solid fa-lock"></i> Belum Mulai
                    </span>
                @elseif($isExpired)
                    <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-red-200 uppercase tracking-wide flex items-center gap-1">
                        <i class="fa-solid fa-circle-xmark"></i> Ditutup
                    </span>
                @else
                    <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-emerald-200 uppercase tracking-wide flex items-center gap-1">
                        <i class="fa-solid fa-door-open"></i> Tersedia
                    </span>
                @endif
            </div>

            <div class="p-6 flex-1 relative">
                <div class="relative z-10">
                    <!-- Icon -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-600 w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shadow-sm mb-5 border border-blue-100 {{ $isOpen ? 'group-hover:scale-110' : 'grayscale opacity-70' }} transition duration-300">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    
                    <h3 class="font-bold text-lg text-slate-900 mb-2 leading-tight group-hover:text-blue-700 transition">{{ $exam->title }}</h3>
                    <p class="text-slate-500 text-sm mb-4 line-clamp-2">{{ $exam->description ?? 'Modul ujian standar.' }}</p>

                    <!-- Info Waktu -->
                    <div class="space-y-1 text-xs text-slate-500 bg-slate-50 p-2 rounded-lg border border-slate-100 mb-4">
                        @if($exam->start_date)
                            <div class="flex justify-between">
                                <span>Mulai:</span> <span class="font-bold text-slate-700">{{ $exam->start_date->format('d M H:i') }}</span>
                            </div>
                        @endif
                        @if($exam->end_date)
                            <div class="flex justify-between">
                                <span>Selesai:</span> <span class="font-bold text-red-600">{{ $exam->end_date->format('d M H:i') }}</span>
                            </div>
                        @else
                            <div class="flex justify-between">
                                <span>Batas:</span> <span class="font-bold text-emerald-600">Tidak Ada</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex items-center gap-4 text-xs font-medium text-slate-500 border-t border-slate-100 pt-4">
                        <span class="flex items-center gap-1.5"><i class="fa-regular fa-clock text-blue-400"></i> {{ $exam->duration_minutes }} Menit</span>
                        <span class="flex items-center gap-1.5"><i class="fa-solid fa-list-check text-blue-400"></i> {{ $exam->questions_count }} Soal</span>
                    </div>
                </div>
            </div>

            <!-- Footer Action -->
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-100">
                @if($isOpen)
                    <form action="{{ route('exams.start', $exam->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-slate-900 text-white font-bold py-3 rounded-xl hover:bg-blue-600 transition shadow-lg group-hover:shadow-blue-200 flex items-center justify-center gap-2">
                            <span>Mulai Kerjakan</span>
                            <i class="fa-solid fa-chevron-right text-xs opacity-50 group-hover:translate-x-1 transition"></i>
                        </button>
                    </form>
                @elseif($isUpcoming)
                    <button disabled class="w-full bg-slate-200 text-slate-400 font-bold py-3 rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                        <span>Segera Hadir</span>
                        <i class="fa-solid fa-hourglass-start"></i>
                    </button>
                @else
                    <button disabled class="w-full bg-red-50 text-red-300 font-bold py-3 rounded-xl cursor-not-allowed flex items-center justify-center gap-2 border border-red-100">
                        <span>Waktu Habis</span>
                        <i class="fa-solid fa-ban"></i>
                    </button>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center">
            <div class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 text-3xl">
                <i class="fa-solid fa-folder-open"></i>
            </div>
            <h3 class="text-slate-800 font-bold text-lg">Belum Ada Modul</h3>
            <p class="text-slate-500 text-sm">Silakan buat paket soal baru melalui panel admin.</p>
        </div>
        @endforelse
    </div>

</div>
@endsection