@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Riwayat Ujian Saya</h1>
            <p class="text-gray-500 text-sm">Daftar ujian yang telah Anda selesaikan beserta skor akhirnya.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="text-purple-600 hover:text-purple-800 font-medium text-sm">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Ujian
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Pengerjaan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Skor Akhir
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($histories as $history)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-file-signature"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $history->exam->title }}</div>
                                    <div class="text-xs text-gray-500">{{ $history->exam->questions->count() ?? '-' }} Soal</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $history->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $history->created_at->format('H:i') }} WITA</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-lg leading-5 font-bold rounded-full bg-blue-50 text-blue-700">
                                {{ $history->total_score }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Selesai
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            {{-- Link ke halaman Result Detail yang sudah kita buat sebelumnya --}}
                            <a href="{{ route('exams.result', $history->id) }}" class="text-purple-600 hover:text-purple-900 border border-purple-200 hover:bg-purple-50 px-3 py-1.5 rounded-md transition">
                                Lihat Detail <i class="fa-solid fa-arrow-right ml-1"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fa-regular fa-folder-open text-4xl mb-3 text-gray-300"></i>
                                <p>Anda belum memiliki riwayat ujian.</p>
                                <a href="{{ route('dashboard') }}" class="mt-2 text-purple-600 hover:underline">Mulai ujian sekarang</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $histories->links() }}
        </div>
    </div>
</div>
@endsection
