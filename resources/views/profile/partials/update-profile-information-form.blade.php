<section>
    <header class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">
            📝 Informasi Pribadi
        </h2>
        <p class="mt-1 text-slate-600">
            Perbarui nama, email, dan data diri Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-semibold text-slate-900 mb-2">
                👤 Nama Lengkap
            </label>
            <input id="name" name="name" type="text" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                value="{{ old('name', $user->name) }}" required autofocus />
            @if ($errors->has('name'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('name') }}</p>
            @endif
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-slate-900 mb-2">
                📧 Email
            </label>
            <input id="email" name="email" type="email" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                value="{{ old('email', $user->email) }}" required />
            @if ($errors->has('email'))
                <p class="mt-2 text-sm text-red-600">{{ $errors->first('email') }}</p>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        ⚠️ Email Anda belum diverifikasi.
                        <button form="send-verification" class="font-semibold text-yellow-900 hover:underline">
                            Kirim ulang email verifikasi
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-green-700">
                            ✓ Email verifikasi telah dikirim
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                💾 Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" 
                    class="text-sm text-green-700 font-semibold">
                    ✓ Profil berhasil diperbarui
                </p>
            @endif
        </div>
    </form>
</section>
