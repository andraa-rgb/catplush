<x-app-layout>
    <div class="py-8">
        <h1 class="text-3xl font-bold text-slate-900 mb-8">👤 Edit Profil Dosen</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Main Forms -->
            <div class="md:col-span-2 space-y-6">
                <!-- Update Profile Information -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- Update Password -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="md:col-span-1">
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-blue-900 mb-3">ℹ️ Informasi</h3>
                    <div class="text-sm text-blue-800 space-y-2">
                        <p><strong>Role:</strong> {{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</p>
                        <p><strong>NIP:</strong> {{ Auth::user()->nip ?? 'Belum diisi' }}</p>
                        <p><strong>Terdaftar:</strong> {{ Auth::user()->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="bg-red-50 border border-red-200 rounded-xl p-6 mt-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
