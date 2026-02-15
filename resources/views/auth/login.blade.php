<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Animated Background Blobs -->
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-40 right-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-1/2 w-72 h-72 bg-purple-100 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>

        <div class="w-full max-w-md">
            <!-- Header with Animation -->
            <div class="text-center mb-8 animate-fade-in">
                <div class="inline-flex items-center gap-3 px-6 py-3 rounded-full bg-gradient-to-r from-purple-100 to-purple-50 border border-purple-200 mb-6 hover:border-purple-400 transition-all">
                    <span class="text-2xl">📚</span>
                    <span class="text-sm font-semibold text-primary-700">Lab WICIDA</span>
                </div>

                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-2">
                    Selamat Datang
                </h1>
                <p class="text-lg text-gray-600">Sistem Jadwal Dosen Real-Time</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Login Card with Glass Effect -->
            <div class="glass card-modern animate-fade-in" style="animation-delay: 0.2s;">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-900 mb-3">
                            📧 Alamat Email
                        </label>
                        <div class="relative">
                            <input id="email" 
                                class="block w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition bg-white/50 backdrop-blur-sm placeholder:text-gray-400"
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autofocus 
                                autocomplete="username" 
                                placeholder="contoh@lab-wicida.ac.id" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 text-sm" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-900 mb-3">
                            🔐 Password
                        </label>
                        <div class="relative">
                            <input id="password" 
                                class="block w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition bg-white/50 backdrop-blur-sm placeholder:text-gray-400"
                                type="password" 
                                name="password" 
                                required 
                                autocomplete="current-password" 
                                placeholder="Masukkan password Anda" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" 
                            type="checkbox" 
                            class="w-5 h-5 text-primary-600 border-purple-300 rounded focus:ring-primary-500 cursor-pointer" 
                            name="remember">
                        <label for="remember_me" class="ms-3 text-sm text-gray-700 font-medium cursor-pointer">
                            Ingat saya di perangkat ini
                        </label>
                    </div>

                    <!-- Error Messages with Animation -->
                    @if ($errors->any())
                        <div class="p-4 bg-red-50 border-2 border-red-200 rounded-lg animate-shake">
                            <p class="text-sm text-red-800 font-bold mb-2">❌ Login Gagal</p>
                            <ul class="text-sm text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-start gap-2">
                                        <span>•</span>
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Submit Button with Hover Effect -->
                    <button type="submit" class="btn-primary w-full py-3 font-bold text-lg group">
                        <span class="inline-flex items-center gap-2">
                            🔓 Login
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </span>
                    </button>
                </form>

                <!-- Forgot Password Link -->
                @if (Route::has('password.request'))
                    <div class="mt-6 text-center border-t border-purple-100 pt-6">
                        <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-700 font-semibold transition inline-flex items-center gap-1">
                            🔑 Lupa password?
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Info Section with Gradient Background -->
            <div class="mt-8 p-6 rounded-2xl bg-gradient-light border border-purple-200 text-center">
                <p class="text-sm text-gray-700 font-semibold mb-2">
                    🔒 Sistem eksklusif untuk dosen Lab WICIDA
                </p>
                <p class="text-sm text-gray-600">
                    Tidak punya akun? Hubungi admin untuk aktivasi
                </p>
            </div>

            <!-- Demo Credentials (Optional - Remove in Production) -->
            @env('local')
                <div class="mt-6 p-4 rounded-lg bg-amber-50 border border-amber-200">
                    <p class="text-xs font-bold text-amber-900 mb-2">💡 Demo Akun (Development):</p>
                    <div class="space-y-1 text-xs text-amber-800">
                        <p><strong>Admin:</strong> admin@lab-wicida.ac.id / admin123</p>
                        <p><strong>Dosen:</strong> budi@lab-wicida.ac.id / password</p>
                    </div>
                </div>
            @endenv
        </div>
    </div>
</x-guest-layout>
