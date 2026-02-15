<x-app-layout>
    @section('title', 'Dashboard Dosen')

    <!-- Welcome Section -->
    <div class="mb-12">
        <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-2">
            👋 Selamat Datang, {{ Auth::user()->name }}!
        </h1>
        <p class="text-lg text-gray-600">
            Kelola jadwal, booking, dan status real-time Anda dari sini
        </p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <!-- Jadwal Card -->
        <a href="{{ route('dosen.jadwal.index') }}" class="card-gradient hover-lift group">
            <div class="flex items-start justify-between mb-4">
                <div class="text-5xl">📅</div>
                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                    Minggu Ini
                </span>
            </div>
            <h3 class="text-lg font-semibold text-gray-600 mb-1">Total Jadwal</h3>
            <p class="text-4xl font-black text-primary-700 mb-3">{{ Auth::user()->jadwals()->count() }}</p>
            <p class="text-sm text-gray-600">Kelola jadwal mengajar Anda</p>
            <div class="mt-4 flex items-center gap-2 text-primary-600 font-semibold group-hover:gap-3 transition-all">
                Lihat Jadwal
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>

        <!-- Booking Card -->
        <a href="{{ route('dosen.booking.index') }}" class="card-gradient hover-lift group">
            <div class="flex items-start justify-between mb-4">
                <div class="text-5xl">💬</div>
                @php
                    $pendingCount = Auth::user()->bookings()->where('status', 'pending')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold animate-pulse">
                        {{ $pendingCount }} Baru
                    </span>
                @else
                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                        Selesai
                    </span>
                @endif
            </div>
            <h3 class="text-lg font-semibold text-gray-600 mb-1">Booking Konsultasi</h3>
            <p class="text-4xl font-black text-primary-700 mb-3">{{ $pendingCount }}</p>
            <p class="text-sm text-gray-600">Booking yang menunggu konfirmasi</p>
            <div class="mt-4 flex items-center gap-2 text-primary-600 font-semibold group-hover:gap-3 transition-all">
                Lihat Booking
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>

        <!-- Status Card -->
        <div class="card-gradient hover-lift">
            <div class="flex items-start justify-between mb-4">
                <div class="text-5xl">
                    @php
                        $status = Auth::user()->status?->status ?? 'Tidak Ada';
                        $statusIcon = match($status) {
                            'Ada' => '🟢',
                            'Mengajar' => '🔴',
                            'Konsultasi' => '🟡',
                            default => '⚪'
                        };
                    @endphp
                    {{ $statusIcon }}
                </div>
                <a href="{{ route('status.update') }}" class="text-primary-600 hover:text-primary-700">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                    </svg>
                </a>
            </div>
            <h3 class="text-lg font-semibold text-gray-600 mb-1">Status Saat Ini</h3>
            <p class="text-4xl font-black text-primary-700 mb-3">{{ $status }}</p>
            <p class="text-sm text-gray-600">Ubah status ketersediaan Anda</p>
            @if(Auth::user()->status && Auth::user()->status->updated_at_iot)
                <div class="mt-4 text-xs text-gray-500">
                    Terakhir diperbarui: {{ Auth::user()->status->updated_at_iot->diffForHumans() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Status Real-Time Update Section -->
    <div class="card-modern mb-12">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-1">🎯 Ubah Status Real-Time</h2>
                <p class="text-gray-600">Beri tahu mahasiswa ketersediaan Anda saat ini</p>
            </div>
        </div>
        
        <form id="statusForm" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-900 mb-4">Pilih Status Anda:</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @php
                        $statusOptions = [
                            ['name' => 'Ada', 'icon' => '🟢', 'desc' => 'Di Ruangan'],
                            ['name' => 'Mengajar', 'icon' => '🔴', 'desc' => 'Sedang Mengajar'],
                            ['name' => 'Konsultasi', 'icon' => '🟡', 'desc' => 'Konsultasi'],
                            ['name' => 'Tidak Ada', 'icon' => '⚪', 'desc' => 'Tidak Ada']
                        ];
                    @endphp
                    
                    @foreach($statusOptions as $opt)
                        <label class="relative cursor-pointer group">
                            <input type="radio" 
                                name="status" 
                                value="{{ $opt['name'] }}" 
                                class="sr-only peer"
                                onchange="updateStatus()"
                                @if(Auth::user()->status?->status === $opt['name']) checked @endif>
                            
                            <div class="p-4 rounded-xl border-2 transition-all duration-300
                                @if(Auth::user()->status?->status === $opt['name'])
                                    border-primary-600 bg-primary-50 shadow-lg
                                @else
                                    border-purple-200 bg-white group-hover:border-primary-300
                                @endif
                                peer-checked:border-primary-600 peer-checked:bg-primary-50 peer-checked:shadow-lg">
                                
                                <div class="text-3xl mb-2 text-center">{{ $opt['icon'] }}</div>
                                <div class="text-sm font-bold text-center text-gray-900">{{ $opt['name'] }}</div>
                                <div class="text-xs text-center text-gray-500 mt-1">{{ $opt['desc'] }}</div>
                                
                                @if(Auth::user()->status?->status === $opt['name'])
                                    <div class="mt-2 flex justify-center">
                                        <span class="text-xs bg-primary-600 text-white px-2 py-1 rounded-full font-bold">
                                            Aktif ✓
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            @if(Auth::user()->status && Auth::user()->status->updated_at_iot)
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <strong>ℹ️ Info:</strong> Status terakhir diperbarui 
                        <strong>{{ Auth::user()->status->updated_at_iot->diffForHumans() }}</strong>
                    </p>
                </div>
            @endif
        </form>
    </div>

    <!-- Jadwal Minggu Ini -->
    <div class="card-modern">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">📅 Jadwal Minggu Ini</h2>
                <p class="text-gray-600">Kelola jadwal mengajar dan kegiatan Anda</p>
            </div>
            <a href="{{ route('dosen.jadwal.create') }}" class="btn-primary">
                + Tambah Jadwal
            </a>
        </div>

        <div class="space-y-6">
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
                <div class="border-l-4 border-primary-400 pl-6 py-4 hover:bg-gray-50 transition-colors rounded">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br {{ $hariColors[$h] }} flex items-center justify-center text-white font-bold">
                            <span>{{ substr($h, 0, 1) }}</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">{{ $h }}</h3>
                            <p class="text-sm text-gray-600">{{ $jadwalByHari[$h]->count() }} Aktivitas</p>
                        </div>
                    </div>
                    
                    @if($jadwalByHari[$h]->count() > 0)
                        <div class="space-y-3 ml-15">
                            @foreach($jadwalByHari[$h] as $jadwal)
                                <div class="bg-white border border-purple-200 rounded-lg p-4 hover:shadow-md transition-shadow group">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <span class="text-2xl">
                                                    @if($jadwal->kegiatan === 'Mengajar')
                                                        📝
                                                    @elseif($jadwal->kegiatan === 'Konsultasi')
                                                        💬
                                                    @elseif($jadwal->kegiatan === 'Rapat')
                                                        👥
                                                    @else
                                                        📌
                                                    @endif
                                                </span>
                                                <div>
                                                    <div class="font-bold text-gray-900">
                                                        {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                                    </div>
                                                    <div class="text-sm text-gray-600">
                                                        {{ $jadwal->kegiatan }}
                                                    </div>
                                                </div>
                                            </div>
                                            @if($jadwal->ruangan)
                                                <p class="text-xs text-gray-500 ml-11">🏫 {{ $jadwal->ruangan }}</p>
                                            @endif
                                            @if($jadwal->keterangan)
                                                <p class="text-xs text-gray-500 ml-11 italic">{{ $jadwal->keterangan }}</p>
                                            @endif
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('dosen.jadwal.edit', $jadwal->id) }}" 
                                                class="px-3 py-1 text-xs bg-blue-100 text-blue-700 font-bold rounded hover:bg-blue-200 transition">
                                                ✏️
                                            </a>
                                            <form action="{{ route('dosen.jadwal.destroy', $jadwal->id) }}" 
                                                method="POST" 
                                                class="inline" 
                                                onsubmit="return confirm('Hapus jadwal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="px-3 py-1 text-xs bg-red-100 text-red-700 font-bold rounded hover:bg-red-200 transition">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">📭 Tidak ada jadwal</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

<script>
function updateStatus() {
    const form = document.getElementById('statusForm');
    const status = form.querySelector('input[name="status"]:checked').value;
    
    fetch('{{ route("status.update") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status })
    })
    .then(res => res.json())
    .then(data => {
        console.log('Status updated:', data);
        location.reload();
    })
    .catch(err => {
        console.error('Error updating status:', err);
        alert('Gagal mengubah status');
    });
}
</script>
