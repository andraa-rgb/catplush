<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use App\Models\Option;
use App\Models\ExamSession;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\QuestionsImport;
use Illuminate\Support\Facades\Http;

class AdminExamController extends Controller
{
    // 1. Dashboard Admin & List Ujian
    public function index()
    {
        $exams = Exam::withCount('questions')->latest()->get();
        return view('admin.exams.index', compact('exams'));
    }

    // 2. Form Buat Ujian Baru
    public function create()
    {
        return view('admin.exams.create');
    }

    // 3. Simpan Ujian Baru
    // Update method store
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'duration_minutes' => 'required|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date', // Validasi: Tgl selesai harus setelah mulai
        ]);

        $exam = Exam::create([
            'title' => $request->title,
            'description' => $request->description,
            'duration_minutes' => $request->duration_minutes,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('admin.exams.show', $exam->id)->with('success', 'Ujian berhasil dibuat!');
    }
    
    // 4. Detail Ujian (Tempat Menambah Soal)
    public function show($id)
    {
        $exam = Exam::with(['questions.options'])->findOrFail($id);
        
        // Ambil peserta yang sudah mengerjakan ujian ini
        $participants = ExamSession::where('exam_id', $id)
                        ->with('user')
                        ->orderBy('total_score', 'desc')
                        ->get();

        return view('admin.exams.show', compact('exam', 'participants'));
    }

    public function storeQuestion(Request $request, $examId)
    {
        // 1. Validasi Input
        $request->validate([
            'question_text' => 'required',
            'type'          => 'required',
            'options'       => 'required|array|min:2',
            // Kita hapus validasi 'scores' required karena di mode Standar dia kosong
            // 'correct_index' required agar user tidak lupa memilih jawaban benar
            'correct_index' => 'required', 
        ]);

        // 2. Simpan Soal Utama
        $question = Question::create([
            'exam_id'       => $examId,
            'question_text' => $request->question_text,
            'type'          => $request->type
        ]);

        // 3. Ambil Nilai Default (jika mode standar)
        $defaultScore = $request->input('default_score', 5); // Default 5 jika tidak diisi

        // 4. Loop Simpan Opsi Jawaban
        foreach($request->options as $index => $optionText) {
            
            // Tentukan Apakah Ini Jawaban Benar (Berdasarkan Radio Button)
            $isCorrect = ($index == $request->correct_index);

            // LOGIKA PENENTUAN SKOR:
            // Cek apakah user mengisi input manual 'scores' untuk index ini (Mode TKP)?
            // Jika ada isinya dan tidak null, pakai itu.
            // Jika kosong, gunakan logika Standar (Benar=Default, Salah=0).
            
            $manualScoreInput = $request->scores[$index] ?? null;

            if ($manualScoreInput !== null && $manualScoreInput !== '') {
                // KASUS A: MODE TKP (User isi angka manual 1-5)
                $score = (int) $manualScoreInput;
            } else {
                // KASUS B: MODE STANDAR (User hanya pilih radio button)
                // Jika benar dapat poin default, jika salah 0
                $score = $isCorrect ? $defaultScore : 0;
            }

            Option::create([
                'question_id' => $question->id,
                'option_text' => $optionText,
                'score'       => $score, // Nilai ini sekarang dijamin terisi (tidak NULL)
                'is_correct'  => $isCorrect
            ]);
        }

        return redirect()->back()->with('success', 'Soal berhasil ditambahkan!');
    }
    
    // 6. Hapus Soal
    public function destroyQuestion($id)
    {
        $question = Question::findOrFail($id);
        $question->delete(); // Otomatis hapus options karena on cascade
        return redirect()->back()->with('success', 'Soal dihapus');
    }

    // ... method sebelumnya ...

    // 7. Halaman Edit Soal
    public function editQuestion($id)
    {
        $question = Question::with('options')->findOrFail($id);
        return view('admin.questions.edit', compact('question'));
    }

    // 8. Proses Update Soal
    public function updateQuestion(Request $request, $id)
    {
        $request->validate([
            'question_text' => 'required',
            'type' => 'required|string',
            'options' => 'required|array|min:2',
            'correct_index' => 'required',
            'score_correct' => 'required|integer'
        ]);

        $question = Question::findOrFail($id);

        // A. Update Data Soal
        $question->update([
            'question_text' => $request->question_text,
            'type' => $request->type
        ]);

        // B. Update Pilihan Jawaban
        // Cara paling aman & mudah: Hapus opsi lama, buat ulang opsi baru
        // (Agar tidak ribet mencocokkan ID opsi satu per satu)
        $question->options()->delete();

        foreach($request->options as $index => $optionText) {
            $score = ($index == $request->correct_index) ? $request->score_correct : 0;
            $isCorrect = ($index == $request->correct_index) ? true : false;

            Option::create([
                'question_id' => $question->id,
                'option_text' => $optionText,
                'score' => $score,
                'is_correct' => $isCorrect
            ]);
        }

        return redirect()->route('admin.exams.show', $question->exam_id)->with('success', 'Soal berhasil diperbarui!');
    }

    // 9. Reset Ujian Peserta (Hapus Sesi)
    public function resetSession($id)
    {
        // Cari sesi berdasarkan ID
        $session = ExamSession::findOrFail($id);
        
        // Hapus semua jawaban terkait sesi ini dulu (otomatis jika cascade, tapi aman ditulis)
        $session->answers()->delete();
        
        // Hapus sesi
        $session->delete();

        return redirect()->back()->with('success', 'Ujian peserta berhasil di-reset. Peserta bisa mulai dari awal.');
    }

    // ... method lainnya ...

    // 10. Hapus Ujian (Paket Soal) Secara Keseluruhan
    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        
        // Karena kita menggunakan cascade delete di migration, 
        // menghapus Exam akan otomatis menghapus Question, Option, dan ExamSession terkait.
        $exam->delete();

        return redirect()->route('admin.exams.index')->with('success', 'Paket ujian berhasil dihapus.');
    }

    // ... method lainnya ...

   // 11. Proses Import Excel (SUDAH DIPERBAIKI)
    public function importQuestions(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120' // Batasi maks 5MB
        ]);

        try {
            $file = $request->file('file');
            
            // Kita tambahkan parameter ke-4: \Maatwebsite\Excel\Excel::XLSX
            // Ini memberitahu sistem: "Baca file ini sebagai XLSX, jangan tebak-tebak sendiri"
            
            Excel::import(
                new QuestionsImport($id), 
                $file, 
                null, 
                \Maatwebsite\Excel\Excel::XLSX
            );
            
            return redirect()->back()->with('success', 'Soal berhasil diimport!');
        } catch (\Exception $e) {
            // Tampilkan pesan error detail
            return redirect()->back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    
    // 12. Download Template Excel (Opsional, agar user tahu formatnya)
    public function downloadTemplate()
    {
        // Anda bisa membuat file dummy manual atau mengarahkan ke link statis
        // Untuk simpelnya, kita skip dulu atau buat route download file statis
    }

    // ... method import dll ...

    // 13. GENERATE SOAL BY AI (GEMINI) - UPDATED
    public function generateQuestions(Request $request, $id)
    {
        $request->validate([
            'topic' => 'required|string',
            'amount' => 'required|integer|min:1|max:30', // Bisa minta sampai 30, tapi hati-hati timeout
            'score' => 'required|integer|min:1', // Validasi skor
            'difficulty' => 'required|string'
        ]);

        $apiKey = env('GEMINI_API_KEY');
        $topic = $request->topic;
        $amount = $request->amount;
        $difficulty = $request->difficulty;
        $scoreValue = $request->score; // Ambil nilai skor dari inputan user

        // Prompt Engineering yang Diperbarui
        $prompt = "Buatkan $amount soal pilihan ganda tentang '$topic' dengan tingkat kesulitan '$difficulty'. 
        Bahasa: Indonesia.
        Format Output WAJIB JSON Array murni tanpa markdown (```json). 
        Struktur objek: 
        {
            'question': 'teks soal lengkap',
            'category': 'kategori umum/topik',
            'options': ['opsi A', 'opsi B', 'opsi C', 'opsi D', 'opsi E'],
            'correct_index': 0 (index array jawaban benar 0-4)
        }
        Pastikan output valid JSON dan tidak terpotong.";

        try {
            // Gunakan Model yang sudah terbukti jalan di akun Anda (misal: gemini-pro atau gemini-1.5-flash)
            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                "contents" => [
                    [
                        "parts" => [
                            ["text" => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->failed()) {
                return redirect()->back()->with('error', 'Google Error: ' . $response->body());
            }

            $result = $response->json();
            
            if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                return redirect()->back()->with('error', 'Gagal: AI tidak memberikan jawaban. Coba kurangi jumlah soal.');
            }

            $rawText = $result['candidates'][0]['content']['parts'][0]['text'];
            $cleanJson = str_replace(['```json', '```'], '', $rawText);
            $questionsData = json_decode($cleanJson, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return redirect()->back()->with('error', 'Format JSON dari AI rusak (mungkin terpotong karena jumlah terlalu banyak). Coba kurangi jumlah soal per request.');
            }

            // Simpan ke Database
            foreach ($questionsData as $qData) {
                $question = Question::create([
                    'exam_id' => $id,
                    'question_text' => $qData['question'],
                    'type' => $qData['category'] ?? 'Umum',
                ]);

                foreach ($qData['options'] as $index => $optText) {
                    $isCorrect = ($index == $qData['correct_index']);
                    
                    Option::create([
                        'question_id' => $question->id,
                        'option_text' => $optText,
                        'is_correct' => $isCorrect,
                        // Gunakan Skor dari Input User, BUKAN dari AI
                        'score' => $isCorrect ? $scoreValue : 0 
                    ]);
                }
            }

            return redirect()->back()->with('success', "Berhasil generate $amount soal dengan skor $scoreValue per soal!");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error Sistem: ' . $e->getMessage());
        }
    }
    // Method Menampilkan Form Edit
    public function edit($id)
    {
        $exam = Exam::findOrFail($id);
        return view('admin.exams.edit', compact('exam'));
    }

    // Method Proses Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'duration_minutes' => 'required|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $exam = Exam::findOrFail($id);

        $exam->update([
            'title' => $request->title,
            'description' => $request->description,
            'duration_minutes' => $request->duration_minutes,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('admin.exams.index')->with('success', 'Paket ujian berhasil diperbarui!');
    }
}