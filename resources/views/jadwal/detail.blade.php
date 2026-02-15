<x-app-layout>
    @section('title', 'Detail Jadwal - ' . $dosen->name)

    <div class="max-w-5xl mx-auto px-4 py-8">
        <!-- Hero Header with Status -->
        <div class="card-gradient mb-8 hover-lift">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6 md:gap-8">
                <!-- Avatar -->
                <div class="relative">
                    <div class="w-24 h-24 md:w-32 md:h-32 rounded-full bg-gradient-primary flex items-center justify-center shadow-lg">
                        <span class="text-6xl md:text-8xl">👨‍🏫</span>
                    </div>
                    <!-- Status Indicator -->
                    <div class="absolute bottom-0 right-0 w-8 h-8 rounded-full border-4 border-white {{ $dosen->status?->status === 'Ada' ? 'bg-green-500' : ($dosen->status?->status === 'Mengajar' ? 'bg-red-500' : ($dosen->status?->status === 'Konsultasi' ? 'bg-yellow-500' : 'bg-gray-500')) }} shadow-lg"></div>
                </div>

                <!-- Info -->
                <div class="flex-1">
                    <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-2">{{ $dosen->name }}</h1>
                    
                    @if($dosen->nip)
                        <p class="text-lg text-gray-600 mb-4">NIP: <span class="font-semibold text-primary-700">{{ $dosen->nip }}</span></p>
                    @endif

                    <!-- Current Status with Large Badge -->
                    <div class="mt-6">
                        @php
                            $status = $dosen->status?->status ?? 'Tidak Diketahui';
                            $statusIcon = match($status) {
                                'Ada' => '🟢',
                                'Mengajar' => '🔴',
                                'Konsultasi' => '🟡',
                                default => '⚪'
                            };
                            $statusClass = match($status) {
                                'Ada' => 'status-ada',
                                'Mengajar' => 'status-mengajar',
                                'Konsultasi' => 'status-konsultasi',
                                default => 'status-tidak-ada'
                            };
                            $statusColor = match($status) {
                                'Ada' => 'text-green-700',
                                'Mengajar' => 'text-red-700',
                                'Konsultasi' => 'text-yellow-700',
                                default => 'text-gray-700'
                            };
                        @endphp
                        
                        <div class="inline-flex items-center gap-3">
                            <span class="text-4xl">{{ $statusIcon }}</span>
                            <div>
                                <p class="text-sm text-gray-600">Status Saat Ini</p>
                                <p class="text-2xl font-bold {{ $statusColor }}">{{ $status }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('dosen.show', $dosen->id) }}#booking" class="btn-primary text-sm">
                            💬 Booking Konsultasi
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jadwal Mingguan Section -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-6">
                <h2 class="text-3xl font-bold text-gray-900">📅 Jadwal Mingguan</h2>
                @php
                    $totalJadwal = 0;
                    foreach($jadwalByHari as $jadwals) {
                        $totalJadwal += count($jadwals);
                    }
                @endphp
                <span class="badge-purple">{{ $totalJadwal }} Aktivitas</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                <!-- Days Overview -->
                @php
                    $hariColors = [
                        'Senin' => 'from-blue-400 to-blue-600',
                        'Selasa' => 'from-purple-400 to-purple-600',
                        'Rabu' => 'from-pink-400 to-pink-600',
                        'Kamis' => 'from-green-400 to-green-600',
                        'Jumat' => 'from-yellow-400 to-yellow-600',
                        'Sabtu' => 'from-indigo-400 to-indigo-600',
                    ];
                @endphp

                @foreach($hari as $h)
                    <div class="card-modern hover-lift">
                        <div class="bg-gradient-to-br {{ $hariColors[$h] ?? 'from-gray-400 to-gray-600' }} text-white rounded-lg p-4 mb-4">
                            <h3 class="text-lg font-bold">{{ $h }}</h3>
                            <p class="text-sm opacity-90">{{ $jadwalByHari[$h]->count() }} Aktivitas</p>
                        </div>

                        @if($jadwalByHari[$h]->count() > 0)
                            <div class="space-y-3">
                                @foreach($jadwalByHari[$h] as $jadwal)
                                    <div class="border-l-4 border-primary-500 pl-4 py-2">
                                        <div class="font-semibold text-gray-900">
                                            {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                        </div>
                                        <div class="text-sm text-gray-600 mt-1">
                                            @if($jadwal->kegiatan === 'Mengajar')
                                                📝 Mengajar
                                            @elseif($jadwal->kegiatan === 'Konsultasi')
                                                💬 Konsultasi
                                            @elseif($jadwal->kegiatan === 'Rapat')
                                                👥 Rapat
                                            @else
                                                📌 Lainnya
                                            @endif
                                        </div>
                                        @if($jadwal->ruangan)
                                            <div class="text-xs text-primary-600 font-semibold mt-2">
                                                🏫 Ruang: {{ $jadwal->ruangan }}
                                            </div>
                                        @endif
                                        @if($jadwal->keterangan)
                                            <div class="text-xs text-gray-500 mt-1 italic">
                                                {{ $jadwal->keterangan }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-8 text-center">
                                <p class="text-gray-500 text-sm">📭 Tidak ada jadwal</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Timeline View (Alternative) -->
            <div class="card-modern">
                <h3 class="text-xl font-bold text-gray-900 mb-6">⏱️ Timeline Lengkap</h3>
                <div class="space-y-4">
                    @foreach($hari as $h)
                        @if($jadwalByHari[$h]->count() > 0)
                            <div>
                                <h4 class="font-bold text-primary-700 text-sm uppercase tracking-wider mb-3">{{ $h }}</h4>
                                <div class="space-y-2 ml-4 border-l-2 border-purple-200 pl-4">
                                    @foreach($jadwalByHari[$h] as $jadwal)
                                        <div class="relative py-3 hover:bg-purple-50 px-3 rounded transition-colors -ml-4 pl-7">
                                            <div class="absolute left-0 top-4 w-3 h-3 rounded-full bg-primary-600"></div>
                                            <div class="font-semibold text-gray-900">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</div>
                                            <div class="text-sm text-gray-600">{{ $jadwal->kegiatan }}</div>
                                            @if($jadwal->ruangan)
                                                <div class="text-xs text-gray-500">{{ $jadwal->ruangan }}</div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Booking Konsultasi Section -->
        <div id="booking" class="card-gradient">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">💬 Booking Konsultasi</h2>
                    <p class="text-gray-600">Isi form di bawah untuk membuat jadwal konsultasi dengan {{ $dosen->name }}</p>
                </div>
                @if($dosen->email)
                    <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-xs text-blue-600 font-semibold mb-1">📧 EMAIL DOSEN:</p>
                        <p class="text-sm font-bold text-blue-800">{{ $dosen->email }}</p>
                    </div>
                @endif
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg animate-shake">
                    <p class="font-bold text-red-800 mb-2">❌ Validasi Error:</p>
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

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                    <p class="font-bold text-green-800">✓ {{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('booking.store', $dosen->id) }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Lengkap -->
                    <div class="form-group">
                        <label class="form-label">👤 Nama Lengkap</label>
                        <input type="text" 
                            name="nama_mahasiswa" 
                            required 
                            value="{{ old('nama_mahasiswa') }}"
                            class="input-modern"
                            placeholder="Contoh: Budi Santoso">
                        @error('nama_mahasiswa')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label">📧 Email</label>
                        <input type="email" 
                            name="email_mahasiswa" 
                            required 
                            value="{{ old('email_mahasiswa') }}"
                            class="input-modern"
                            placeholder="contoh@email.com">
                        @error('email_mahasiswa')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NIM -->
                    <div class="form-group">
                        <label class="form-label">🆔 NIM (Opsional)</label>
                        <input type="text" 
                            name="nim_mahasiswa" 
                            value="{{ old('nim_mahasiswa') }}"
                            class="input-modern"
                            placeholder="Contoh: 21234567">
                        @error('nim_mahasiswa')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Booking -->
                    <div class="form-group">
                        <label class="form-label">📅 Tanggal Konsultasi</label>
                        <input type="date" 
                            name="tanggal_booking" 
                            required 
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                            value="{{ old('tanggal_booking') }}"
                            class="input-modern">
                        @error('tanggal_booking')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Jam Mulai -->
                    <div class="form-group">
                        <label class="form-label">⏰ Jam Mulai</label>
                        <input type="time" 
                            name="jam_mulai" 
                            required 
                            value="{{ old('jam_mulai') }}"
                            class="input-modern">
                        @error('jam_mulai')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jam Selesai -->
                    <div class="form-group">
                        <label class="form-label">⏰ Jam Selesai</label>
                        <input type="time" 
                            name="jam_selesai" 
                            required 
                            value="{{ old('jam_selesai') }}"
                            class="input-modern">
                        @error('jam_selesai')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Keperluan -->
                <div class="form-group">
                    <label class="form-label">📝 Keperluan / Topik Konsultasi</label>
                    <textarea 
                        name="keperluan" 
                        required 
                        rows="4"
                        class="input-modern resize-none"
                        placeholder="Jelaskan secara singkat topik yang ingin Anda konsultasikan...">{{ old('keperluan') }}</textarea>
                    @error('keperluan')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="btn-primary w-full py-4 text-lg font-bold group">
                        <span class="inline-flex items-center gap-2">
                            ✓ Kirim Booking Konsultasi
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </span>
                    </button>
                </div>

                <!-- Info Box -->
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-800 mb-2">
                        <strong>ℹ️ Catatan Penting:</strong>
                    </p>
                    <ul class="text-sm text-blue-700 space-y-1 ml-4">
                        <li>✓ Booking Anda akan diajukan kepada dosen untuk dikonfirmasi</li>
                        <li>✓ Email konfirmasi akan dikirim ke alamat email yang Anda daftarkan</li>
                        <li>✓ Dosen akan merespons dalam waktu 1x24 jam</li>
                        <li>✓ Catatan khusus dari dosen akan dikirim melalui email persetujuan</li>
                    </ul>
                </div>
            </form>
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="btn-outline">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
</x-app-layout>
