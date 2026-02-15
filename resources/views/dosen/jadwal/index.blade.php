<x-app-layout>
    @section('title', 'Kelola Jadwal')

    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-2">
                    📅 Kelola Jadwal
                </h1>
                <p class="text-lg text-gray-600">
                    Atur jadwal mengajar, konsultasi, dan kegiatan Anda
                </p>
            </div>
            <a href="{{ route('dosen.jadwal.create') }}" class="btn-primary">
                + Tambah Jadwal Baru
            </a>
        </div>

        @if($jadwals->count() > 0)
            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="card-modern">
                    <div class="text-3xl mb-2">📋</div>
                    <p class="text-sm text-gray-600">Total Jadwal</p>
                    <p class="text-2xl font-black text-primary-700">{{ $jadwals->count() }}</p>
                </div>
                <div class="card-modern">
                    <div class="text-3xl mb-2">📝</div>
                    <p class="text-sm text-gray-600">Mengajar</p>
                    <p class="text-2xl font-black text-blue-600">{{ $jadwals->where('kegiatan', 'Mengajar')->count() }}</p>
                </div>
                <div class="card-modern">
                    <div class="text-3xl mb-2">💬</div>
                    <p class="text-sm text-gray-600">Konsultasi</p>
                    <p class="text-2xl font-black text-yellow-600">{{ $jadwals->where('kegiatan', 'Konsultasi')->count() }}</p>
                </div>
                <div class="card-modern">
                    <div class="text-3xl mb-2">👥</div>
                    <p class="text-sm text-gray-600">Rapat</p>
                    <p class="text-2xl font-black text-purple-600">{{ $jadwals->where('kegiatan', 'Rapat')->count() }}</p>
                </div>
            </div>

            <!-- Jadwal List -->
            <div class="space-y-4">
                @php
                    $hariOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $jadwalsGrouped = $jadwals->groupBy('hari');
                @endphp

                @foreach($hariOrder as $hari)
                    @if(isset($jadwalsGrouped[$hari]))
                        <div class="card-modern">
                            <div class="flex items-center gap-3 mb-4 pb-4 border-b border-purple-200">
                                <div class="w-12 h-12 rounded-lg bg-gradient-primary flex items-center justify-center text-white font-bold text-lg">
                                    {{ substr($hari, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-xl text-gray-900">{{ $hari }}</h3>
                                    <p class="text-sm text-gray-600">{{ $jadwalsGrouped[$hari]->count() }} Aktivitas</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                @foreach($jadwalsGrouped[$hari] as $jadwal)
                                    <div class="flex items-start justify-between p-4 bg-gradient-light rounded-lg border border-purple-200 hover:shadow-md transition-shadow group">
                                        <!-- Info -->
                                        <div class="flex-1 flex gap-4">
                                            <div class="flex-shrink-0">
                                                <span class="text-3xl">
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
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <h4 class="font-bold text-gray-900 text-lg">
                                                        {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                                    </h4>
                                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                                        {{ $jadwal->kegiatan }}
                                                    </span>
                                                </div>
                                                @if($jadwal->ruangan)
                                                    <p class="text-sm text-gray-600">🏫 Ruang: <span class="font-semibold">{{ $jadwal->ruangan }}</span></p>
                                                @endif
                                                @if($jadwal->keterangan)
                                                    <p class="text-sm text-gray-600 italic mt-1">{{ $jadwal->keterangan }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity ml-4">
                                            <a href="{{ route('dosen.jadwal.edit', $jadwal->id) }}" 
                                                class="px-3 py-2 text-xs bg-blue-100 text-blue-700 font-bold rounded hover:bg-blue-200 transition">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('dosen.jadwal.destroy', $jadwal->id) }}" 
                                                method="POST" 
                                                class="inline" 
                                                onsubmit="return confirm('Hapus jadwal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="px-3 py-2 text-xs bg-red-100 text-red-700 font-bold rounded hover:bg-red-200 transition">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="text-center py-16 card-modern">
                <div class="text-6xl mb-4">📭</div>
                <p class="text-xl text-gray-900 font-bold mb-2">Belum Ada Jadwal</p>
                <p class="text-gray-600 mb-6">Mulai buat jadwal pertama Anda untuk transparansi dengan mahasiswa</p>
                <a href="{{ route('dosen.jadwal.create') }}" class="btn-primary inline-block">
                    + Buat Jadwal Pertama
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
