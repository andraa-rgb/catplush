<section>
    <header class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">
            🔐 Ubah Password
        </h2>
        <p class="mt-1 text-slate-600">
            Gunakan password yang kuat dan unik untuk keamanan akun Anda.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-semibold text-slate-900 mb-2">
                🔑 Password Saat Ini
            </label>
            <input id="update_password_current_password" name="current_password" type="password" 
                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                autocomplete="current-password" />
            @if ($errors->updatePassword->has('current_password'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-semibold text-slate-900 mb-2">
                🆕 Password Baru
            </label>
            <input id="update_password_password" name="password" type="password" 
                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                autocomplete="new-password" />
            @if ($errors->updatePassword->has('password'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-slate-900 mb-2">
                ✓ Konfirmasi Password
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                autocomplete="new-password" />
            @if ($errors->updatePassword->has('password_confirmation'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                💾 Simpan Password Baru
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" 
                    class="text-sm text-green-700 font-semibold">
                    ✓ Password berhasil diperbarui
                </p>
            @endif
        </div>
    </form>
</section>
