<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Dosen
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Jadwal Mengajar Anda</h3>
                <a href="{{ route('jadwal.create') }}" 
                   class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
                   + Tambah Jadwal
                </a>
                <table class="table-auto w-full border">
                    <thead>
                        <tr class="bg-gray-200">
                            <th>Hari</th><th>Jam Mulai</th><th>Jam Selesai</th><th>Keterangan</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwals as $jadwal)
                            <tr>
                                <td>{{ $jadwal->hari }}</td>
                                <td>{{ $jadwal->jam_mulai }}</td>
                                <td>{{ $jadwal->jam_selesai }}</td>
                                <td>{{ $jadwal->keterangan }}</td>
                                <td>
                                    <a href="{{ route('jadwal.edit',$jadwal->id) }}" class="text-blue-600">Edit</a> |
                                                                   <form action="{{ route('jadwal.destroy',$jadwal->id) }}" 
                                      method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600"
                                            onclick="return confirm('Hapus jadwal ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">Belum ada jadwal</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>