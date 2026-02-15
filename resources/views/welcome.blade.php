<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Penjelasan tentang web -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h1 class="text-3xl font-bold mb-4 text-center">Profil Sekolah & Sistem Jadwal Dosen</h1>
                <p class="text-lg leading-relaxed text-gray-700">
                    Website ini adalah sistem informasi jadwal dosen yang dapat diakses oleh seluruh civitas akademik.
                    Mahasiswa dan publik dapat langsung melihat status dosen tanpa perlu login. 
                    Dosen memiliki akun login khusus untuk mengisi, mengedit, dan menghapus jadwal mengajar mereka.
                    Dengan sistem ini, transparansi jadwal perkuliahan meningkat dan komunikasi antara dosen dan mahasiswa menjadi lebih efisien.
                </p>
            </div>

            <!-- Tabel status semua dosen -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4">Status Semua Dosen Hari Ini</h2>
                <table class="table-auto w-full border">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2">Nama Dosen</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statuses as $s)
                            <tr>
                                <td class="border px-4 py-2">{{ $s['nama_dosen'] }}</td>
                                <td class="border px-4 py-2">
                                    <span class="font-semibold text-blue-600">{{ $s['status'] }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>