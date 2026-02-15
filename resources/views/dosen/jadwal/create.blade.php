<x-app-layout>
    @section('title', 'Buat Jadwal Baru')

    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-slate-900 mb-6">Buat Jadwal Baru</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dosen.jadwal.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Hari</label>
                <select name="hari" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Hari</option>
                    @foreach($hari as $h)
                        <option value="{{ $h }}" @if(old('hari') === $h) selected @endif>{{ $h }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-2">Jam Mulai</label>
                    <input type="time" name="jam_mulai" required value="{{ old('jam_mulai') }}"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-2">Jam Selesai</label>
                    <input type="time" name="jam_selesai" required value="{{ old('jam_selesai') }}"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Kegiatan</label>
                <select name="kegiatan" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Kegiatan</option>
                    @foreach($kegiatan as $k)
                        <option value="{{ $k }}" @if(old('kegiatan') === $k) selected @endif>{{ $k }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Ruangan (opsional)</label>
                <input type="text" name="ruangan" placeholder="Contoh: Lab WICIDA, Ruang A.1" value="{{ old('ruangan') }}"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Keterangan (opsional)</label>
                <textarea name="keterangan" rows="3" placeholder="Tambahkan catatan atau keterangan tambahan..."
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                    ✓ Simpan Jadwal
                </button>
                <a href="{{ route('dosen.jadwal.index') }}" class="flex-1 text-center py-2 bg-slate-200 hover:bg-slate-300 text-slate-900 font-semibold rounded-lg transition">
                    ← Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
