<x-app-layout>
    @section('title', 'Admin Dashboard')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-black text-gray-900">👥 Kelola Dosen</h1>
                    <p class="text-gray-600 mt-1">Kelola akun dosen dan jadwal mengajar</p>
                </div>
                <a href="{{ route('admin.dosen.create') }}" class="btn-primary">
                    ➕ Tambah Dosen
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="card-modern">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Total Dosen</p>
                        <p class="text-3xl font-black text-purple-700">{{ $stats['total_dosens'] }}</p>
                    </div>
                    <div class="text-4xl">👥</div>
                </div>
            </div>

            <div class="card-modern">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Total Jadwal</p>
                        <p class="text-3xl font-black text-purple-700">{{ $stats['total_jadwals'] }}</p>
                    </div>
                    <div class="text-4xl">📅</div>
                </div>
            </div>

            <div class="card-modern">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Booking Pending</p>
                        <p class="text-3xl font-black text-purple-700">{{ $stats['pending_bookings'] }}</p>
                    </div>
                    <div class="text-4xl">⏳</div>
                </div>
            </div>
        </div>

        <!-- Dosen List as Cards -->
        <div>
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">📋 Daftar Dosen Terdaftar</h2>
            </div>

            @if($dosens->isEmpty())
                <div class="card-modern text-center py-16">
                    <p class="text-gray-600 text-lg mb-4">Belum ada dosen terdaftar</p>
                    <a href="{{ route('admin.dosen.create') }}" class="btn-primary inline-block">
                        ➕ Tambah Dosen Pertama
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($dosens as $dosen)
                        <div class="card-modern hover:shadow-2xl transition-all duration-300">
                            <!-- Header -->
                            <div class="flex items-start justify-between mb-4 pb-4 border-b border-purple-200">
                                <div class="flex-1">
                                    <h3 class="text-2xl font-bold text-gray-900">{{ $dosen->name }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $dosen->role === 'staf' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                            {{ $dosen->role === 'kepala_lab' ? '👑 Kepala Lab' : '👤 Staf' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="text-3xl">👨‍🏫</div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <p class="text-xs text-gray-600 font-semibold uppercase tracking-wide">Email</p>
                                <p class="text-sm text-gray-900 font-medium break-all">{{ $dosen->email }}</p>
                            </div>

                            <!-- NIP -->
                            @if($dosen->nip)
                                <div class="mb-3">
                                    <p class="text-xs text-gray-600 font-semibold uppercase tracking-wide">NIP</p>
                                    <p class="text-sm text-gray-900 font-medium">{{ $dosen->nip }}</p>
                                </div>
                            @endif

                            <!-- Jadwal Count -->
                            <div class="mb-6 p-3 bg-purple-50 rounded-lg border border-purple-200">
                                <p class="text-xs text-gray-600 font-semibold uppercase tracking-wide">📅 Jadwal Terdaftar</p>
                                <p class="text-2xl font-black text-purple-700">{{ $dosen->jadwals_count ?? 0 }}</p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2 pt-4 border-t border-purple-200">
                                <a href="{{ route('admin.dosen.edit', $dosen->id) }}" class="flex-1 px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition font-semibold text-sm text-center">
                                    ✏️ Edit
                                </a>
                                <button onclick="deleteDosen({{ $dosen->id }})" class="flex-1 px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition font-semibold text-sm text-center">
                                    🗑️ Hapus
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="card-modern max-w-md mx-4">
        <h3 class="text-xl font-bold text-gray-900 mb-4">⚠️ Konfirmasi Hapus</h3>
        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus dosen ini? Semua jadwal dan booking akan dihapus juga.</p>
        <div class="flex gap-3 justify-end">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-semibold">
                Batal
            </button>
            <button onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
let dosenToDelete = null;

function deleteDosen(id) {
    dosenToDelete = id;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    dosenToDelete = null;
}

function confirmDelete() {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/dosen/${dosenToDelete}`;
    form.innerHTML = `@csrf @method('DELETE')`;
    document.body.appendChild(form);
    form.submit();
}
</script>
</x-app-layout>
