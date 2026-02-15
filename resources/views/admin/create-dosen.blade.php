<x-app-layout>
    @section('title', 'Tambah Dosen')

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.dashboard') }}" class="text-purple-600 hover:text-purple-700 font-semibold mb-4 inline-block">
                ← Kembali ke Dashboard
            </a>
            <h1 class="text-4xl font-black text-gray-900">➕ Tambah Dosen</h1>
            <p class="text-gray-600 mt-1">Buat akun dosen baru di sistem</p>
        </div>

        <!-- Form Card -->
        <div class="card-modern">
            <form method="POST" action="{{ route('admin.dosen.store') }}" class="space-y-6">
                @csrf

                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
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
                        value="{{ old('email') }}"
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
                        value="{{ old('nip') }}"
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
                        <option value="">Pilih Peran</option>
                        <option value="staf" {{ old('role') === 'staf' ? 'selected' : '' }}>Staf</option>
                        <option value="kepala_lab" {{ old('role') === 'kepala_lab' ? 'selected' : '' }}>Kepala Lab</option>
                    </select>
                    @error('role')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 transition"
                        required
                    />
                    @error('password')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Ulangi password"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 transition"
                        required
                    />
                    @error('password_confirmation')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 justify-end pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-bold">
                        Batal
                    </a>
                    <button type="submit" class="btn-primary">
                        ✅ Tambah Dosen
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
