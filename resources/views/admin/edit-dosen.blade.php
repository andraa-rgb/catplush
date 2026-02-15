<x-app-layout>
    @section('title', 'Edit Dosen')

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.dashboard') }}" class="text-purple-600 hover:text-purple-700 font-semibold mb-4 inline-block">
                ← Kembali ke Dashboard
            </a>
            <h1 class="text-4xl font-black text-gray-900">✏️ Edit Dosen</h1>
            <p class="text-gray-600 mt-1">Ubah informasi akun dosen</p>
        </div>

        <!-- Form Card -->
        <div class="card-modern">
            <form method="POST" action="{{ route('admin.dosen.update', $dosen->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $dosen->name) }}"
                        placeholder="Masukkan nama dosen"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 transition"
                        required
                    />
                    @error('name')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $dosen->email) }}"
                        placeholder="nama@lab-wicida.ac.id"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 transition"
                        required
                    />
                    @error('email')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIP Field -->
                <div>
                    <label for="nip" class="block text-sm font-bold text-gray-700 mb-2">NIP</label>
                    <input
                        type="text"
                        id="nip"
                        name="nip"
                        value="{{ old('nip', $dosen->nip) }}"
                        placeholder="Nomor Induk Pegawai"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 transition"
                    />
                    @error('nip')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role Field -->
                <div>
                    <label for="role" class="block text-sm font-bold text-gray-700 mb-2">Peran</label>
                    <select
                        id="role"
                        name="role"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 transition"
                        required
                    >
                        <option value="staf" {{ old('role', $dosen->role) === 'staf' ? 'selected' : '' }}>Staf</option>
                        <option value="kepala_lab" {{ old('role', $dosen->role) === 'kepala_lab' ? 'selected' : '' }}>Kepala Lab</option>
                    </select>
                    @error('role')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field (Optional) -->
                <div class="border-t pt-6">
                    <p class="text-sm text-gray-600 mb-4">Biarkan kosong jika tidak ingin mengubah password</p>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Minimal 8 karakter (kosongkan jika tidak berubah)"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 transition"
                        />
                        @error('password')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password</label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 transition"
                        />
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 justify-between pt-4 border-t border-gray-200">
                    <button type="button" onclick="deleteDosen()" class="px-6 py-3 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition font-bold">
                        🗑️ Hapus Dosen
                    </button>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-bold">
                            Batal
                        </a>
                        <button type="submit" class="btn-primary">
                            ✅ Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="card-modern max-w-md mx-4">
            <h3 class="text-xl font-bold text-gray-900 mb-4">⚠️ Konfirmasi Hapus</h3>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus dosen <strong>{{ $dosen->name }}</strong>? Semua jadwal dan booking akan dihapus juga.</p>
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
    function deleteDosen() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    function confirmDelete() {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('admin.dosen.delete', $dosen->id) }}`;
        form.innerHTML = `@csrf @method('DELETE')`;
        document.body.appendChild(form);
        form.submit();
    }
    </script>
</x-app-layout>
