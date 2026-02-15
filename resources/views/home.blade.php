<x-app-layout>
    @section('title', 'Beranda - Lab WICIDA')

    <!-- Hero Section -->
    <div class="relative min-h-screen flex flex-col items-center justify-center py-12 px-4 overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-40 right-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-1/2 w-72 h-72 bg-purple-100 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>

        <!-- Hero Content -->
        <div class="max-w-5xl mx-auto text-center mb-16 animate-fade-in">
            <div class="inline-flex items-center gap-3 px-6 py-3 rounded-full bg-gradient-to-r from-purple-100 to-purple-50 border border-purple-200 mb-6 hover:border-purple-400 transition-all">
                <span class="text-2xl">📚</span>
                <span class="text-sm font-semibold text-purple-700">Lab WICIDA - Sistem Terpadu</span>
            </div>

            <h1 class="section-title">
                Jadwal Dosen Real-Time<br>
                <span class="text-purple-600">Yang Transparan & Modern</span>
            </h1>

            <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                Platform booking konsultasi yang memudahkan mahasiswa bertemu dosen dengan status real-time 
                dan jadwal yang jelas.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <!-- Ganti route() dengan link ke API atau halaman statis -->
                <a href="/login" class="btn-primary">
                    🔐 Login Dosen
                </a>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="max-w-5xl mx-auto w-full mb-20">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card-modern text-center hover-lift">
                    <div class="text-4xl mb-3">👨‍🏫</div>
                    <h3 class="text-2xl font-bold text-purple-700 mb-2">
                        {{ $dosens->count() ?? 0 }} Dosen
                    </h3>
                    <p class="text-gray-600">Profesional Lab WICIDA</p>
                </div>

                <div class="card-modern text-center hover-lift">
                    <div class="text-4xl mb-3">🟢</div>
                    <h3 class="text-2xl font-bold text-purple-700 mb-2">Real-Time</h3>
                    <p class="text-gray-600">Status dosen terkini</p>
                </div>

                <div class="card-modern text-center hover-lift">
                    <div class="text-4xl mb-3">📅</div>
                    <h3 class="text-2xl font-bold text-purple-700 mb-2">Booking</h3>
                    <p class="text-gray-600">Konsultasi mudah</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dosen Cards Section -->
    <div class="max-w-6xl mx-auto px-4 mb-16">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 text-center">
            👨‍🏫 Dosen Lab WICIDA
        </h2>
        <p class="text-center text-gray-600 mb-12">
            Pilih dosen untuk melihat jadwal lengkap dan melakukan booking konsultasi
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 animate-fade-in">
            @forelse($dosens as $dosen)
                <div class="card-modern group cursor-pointer hover-lift overflow-hidden">
                    <!-- Status Header -->
                    <div class="relative h-32 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl mb-6 flex items-center justify-center overflow-hidden group-hover:scale-110 transition-transform duration-300">
                        <div class="relative text-center">
                            @php
                                $status = $dosen->status?->status ?? 'Tidak Diketahui';
                                $statusIcon = match($status) {
                                    'Ada' => '🟢',
                                    'Mengajar' => '🔴',
                                    'Konsultasi' => '🟡',
                                    default => '⚪'
                                };
                            @endphp
                            <span class="text-5xl mb-2 inline-block">{{ $statusIcon }}</span>
                            <div class="text-white font-bold text-sm">{{ $status }}</div>
                        </div>
                    </div>

                    <!-- Profile Info -->
                    <h3 class="text-2xl font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors">
                        {{ $dosen->name }}
                    </h3>

                    @if($dosen->nip)
                        <p class="text-sm text-gray-500 mb-4">NIP: {{ $dosen->nip }}</p>
                    @endif

                    <!-- Role Badge -->
                    <span class="badge-purple mb-6">
                        {{ $dosen->role === 'kepala_lab' ? '👑 Kepala Lab' : '👤 Staf' }}
                    </span>

                    <!-- Action Buttons -->
                    <div class="space-y-3 pt-4 border-t border-purple-100">
                        <a href="/dosen/{{ $dosen->id }}" 
                           class="block w-full text-center py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-bold rounded-lg hover:shadow-lg transition-all duration-300 active:scale-95">
                            📅 Lihat Jadwal
                        </a>
                        <a href="/dosen/{{ $dosen->id }}#booking" 
                           class="block w-full text-center py-3 bg-purple-100 text-purple-700 font-bold rounded-lg hover:bg-purple-200 transition-all duration-300">
                            💬 Booking Konsultasi
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16">
                    <p class="text-xl text-gray-600">Belum ada data dosen tersedia</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
