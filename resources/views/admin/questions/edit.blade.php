@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Edit Soal</h2>
            <a href="{{ route('admin.exams.show', $question->exam_id) }}" class="text-gray-500 hover:text-gray-700">
                &times; Batal
            </a>
        </div>

        <form action="{{ route('admin.questions.update', $question->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Kategori (Edit) -->
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kategori Soal</label>
                    
                    <input type="text" list="category_list" name="type" 
                        value="{{ $question->type }}" 
                        class="w-full border-gray-300 rounded-lg shadow-sm" 
                        placeholder="Ketik kategori..." required>

                    <datalist id="category_list">
                        <option value="TWK">
                        <option value="TIU">
                        <option value="TKP">
                        <option value="Bahasa Inggris">
                        <option value="Matematika">
                    </datalist>
                </div>

                <!-- Skor -->
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Poin Benar</label>
                    {{-- Ambil skor dari opsi yang benar (jika ada), default 5 --}}
                    @php 
                        $correctOption = $question->options->where('is_correct', 1)->first();
                        $currentScore = $correctOption ? $correctOption->score : 5;
                    @endphp
                    <input type="number" name="score_correct" value="{{ $currentScore }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>
            </div>

            <!-- Teks Soal -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Pertanyaan</label>
                <textarea name="question_text" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm" required>{{ $question->question_text }}</textarea>
            </div>

            <!-- Pilihan Jawaban -->
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-4">Pilihan Jawaban & Kunci</label>
                
                <div class="space-y-3">
                    @foreach($question->options as $index => $option)
                    <div class="flex items-center gap-3">
                        <div class="flex items-center h-10">
                            {{-- Radio Button Kunci Jawaban --}}
                            <input type="radio" name="correct_index" value="{{ $index }}" 
                                class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300"
                                {{ $option->is_correct ? 'checked' : '' }} required>
                        </div>
                        <div class="flex-1">
                            {{-- Input Teks Pilihan --}}
                            <input type="text" name="options[]" value="{{ $option->option_text }}" 
                                class="w-full border-gray-300 rounded-lg shadow-sm h-10 px-3 {{ $option->is_correct ? 'border-green-500 ring-1 ring-green-500 bg-green-50' : '' }}" required>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="w-full bg-purple-700 text-white font-bold py-3 rounded-lg hover:bg-purple-800 transition shadow-lg">
                Simpan Perubahan
            </button>
        </form>

    </div>
</div>
@endsection