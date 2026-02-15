<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CAT+</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <!-- NAVBAR -->
    <nav class="bg-white sticky top-0 z-50 shadow-sm border-b border-slate-200 backdrop-blur-md bg-opacity-95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- KIRI: LOGO & MENU UMUM -->
                <div class="flex items-center gap-8">
                    <!-- LOGO: Ganti Gradient Ungu ke Blue/Indigo -->
                    <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                        <div class="bg-gradient-to-br from-blue-600 to-indigo-600 text-white rounded-lg p-1.5 text-sm font-extrabold shadow-md group-hover:shadow-lg transition">CAT+</div>
                        <span class="font-bold text-xl text-slate-800">Simulasi<span class="text-blue-600">CAT</span></span>
                    </a>

                    <!-- MENU DASHBOARD & RIWAYAT -->
                    <div class="hidden md:flex items-center space-x-1">
                        @auth
                            <!-- Link Dashboard: Hover Blue -->
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ request()->is('dashboard') ? 'bg-slate-100 font-bold text-slate-900' : 'text-slate-500 hover:text-blue-600 hover:bg-slate-50' }}">
                                Dashboard
                            </a>

                            <!-- Link Riwayat: Hover Blue -->
                            <a href="{{ route('exams.history') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ request()->routeIs('exams.history') ? 'bg-slate-100 font-bold text-slate-900' : 'text-slate-500 hover:text-blue-600 hover:bg-slate-50' }}">
                                Riwayat
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- KANAN: PANEL ADMIN & PROFIL -->
                <div class="flex items-center gap-3">
                    @auth
                        <!-- TOMBOL PANEL (Super Admin Merah, Admin Slate/Hitam) -->
                        @if(Auth::user()->hasRole(['super_admin', 'admin']))
                            <a href="{{ Auth::user()->role === 'super_admin' ? route('super.users.index') : route('admin.exams.index') }}"
                               class="hidden md:flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold text-white shadow-lg transform hover:-translate-y-0.5 transition
                               {{ Auth::user()->role === 'super_admin' ? 'bg-red-600 hover:bg-red-700' : 'bg-slate-900 hover:bg-black' }}">
                                <i class="fa-solid {{ Auth::user()->role === 'super_admin' ? 'fa-shield-cat' : 'fa-lock' }}"></i>
                                {{ Auth::user()->role === 'super_admin' ? 'Panel Super' : 'Panel Admin' }}
                            </a>
                        @endif

                        <!-- Profil Dropdown -->
                        <div class="relative group py-2 pl-2">
                            <button class="flex items-center gap-2 focus:outline-none">
                                <div class="text-right hidden sm:block">
                                    <span class="block text-sm font-bold text-slate-800">{{ Auth::user()->name }}</span>
                                    <!-- Badge Role: Ganti Ungu ke Biru untuk Student -->
                                    <span class="block text-[10px] font-bold uppercase tracking-wider {{ Auth::user()->role == 'super_admin' ? 'text-red-500' : (Auth::user()->role == 'admin' ? 'text-yellow-600' : 'text-blue-600') }}">
                                        {{ str_replace('_', ' ', Auth::user()->role) }}
                                    </span>
                                </div>
                                <div class="h-9 w-9 rounded-full bg-slate-100 flex items-center justify-center border border-slate-200 text-slate-600">
                                    <span class="font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            </button>

                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 p-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition">
                                        <i class="fa-solid fa-power-off"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Tombol Login/Register -->
                        <a href="{{ route('login') }}" class="font-bold text-sm px-4 text-slate-600 hover:text-blue-600">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-slate-900 text-white px-5 py-2 rounded-full text-sm font-bold hover:bg-black transition shadow-lg">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-slate-200 mt-auto py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-slate-500 text-sm font-medium">&copy; {{ date('Y') }} CAT+ System. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
