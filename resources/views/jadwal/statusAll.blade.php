<x-app-layout>
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4">Status Semua Dosen</h2>
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