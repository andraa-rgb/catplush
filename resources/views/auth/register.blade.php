<x-guest-layout>
    <!-- Header Form -->
    <div class="mb-8">
        <a href="/" class="hidden lg:inline-flex items-center gap-2 mb-6 text-slate-500 hover:text-slate-800 transition text-sm font-medium">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900">Buat Akun Baru 🚀</h1>
        <p class="text-slate-500 mt-2">Gabung sekarang dan mulai ujian online Anda.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-bold text-slate-700 mb-1">Nama Lengkap</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-regular fa-user text-slate-400"></i>
                </div>
                <!-- Ubah focus ring ke Blue -->
                <input id="name" class="block mt-1 w-full pl-10 pr-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-blue-500 transition text-sm text-slate-800 placeholder-slate-400" 
                       type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-slate-700 mb-1">Alamat Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-regular fa-envelope text-slate-400"></i>
                </div>
                <input id="email" class="block mt-1 w-full pl-10 pr-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-blue-500 transition text-sm text-slate-800 placeholder-slate-400" 
                       type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-slate-700 mb-1">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-lock text-slate-400"></i>
                </div>
                <input id="password" class="block mt-1 w-full pl-10 pr-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-blue-500 transition text-sm text-slate-800 placeholder-slate-400"
                       type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-1">Konfirmasi Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-check-double text-slate-400"></i>
                </div>
                <input id="password_confirmation" class="block mt-1 w-full pl-10 pr-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-blue-500 transition text-sm text-slate-800 placeholder-slate-400"
                       type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Tombol Daftar (Slate-900) -->
        <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-bold py-3.5 rounded-xl shadow-lg shadow-slate-300 transition transform hover:-translate-y-0.5 mt-2 flex justify-center items-center gap-2">
            <span>Daftar Akun</span>
            <i class="fa-solid fa-user-plus"></i>
        </button>
    </form>

    <!-- Footer Link -->
    <div class="mt-8 text-center">
        <p class="text-sm text-slate-600">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:underline hover:text-blue-800">
                Masuk disini
            </a>
        </p>
    </div>
</x-guest-layout>