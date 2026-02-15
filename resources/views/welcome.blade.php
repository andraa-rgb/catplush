@extends('layouts.app')

@section('content')
<div class="bg-white overflow-x-hidden font-sans">

    <!-- 1. HERO SECTION (Platform CBT Modern) -->
    <div class="relative pt-20 pb-20 lg:pt-32 lg:pb-32 overflow-hidden bg-slate-50">
        <!-- Background Decor (Animasi Blob Halus) -->
        <div class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full z-0 pointer-events-none">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-0 right-1/4 w-96 h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-0 left-1/3 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <!-- Badge Technology -->
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white text-slate-800 text-xs font-bold mb-8 shadow-sm border border-slate-200 hover:scale-105 transition duration-300 cursor-default">
                <i class="fa-solid fa-wand-magic-sparkles text-purple-600 text-sm"></i>
                <span>Powered by AI Question Generator</span>
            </div>

            <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tight mb-6 leading-tight">
                Ujian Online <br />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Lebih Cepat & Cerdas.</span>
            </h1>
            
            <p class="mt-4 max-w-2xl mx-auto text-xl text-slate-600 mb-10 leading-relaxed">
                Platform CAT <em>(Computer Assisted Test)</em> modern untuk sekolah, perusahaan, dan simulasi CPNS. Buat soal otomatis dengan AI dalam hitungan detik.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-8 py-4 rounded-full bg-slate-900 text-white font-bold text-lg shadow-xl hover:bg-black transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        Masuk Dashboard <i class="fa-solid fa-arrow-right"></i>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="px-8 py-4 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-lg shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition transform hover:-translate-y-1">
                        Daftar Gratis
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-4 rounded-full bg-white text-slate-700 border border-slate-300 font-bold text-lg hover:bg-slate-50 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-right-to-bracket"></i> Masuk
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- 2. AI FEATURE SECTION (Highlight Utama) -->
    <div class="bg-slate-900 py-20 relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-600 rounded-full blur-[120px] opacity-20"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-600 rounded-full blur-[120px] opacity-20"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-sm text-blue-400 font-bold tracking-wide uppercase mb-2">Revolusi Pembuatan Soal</h2>
                <p class="text-3xl md:text-4xl font-extrabold text-white">
                    Hemat Waktu Admin hingga <span class="text-yellow-400">90%</span>
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 p-8 rounded-2xl hover:bg-slate-800 transition duration-300 group">
                    <div class="w-14 h-14 bg-slate-900 rounded-xl flex items-center justify-center text-2xl text-purple-400 mb-6 group-hover:scale-110 transition border border-slate-700 shadow-lg">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">AI Generator</h3>
                    <p class="text-slate-400 leading-relaxed text-sm">
                        Cukup ketik topik (misal: "Sejarah Indonesia"), AI akan membuatkan soal pilihan ganda lengkap dengan kunci jawaban secara instan.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 p-8 rounded-2xl hover:bg-slate-800 transition duration-300 group">
                    <div class="w-14 h-14 bg-slate-900 rounded-xl flex items-center justify-center text-2xl text-green-400 mb-6 group-hover:scale-110 transition border border-slate-700 shadow-lg">
                        <i class="fa-solid fa-file-excel"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Import Excel</h3>
                    <p class="text-slate-400 leading-relaxed text-sm">
                        Punya bank soal di file Excel? Upload filenya, dan ratusan soal akan masuk ke sistem dalam hitungan detik.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 p-8 rounded-2xl hover:bg-slate-800 transition duration-300 group">
                    <div class="w-14 h-14 bg-slate-900 rounded-xl flex items-center justify-center text-2xl text-blue-400 mb-6 group-hover:scale-110 transition border border-slate-700 shadow-lg">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Manajemen Mudah</h3>
                    <p class="text-slate-400 leading-relaxed text-sm">
                        Kelola ujian, pantau peserta real-time, dan reset sesi ujian dengan panel admin yang intuitif dan mudah digunakan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. GENERAL FEATURES (Platform Overview) -->
    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <!-- Content Left -->
                <div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6">
                        Pengalaman Ujian yang <br>
                        <span class="text-indigo-600">Nyaman & Fokus.</span>
                    </h2>
                    <p class="text-slate-600 text-lg mb-8 leading-relaxed">
                        Antarmuka peserta didesain bersih dan minimalis agar peserta dapat fokus mengerjakan soal tanpa gangguan.
                    </p>

                    <ul class="space-y-6">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 mt-1">
                                <i class="fa-solid fa-stopwatch"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold text-slate-900">Timer Presisi</h4>
                                <p class="text-slate-500 text-sm">Waktu berjalan mundur dan akan otomatis menutup ujian saat habis.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mt-1">
                                <i class="fa-solid fa-square-check"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold text-slate-900">Hasil Real-time</h4>
                                <p class="text-slate-500 text-sm">Skor langsung muncul begitu ujian selesai. Transparan dan akurat.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mt-1">
                                <i class="fa-solid fa-mobile-screen"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold text-slate-900">Responsif</h4>
                                <p class="text-slate-500 text-sm">Dapat diakses dengan lancar melalui Laptop, Tablet, maupun Smartphone.</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Image Right -->
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-3xl transform rotate-3 scale-105"></div>
                    <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80" alt="Online Exam" class="relative rounded-3xl shadow-xl w-full object-cover h-[450px]">
                </div>
            </div>
        </div>
    </div>

    <!-- 4. FOOTER / CTA -->
    <div class="bg-slate-50 border-t border-slate-200 py-16">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-extrabold text-slate-900 sm:text-4xl">
                Siap untuk memulai?
            </h2>
            <p class="mt-4 text-lg text-slate-600">
                Bergabunglah sekarang dan rasakan kemudahan membuat ujian online.
            </p>
            <div class="mt-8 flex justify-center gap-4">
                <a href="{{ route('register') }}" class="px-8 py-3 rounded-full bg-slate-900 text-white font-bold hover:bg-black transition shadow-lg">
                    Buat Akun Gratis
                </a>
            </div>
        </div>
    </div>

</div>

<!-- CSS Animasi Blob -->
<style>
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    .animation-delay-4000 {
        animation-delay: 4s;
    }
</style>
@endsection