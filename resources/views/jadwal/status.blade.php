<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
                <h2 class="text-xl font-bold mb-4">Status Dosen</h2>
                <p class="text-lg">
                    Dosen <strong>{{ $nama_dosen }}</strong> saat ini:
                    <span class="text-blue-600 font-semibold">{{ $status }}</span>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>