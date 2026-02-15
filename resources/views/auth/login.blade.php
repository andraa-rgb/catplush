<x-guest-layout>
    <!-- Header Form -->
    <div class="mb-8">
        <a href="/" class="hidden lg:inline-flex items-center gap-2 mb-6 text-slate-500 hover:text-slate-800 transition text-sm font-medium">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900">Selamat Datang! 👋</h1>
        <p class="text-slate-500 mt-2">Masukan kredensial Anda untuk mengakses sistem.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-slate-700 mb-1">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-regular fa-envelope text-slate-400"></i>
                </div>
                <!-- Ubah focus ring ke Blue -->
                <input id="email" class="block mt-1 w-full pl-10 pr-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-blue-500 transition text-sm text-slate-800 placeholder-slate-400" 
                       type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1">
                <label for="password" class="block text-sm font-bold text-slate-700">Password</label>
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-lock text-slate-400"></i>
                </div>
                <input id="password" class="block mt-1 w-full pl-10 pr-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-blue-500 transition text-sm text-slate-800 placeholder-slate-400"
                       type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-slate-900 shadow-sm focus:ring-slate-900" name="remember">
                <span class="ml-2 text-sm text-slate-600">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-bold text-blue-600 hover:text-blue-800 transition" href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
            @endif
        </div>

        <!-- Tombol Login (Ganti ke Slate-900 agar konsisten dengan Welcome Page) -->
        <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-bold py-3.5 rounded-xl shadow-lg shadow-slate-300 transition transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
            <span>Masuk Sekarang</span>
            <i class="fa-solid fa-arrow-right-to-bracket"></i>
        </button>
    </form>

    <!-- Footer Link -->
    <div class="mt-8 text-center">
        <p class="text-sm text-slate-600">
            Belum memiliki akun? 
            <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:underline hover:text-blue-800">
                Daftar Gratis
            </a>
        </p>
    </div>
</x-guest-layout>