<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CAT+') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Tailwind CSS & Icons -->
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="antialiased bg-white">
        
        <div class="min-h-screen flex w-full">
            
            <!-- BAGIAN KIRI: Form Container (Putih Bersih) -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 md:px-16 lg:px-24 bg-white z-10">
                
                <!-- Header Mobile Logo (Hanya muncul di HP) -->
                <div class="lg:hidden mb-8 text-center">
                    <a href="/" class="inline-flex items-center gap-2">
                        <!-- Logo Gradient Blue/Indigo -->
                        <div class="bg-gradient-to-br from-blue-600 to-indigo-600 text-white rounded p-1.5 text-sm font-extrabold shadow-md">CAT+</div>
                        <span class="font-bold text-xl text-slate-800">Simulasi<span class="text-blue-600">CAT</span></span>
                    </a>
                </div>

                <!-- Slot Konten (Login/Register Form masuk sini) -->
                <div class="w-full max-w-md mx-auto">
                    {{ $slot }}
                </div>

                <!-- Footer Copyright -->
                <div class="mt-10 text-center text-xs text-slate-400">
                    &copy; {{ date('Y') }} CAT+ System. Secure CBT Platform.
                </div>
            </div>

            <!-- BAGIAN KANAN: Hero Image & Branding (Hidden di Mobile) -->
            <!-- Menggunakan Gradient Slate ke Blue (Professional Theme) -->
            <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900 text-white relative overflow-hidden items-center justify-center">
                
                <!-- Background Decoration -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-blue-500 opacity-20 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-indigo-500 opacity-20 rounded-full blur-3xl"></div>
                
                <!-- Pattern Overlay -->
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>

                <!-- Content -->
                <div class="relative z-10 max-w-lg text-center px-8">
                    <div class="mb-8 flex justify-center">
                        <!-- Icon Box Glassmorphism -->
                        <div class="w-24 h-24 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-2xl border border-white/10 transform rotate-3 hover:rotate-0 transition duration-500">
                            <i class="fa-solid fa-layer-group text-5xl text-blue-300"></i>
                        </div>
                    </div>
                    
                    <h2 class="text-4xl font-bold mb-4 leading-tight">
                        Platform Evaluasi <br>
                        <span class="text-blue-400">Cerdas & Terintegrasi</span>
                    </h2>
                    
                    <p class="text-slate-300 text-lg leading-relaxed">
                        Kelola ujian, analisis kompetensi, dan rekrutmen dengan sistem CAT modern yang didukung teknologi AI.
                    </p>
                    
                    <!-- Stats Kecil -->
                    <div class="mt-12 flex justify-center gap-10 border-t border-white/10 pt-8">
                        <div>
                            <span class="block text-3xl font-bold text-white">AI</span>
                            <span class="text-xs text-blue-200 uppercase tracking-wider font-semibold">Powered</span>
                        </div>
                        <div class="w-px bg-white/20 h-10 my-auto"></div>
                        <div>
                            <span class="block text-3xl font-bold text-white">Fast</span>
                            <span class="text-xs text-blue-200 uppercase tracking-wider font-semibold">Performance</span>
                        </div>
                        <div class="w-px bg-white/20 h-10 my-auto"></div>
                        <div>
                            <span class="block text-3xl font-bold text-white">100%</span>
                            <span class="text-xs text-blue-200 uppercase tracking-wider font-semibold">Secure</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>