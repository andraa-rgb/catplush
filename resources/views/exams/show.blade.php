@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 pb-20">
    
    <!-- HEADER UJIAN (Sticky) -->
    <div class="bg-white border-b border-slate-200 sticky top-16 z-30 shadow-sm backdrop-blur-md bg-opacity-95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                
                <!-- Info Kiri: Judul & Jenis Soal -->
                <div>
                    <h1 class="text-lg font-bold text-slate-800 leading-tight">{{ $session->exam->title }}</h1>
                    <div class="flex items-center gap-2 text-sm text-slate-500 mt-1">
                        <!-- Badge Jenis Soal (TIU/TWK/TKP) -->
                        <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs font-bold uppercase border border-blue-200">
                            {{ $questions->items()[0]->type }}
                        </span>
                        <span>Soal No. <span class="font-bold text-slate-900 text-base">{{ $questions->currentPage() }}</span> dari {{ $questions->total() }}</span>
                    </div>
                </div>

                <!-- Timer & Tombol Selesai -->
                <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-end">
                    <!-- Timer Box -->
                    <div class="flex items-center gap-2 bg-slate-100 text-slate-700 px-4 py-2 rounded-lg border border-slate-200 shadow-sm font-mono" id="timer-box">
                        <i class="fa-regular fa-clock text-lg text-blue-600 animate-pulse"></i>
                        <span id="timer" class="text-xl font-bold tracking-widest">--:--:--</span>
                    </div>
                    
                    <form action="{{ route('exams.finish', $session->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengakhiri ujian ini? Jawaban tidak dapat diubah setelah selesai.');">
                        @csrf
                        <button type="submit" class="bg-slate-900 hover:bg-black text-white px-5 py-2.5 rounded-lg font-bold text-sm transition shadow-sm hover:shadow-md flex items-center gap-2">
                            <i class="fa-solid fa-flag-checkered"></i> <span class="hidden sm:inline">Selesai Ujian</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- KOLOM KIRI: SOAL (Lebar 8/12) -->
            <div class="lg:col-span-8">
                @foreach($questions as $question)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    
                    <!-- Area Teks Soal -->
                    <div class="p-6 md:p-8 border-b border-slate-100 bg-slate-50/30">
                        <div class="text-lg md:text-xl text-slate-800 leading-relaxed font-medium select-none">
                            {!! nl2br(e($question->question_text)) !!}
                        </div>
                    </div>

                    <!-- Area Pilihan Jawaban -->
                    <div class="p-6 md:p-8 bg-white">
                        <div class="space-y-4">
                            @foreach($question->options as $index => $option)
                            @php
                                $isSelected = isset($savedAnswer) && $savedAnswer->option_id == $option->id;
                                $labels = ['A', 'B', 'C', 'D', 'E'];
                            @endphp

                            <label class="relative group cursor-pointer block" id="label-{{ $option->id }}">
                                <input type="radio" 
                                       name="answer" 
                                       value="{{ $option->id }}" 
                                       class="peer sr-only"
                                       {{ $isSelected ? 'checked' : '' }}
                                       onclick="saveAnswer({{ $session->id }}, {{ $question->id }}, {{ $option->id }})"
                                >
                                
                                <!-- Card Tampilan Jawaban -->
                                <div class="flex items-start p-4 rounded-xl border-2 transition-all duration-200 
                                    {{ $isSelected ? 'bg-blue-50 border-blue-500 shadow-sm ring-1 ring-blue-200' : 'bg-white border-slate-200 hover:border-blue-300 hover:bg-slate-50' }}">
                                    
                                    <!-- Huruf (A, B, C...) -->
                                    <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg text-sm font-bold mr-4 transition-colors border
                                        {{ $isSelected ? 'bg-blue-600 text-white border-blue-600' : 'bg-slate-100 text-slate-500 border-slate-200 group-hover:bg-blue-100 group-hover:text-blue-600 group-hover:border-blue-200' }}">
                                        {{ $labels[$index] ?? '?' }}
                                    </div>
                                    
                                    <!-- Teks Jawaban -->
                                    <div class="flex-1 text-slate-700 font-medium pt-1 group-hover:text-slate-900 leading-snug">
                                        {{ $option->option_text }}
                                    </div>

                                    <!-- Icon Check -->
                                    <div class="absolute right-4 top-4 text-blue-600 check-icon {{ $isSelected ? '' : 'hidden' }}">
                                        <i class="fa-solid fa-circle-check text-xl"></i>
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tombol Navigasi Bawah -->
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-between items-center">
                        @if($questions->onFirstPage())
                            <button disabled class="flex items-center gap-2 px-5 py-2.5 bg-slate-200 text-slate-400 rounded-lg font-bold text-sm cursor-not-allowed">
                                <i class="fa-solid fa-arrow-left"></i> Sebelumnya
                            </button>
                        @else
                            <a href="{{ $questions->previousPageUrl() }}" class="flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg font-bold text-sm hover:bg-slate-50 hover:text-blue-700 hover:border-blue-300 transition shadow-sm">
                                <i class="fa-solid fa-arrow-left"></i> Sebelumnya
                            </a>
                        @endif

                        @if($questions->hasMorePages())
                            <a href="{{ $questions->nextPageUrl() }}" class="flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white rounded-lg font-bold text-sm hover:bg-blue-700 transition shadow-md hover:shadow-lg">
                                Selanjutnya <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        @else
                             <span class="text-sm text-slate-400 italic font-medium">Ini soal terakhir</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- KOLOM KANAN: NAVIGASI (Lebar 4/12) -->
            <div class="lg:col-span-4">
                <div class="sticky top-40 space-y-6">
                    
                    <!-- Panel Navigasi -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                        <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2 border-b border-slate-100 pb-3 text-sm uppercase tracking-wide">
                            <i class="fa-solid fa-grip text-blue-500"></i> Navigasi Soal
                        </h3>
                        
                        <div class="grid grid-cols-5 gap-2.5">
                            @php $counter = 1; @endphp
                            @foreach($allQuestions as $q)
                                @php
                                    $isAnswered = in_array($q->id, $answeredQuestionIds);
                                    $isCurrent = $questions->items()[0]->id == $q->id;
                                    
                                    // Base Class
                                    $class = "w-full aspect-square flex items-center justify-center rounded-lg text-sm font-bold transition duration-200 border ";
                                    
                                    if ($isCurrent) {
                                        // Posisi Sekarang (Biru Solid + Ring)
                                        $class .= "bg-blue-600 text-white border-blue-600 shadow-md transform scale-105 ring-2 ring-blue-200 z-10";
                                    } elseif ($isAnswered) {
                                        // Sudah Dijawab (Hijau Emerald)
                                        $class .= "bg-emerald-500 text-white border-emerald-500 hover:bg-emerald-600 shadow-sm";
                                    } else {
                                        // Belum Dijawab (Putih/Abu)
                                        $class .= "bg-white text-slate-600 border-slate-200 hover:bg-slate-50 hover:border-slate-300";
                                    }
                                @endphp
                                
                                <a href="{{ route('exams.show', ['session' => $session->id, 'page' => $counter]) }}" 
                                   id="nav-{{ $q->id }}"
                                   class="{{ $class }}">
                                    {{ $counter++ }}
                                </a>
                            @endforeach
                        </div>

                        <!-- Legenda -->
                        <div class="mt-6 pt-4 border-t border-slate-100 grid grid-cols-2 gap-y-3 text-xs font-medium text-slate-500">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-blue-600 rounded shadow-sm"></div> Posisi Sekarang
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-emerald-500 rounded shadow-sm"></div> Sudah Dijawab
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-white border border-slate-300 rounded"></div> Belum Dijawab
                            </div>
                        </div>
                    </div>

                    <!-- Panel Info Singkat -->
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-xs text-blue-800 leading-relaxed shadow-sm">
                        <p class="flex gap-2">
                            <i class="fa-solid fa-circle-info mt-0.5 text-blue-600"></i>
                            <span><strong>Tips:</strong> Anda bisa melewati soal yang sulit dan kembali lagi nanti. Jawaban tersimpan otomatis setiap kali diklik.</span>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // 1. Timer Logic
    let timeLeft = parseInt("{{ $timeLeft }}"); 
    const timerElement = document.getElementById('timer');
    const timerBox = document.getElementById('timer-box');

    function updateTimer() {
        if (timeLeft <= 0) {
            timerElement.innerText = "00:00:00";
            // Ganti style jadi merah jika habis
            timerBox.className = "flex items-center gap-2 bg-red-100 text-red-700 px-4 py-2 rounded-lg border border-red-200 shadow-sm font-mono animate-pulse";
            return; 
        }

        let hours = Math.floor(timeLeft / 3600);
        let minutes = Math.floor((timeLeft % 3600) / 60);
        let seconds = Math.floor(timeLeft % 60);

        timerElement.innerText = 
            (hours < 10 ? "0" + hours : hours) + ":" + 
            (minutes < 10 ? "0" + minutes : minutes) + ":" + 
            (seconds < 10 ? "0" + seconds : seconds);

        // Warning jika kurang dari 5 menit
        if (timeLeft < 300) {
            timerBox.classList.remove('bg-slate-100', 'text-slate-700', 'border-slate-200');
            timerBox.classList.add('bg-red-50', 'text-red-600', 'border-red-200');
        }
        timeLeft--;
    }
    
    setInterval(updateTimer, 1000);
    updateTimer(); 

    // 2. Logic Simpan Jawaban
    function saveAnswer(sessionId, questionId, optionId) {
        
        // A. Visual UI: Update Kartu Pilihan (Reset semua ke default dulu)
        const container = document.querySelectorAll('label[id^="label-"] > div');
        const badges = document.querySelectorAll('label[id^="label-"] > div > div:first-child');
        const icons = document.querySelectorAll('.check-icon');

        container.forEach(el => {
            el.className = 'flex items-start p-4 rounded-xl border-2 transition-all duration-200 bg-white border-slate-200 hover:border-blue-300 hover:bg-slate-50';
        });
        badges.forEach(el => {
            el.className = 'flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg text-sm font-bold mr-4 transition-colors border bg-slate-100 text-slate-500 border-slate-200';
        });
        icons.forEach(el => el.classList.add('hidden'));

        // Set Style Active pada Pilihan yang diklik
        const selectedLabel = document.getElementById('label-' + optionId);
        if(selectedLabel) {
            const card = selectedLabel.querySelector('div');
            const badge = card.querySelector('div:first-child');
            const icon = selectedLabel.querySelector('.check-icon');

            card.className = 'flex items-start p-4 rounded-xl border-2 transition-all duration-200 bg-blue-50 border-blue-500 shadow-sm ring-1 ring-blue-200';
            badge.className = 'flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg text-sm font-bold mr-4 transition-colors border bg-blue-600 text-white border-blue-600';
            icon.classList.remove('hidden');
        }

        // B. Kirim ke Backend (AJAX)
        fetch("{{ route('exams.store_answer') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                session_id: sessionId,
                question_id: questionId,
                option_id: optionId
            })
        })
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            
            // C. Visual UI: Update Navigasi Kanan (Menjadi Hijau)
            const navBtn = document.getElementById('nav-' + questionId);
            if(navBtn) {
                // Hapus style default
                navBtn.classList.remove('bg-white', 'text-slate-600', 'border-slate-200');
                
                // Jika tombol navigasi sedang aktif (Current), jangan ubah warnanya jadi hijau dulu
                // Biarkan tetap biru agar user tau dia di halaman mana.
                if (!navBtn.classList.contains('bg-blue-600')) {
                    navBtn.className = "w-full aspect-square flex items-center justify-center rounded-lg text-sm font-bold transition duration-200 border bg-emerald-500 text-white border-emerald-500 hover:bg-emerald-600 shadow-sm";
                }
            }
        })
        .catch(error => console.error('Gagal menyimpan:', error));
    }
</script>
@endsection