@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <a href="{{ route('admin.exams.index') }}" class="inline-flex items-center text-gray-500 hover:text-indigo-600 transition mb-2 text-sm font-medium">
                    <i class="fa-solid fa-arrow-left-long mr-2"></i> Kembali ke Daftar Ujian
                </a>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $exam->title }}</h1>
                <div class="flex flex-wrap items-center gap-3 mt-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-indigo-100 text-indigo-700 border border-indigo-200">
                        KODE: #{{ $exam->id }}
                    </span>
                    <span class="flex items-center text-sm text-gray-600 bg-white px-3 py-1 rounded-full border border-gray-200 shadow-sm">
                        <i class="fa-regular fa-clock mr-2 text-gray-400"></i> {{ $exam->duration_minutes }} Menit
                    </span>
                    <span class="flex items-center text-sm text-gray-600 bg-white px-3 py-1 rounded-full border border-gray-200 shadow-sm">
                        <i class="fa-solid fa-list-check mr-2 text-gray-400"></i> {{ $exam->questions->count() }} Soal
                    </span>
                </div>
            </div>

            <div class="flex gap-2">
                <!-- Tambahkan tombol aksi global jika perlu, misal: Preview Ujian -->
                <button onclick="window.location.reload()" class="bg-white text-gray-700 hover:bg-gray-50 border border-gray-300 px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition">
                    <i class="fa-solid fa-rotate mr-1"></i> Refresh
                </button>
            </div>
        </div>

        {{-- ALERTS --}}
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-start gap-3 shadow-sm animate-fade-in-down">
            <div class="bg-green-100 p-2 rounded-full text-green-600 shrink-0">
                <i class="fa-solid fa-check"></i>
            </div>
            <div>
                <h4 class="font-bold text-green-800 text-sm">Berhasil!</h4>
                <p class="text-green-700 text-sm">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start gap-3 shadow-sm animate-fade-in-down">
            <div class="bg-red-100 p-2 rounded-full text-red-600 shrink-0">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <h4 class="font-bold text-red-800 text-sm">Error!</h4>
                <p class="text-red-700 text-sm">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">

            <!-- KOLOM KIRI: INPUT SOAL -->
            <div class="xl:col-span-1 space-y-6">

                <!-- 1. AI GENERATOR CARD (Modern Gradient) -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Background Patterns -->
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-48 h-48 bg-white opacity-10 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-32 h-32 bg-[#562cbf opacity-20 rounded-full blur-2xl"></div>

                    <div class="relative p-6 z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-white/20 p-2.5 rounded-xl backdrop-blur-md shadow-inner border border-white/10">
                                <i class="fa-solid fa-wand-magic-sparkles text-[#562cbf] text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg leading-tight">AI Generator</h3>
                                <p class="text-[#737373] text-xs">Buat soal otomatis dalam hitungan detik</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.exams.generate', $exam->id) }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-[#1c1c1c] uppercase tracking-wider ml-1">Topik / Materi</label>
                                    <input type="text" name="topic"
                                        class="mt-1 w-full rounded-xl border-0 bg-gray-50 text-[#545353] placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:bg-gray-50 text-sm py-3 px-4 transition"
                                        placeholder="Misal: UUD 1945, Deret Angka..." required>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs font-bold text-[#6e6d6d] uppercase tracking-wider ml-1">Jumlah Soal</label>
                                        <input type="number" name="amount" min="1" max="20" value="5"
                                            class="mt-1 w-full rounded-xl border-0 bg-gray-50 text-[#545353] placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:bg-gray-50 text-sm py-3 px-4 transition text-center" required>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-[#6e6d6d] uppercase tracking-wider ml-1">Poin Benar</label>
                                        <input type="number" name="score" min="1" value="5"
                                            class="mt-1 w-full rounded-xl border-0 bg-gray-50 text-[#545353] placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:bg-gray-50 text-sm py-3 px-4 transition text-center" required>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs font-bold text-[#1c1c1c] uppercase tracking-wider ml-1 mb-2 block">Tingkat Kesulitan</label>
                                    <div class="grid grid-cols-4 gap-2">
                                        @foreach(['Mudah', 'Sedang', 'Sulit', 'HOTS'] as $diff)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="difficulty" value="{{ $diff }}" class="peer sr-only" {{ $diff == 'Sedang' ? 'checked' : '' }}>
                                            <div class="text-center text-xs py-2 rounded-lg bg-gray-50 border border-transparent text-[#919090] hover:bg-white/20 peer-checked:bg-[#562cbf] peer-checked:text-white peer-checked:font-bold transition select-none">
                                                {{ $diff }}
                                            </div>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>

                                <button type="submit" class="w-full bg-[#562cbf] text-white font-bold py-3 rounded-xl hover:bg-[#4a25a0] transition shadow-lg flex items-center justify-center gap-2 group mt-2">
                                    <span>Generate Sekarang</span>
                                    <i class="fa-solid fa-bolt text-white group-hover:animate-pulse"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 2. ACCORDION / TABS UNTUK MANUAL & IMPORT -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden" x-data="{ activeTab: 'manual' }">
                    <div class="flex border-b border-gray-100">
                        <button @click="activeTab = 'manual'" :class="{ 'text-indigo-600 border-b-2 border-indigo-600 bg-indigo-50/50': activeTab === 'manual', 'text-gray-500 hover:text-gray-700': activeTab !== 'manual' }" class="flex-1 py-3 text-sm font-bold text-center transition">
                            <i class="fa-solid fa-pen-to-square mr-1"></i> Manual
                        </button>
                        <button @click="activeTab = 'import'" :class="{ 'text-green-600 border-b-2 border-green-600 bg-green-50/50': activeTab === 'import', 'text-gray-500 hover:text-gray-700': activeTab !== 'import' }" class="flex-1 py-3 text-sm font-bold text-center transition">
                            <i class="fa-solid fa-file-excel mr-1"></i> Import Excel
                        </button>
                    </div>

                    <!-- UPDATE BAGIAN FORM MANUAL INI -->
<div x-show="activeTab === 'manual'" class="p-6">
    <form action="{{ route('admin.exams.questions.store', $exam->id) }}" method="POST">
        @csrf
        <div class="space-y-5">

            <!-- BARIS 1: Kategori & Poin -->
            <div class="grid grid-cols-12 gap-4">
                <!-- Input Kategori (Bisa Ketik Bebas) -->
                <div class="col-span-8">
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                        Kategori Topik
                        <span class="text-gray-400 font-normal lowercase ml-1">(pilih/ketik baru)</span>
                    </label>
                    <input type="text" list="category_list" name="type"
                        class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 placeholder-gray-400"
                        placeholder="Contoh: Sejarah, Logika..." required>

                    <!-- Opsi Saran (Tetap ada tapi tidak memaksa) -->
                    <datalist id="category_list">
                        <option value="TWK">
                        <option value="TIU">
                        <option value="TKP">
                        <option value="Psikotes">
                        <option value="Bahasa Inggris">
                    </datalist>
                </div>

                <!-- Input Poin Default -->
                <div class="col-span-4">
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Bobot Poin</label>
                    <div class="relative">
                        <input type="number" name="default_score" value="5"
                               class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 pl-3 pr-8"
                               placeholder="5" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-400 text-xs">pts</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BARIS 2: Pertanyaan -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pertanyaan</label>
                <textarea name="question_text" rows="3"
                          class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                          placeholder="Tulis soal disini..." required></textarea>
            </div>

            <!-- BARIS 3: Pilihan Jawaban -->
            <div>
                <div class="flex justify-between items-end mb-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Pilihan Jawaban</label>
                    <span class="text-[10px] text-gray-400">*Klik lingkaran kanan untuk kunci jawaban</span>
                </div>

                <div class="space-y-3">
                    @foreach(['A', 'B', 'C', 'D', 'E'] as $index => $label)
                    <div class="flex items-center group relative">
                        <!-- Label Huruf -->
                        <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded-l-lg border border-r-0 border-gray-300 text-gray-600 font-bold text-sm">
                            {{ $label }}
                        </div>

                        <!-- Input Teks Jawaban -->
                        <input type="text" name="options[]"
                               class="flex-1 block w-full h-10 rounded-none border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 px-3"
                               placeholder="Isi jawaban opsi {{ $label }}..." required>

                        <!-- Input Skor Manual (Opsional, disembunyikan jika ingin otomatis ikut Bobot Poin di atas) -->
                        <input type="number" name="scores[]"
                               class="w-16 h-10 border-gray-300 border-l-0 border-r-0 text-sm text-center focus:ring-indigo-500 text-gray-500 placeholder-gray-300"
                               placeholder="0">

                        <!-- Radio Kunci Jawaban -->
                        <div class="w-10 h-10 bg-gray-50 border border-l-0 border-gray-300 rounded-r-lg flex items-center justify-center hover:bg-indigo-50 cursor-pointer transition">
                            <input type="radio" name="correct_index" value="{{ $index }}"
                                   class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 cursor-pointer border-gray-400" required>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="w-full bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 rounded-xl transition shadow-lg flex items-center justify-center gap-2 transform active:scale-95">
                <i class="fa-solid fa-plus-circle"></i> Simpan Soal Manual
            </button>
        </div>
    </form>
</div>

                    <!-- FORM IMPORT -->
                    <div x-show="activeTab === 'import'" class="p-6 bg-green-50/30">
                        <form action="{{ route('admin.exams.import', $exam->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="border-2 border-dashed border-green-300 rounded-xl p-6 text-center bg-white hover:bg-green-50 transition cursor-pointer relative">
                                <input type="file" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
                                <div class="text-green-600 mb-2 text-3xl">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                </div>
                                <p class="text-sm font-bold text-gray-700">Klik untuk upload .xlsx</p>
                                <p class="text-xs text-gray-400 mt-1">Pastikan format header sesuai template</p>
                            </div>

                            <div class="mt-4">
                                <p class="text-xs font-bold text-gray-500 mb-1">Format Header:</p>
                                <code class="block bg-gray-800 text-green-400 text-[10px] p-2 rounded overflow-x-auto whitespace-nowrap">
                                    | pertanyaan | kategori | opsi_a | opsi_b | opsi_c | opsi_d | opsi_e | kunci | poin |
                                </code>
                            </div>

                            <button type="submit" class="w-full bg-green-600 text-white font-bold py-2.5 rounded-lg hover:bg-green-700 transition shadow-md flex items-center justify-center gap-2 mt-4">
                                <i class="fa-solid fa-file-import"></i> Proses Import
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            <!-- KOLOM KANAN: LIST SOAL & MONITORING -->
            <div class="xl:col-span-2 space-y-8">

                <!-- MONITORING PESERTA -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <span class="w-2 h-6 bg-indigo-500 rounded-full"></span> Live Monitoring
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-500 font-semibold border-b">
                                <tr>
                                    <th class="px-6 py-3">Nama Peserta</th>
                                    <th class="px-6 py-3">Waktu Mulai</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-center">Skor</th>
                                    <th class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($participants as $p)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $p->user->name }}</td>
                                    <td class="px-6 py-4 text-gray-500 text-xs">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4">
                                        @if($p->status == 'completed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Selesai</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 animate-pulse">
                                                <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5"></span> Mengerjakan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-lg text-indigo-600">{{ $p->total_score }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('admin.sessions.reset', $p->id) }}" method="POST" onsubmit="return confirm('Reset sesi ujian peserta ini?')">
                                            @csrf @method('DELETE')
                                            <button class="text-xs text-red-500 hover:text-red-700 hover:bg-red-50 px-2 py-1 rounded transition border border-red-200">
                                                Reset
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic bg-gray-50/30">
                                        Belum ada peserta yang mengikuti ujian ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- DAFTAR SOAL -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-bold text-gray-800 text-lg">Daftar Soal</h3>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Total: {{ $exam->questions->count() }}</span>
                    </div>

                    @forelse($exam->questions as $index => $q)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition duration-200 group">
                        <div class="flex justify-between items-start gap-4">
                            <!-- Nomor & Badge -->
                            <div class="flex flex-col items-center gap-2">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-600 font-bold text-sm">
                                    {{ $index + 1 }}
                                </span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide border {{ $q->type == 'TKP' ? 'bg-pink-50 text-pink-600 border-pink-200' : ($q->type == 'TIU' ? 'bg-blue-50 text-blue-600 border-blue-200' : 'bg-orange-50 text-orange-600 border-orange-200') }}">
                                    {{ $q->type }}
                                </span>
                            </div>

                            <!-- Konten Soal -->
                            <div class="flex-1">
                                <p class="text-gray-800 text-base leading-relaxed mb-4 font-medium">{{ $q->question_text }}</p>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($q->options as $opt)
                                    <div class="relative flex items-center p-2 rounded-lg border {{ $opt->is_correct ? 'bg-green-50 border-green-200' : 'bg-white border-gray-100' }}">
                                        @if($opt->is_correct)
                                            <div class="absolute -left-2 -top-2 bg-green-500 text-white rounded-full p-0.5 w-5 h-5 flex items-center justify-center text-[10px] shadow-sm">
                                                <i class="fa-solid fa-check"></i>
                                            </div>
                                        @endif

                                        <span class="w-6 h-6 flex items-center justify-center rounded text-xs font-bold mr-2 {{ $opt->is_correct ? 'bg-green-200 text-green-800' : 'bg-gray-100 text-gray-500' }}">
                                            {{ substr($opt->option_text, 0, 1) }} <!-- Asumsi opsi diawali huruf, atau hardcode A/B/C -->
                                        </span>
                                        <span class="text-sm text-gray-700 flex-1 {{ $opt->is_correct ? 'font-semibold' : '' }}">{{ $opt->option_text }}</span>

                                        @if($opt->score > 0)
                                        <span class="ml-2 text-[10px] font-bold px-1.5 py-0.5 rounded bg-gray-100 text-gray-600 border border-gray-200">
                                            +{{ $opt->score }}
                                        </span>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Tombol Aksi (Muncul saat Hover) -->
                            <div class="flex flex-col gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.questions.edit', $q->id) }}" class="text-blue-500 hover:bg-blue-50 p-2 rounded-lg transition" title="Edit Soal">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.exams.questions.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Hapus soal ini selamanya?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:bg-red-50 p-2 rounded-lg transition" title="Hapus Soal">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                        <div class="text-gray-300 text-5xl mb-4">
                            <i class="fa-solid fa-clipboard-question"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada soal yang ditambahkan.</p>
                        <p class="text-sm text-gray-400 mt-1">Gunakan Generator AI atau Form Manual di sebelah kiri.</p>
                    </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</div>

<!-- AlpineJS untuk interaktivitas sederhana -->
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
