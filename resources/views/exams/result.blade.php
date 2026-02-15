@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        
        <!-- Header: Total Skor -->
        <div class="relative py-12 px-6 text-center bg-gradient-to-r from-gray-800 to-gray-900 text-white overflow-hidden">
            <!-- Dekorasi -->
            <div class="absolute top-0 right-0 -mr-10 -mt-10 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 bg-purple-400 opacity-20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10">
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-2">
                    Hasil Ujian
                </h1>
                <p class="text-gray-300 text-lg font-medium">{{ $session->exam->title }}</p>
                
                <!-- Total Skor Besar -->
                <div class="mt-8 inline-block bg-white/10 backdrop-blur-md rounded-3xl px-12 py-6 border border-white/20 shadow-2xl">
                    <span class="block text-xs text-gray-300 uppercase tracking-widest font-bold mb-1">Total Skor Perolehan</span>
                    <span class="text-7xl font-black tracking-tighter">{{ $session->total_score }}</span>
                </div>
            </div>
        </div>

        <!-- Detail Statistik (Grid) -->
        <div class="p-8">
            <h3 class="text-center text-gray-500 font-bold uppercase tracking-wide text-xs mb-8">Statistik Pengerjaan</h3>
            
            <!-- Grid Statistik Utama -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <!-- Total Soal -->
                <div class="p-5 bg-gray-50 rounded-2xl text-center border border-gray-100">
                    <div class="text-gray-400 mb-2"><i class="fa-solid fa-list-ol text-xl"></i></div>
                    <span class="block text-xs text-gray-500 uppercase font-bold">Total Soal</span>
                    <span class="block text-2xl font-bold text-gray-800">{{ $totalQuestions }}</span>
                </div>

                <!-- Dijawab -->
                <div class="p-5 bg-blue-50 rounded-2xl text-center border border-blue-100">
                    <div class="text-blue-400 mb-2"><i class="fa-solid fa-pen-to-square text-xl"></i></div>
                    <span class="block text-xs text-blue-500 uppercase font-bold">Dijawab</span>
                    <span class="block text-2xl font-bold text-blue-700">{{ $answeredCount }}</span>
                </div>

                <!-- Benar -->
                <div class="p-5 bg-green-50 rounded-2xl text-center border border-green-100">
                    <div class="text-green-400 mb-2"><i class="fa-solid fa-check text-xl"></i></div>
                    <span class="block text-xs text-green-500 uppercase font-bold">Jawaban Benar</span>
                    <span class="block text-2xl font-bold text-green-700">{{ $correctAnswers }}</span>
                </div>

                <!-- Waktu Selesai -->
                <div class="p-5 bg-purple-50 rounded-2xl text-center border border-purple-100">
                    <div class="text-purple-400 mb-2"><i class="fa-regular fa-clock text-xl"></i></div>
                    <span class="block text-xs text-purple-500 uppercase font-bold">Selesai Pukul</span>
                    <span class="block text-lg font-bold text-purple-700 mt-1">{{ $session->updated_at->format('H:i') }} WIB</span>
                </div>
            </div>

            <!-- Pesan / Motivasi Singkat -->
            <div class="text-center py-6 border-t border-gray-100">
                <p class="text-gray-600 italic">
                    "Hasil tidak akan mengkhianati usaha. Teruslah berlatih!"
                </p>
            </div>

            <!-- Footer Buttons -->
            <div class="mt-6 flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 transition shadow-lg text-center flex items-center justify-center gap-2">
                    <i class="fa-solid fa-house"></i> Kembali ke Dashboard
                </a>
                <a href="{{ route('exams.history') }}" class="px-8 py-3 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition shadow-sm text-center flex items-center justify-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left"></i> Lihat Riwayat
                </a>
            </div>
        </div>
    </div>
</div>
@endsection