<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamSession;
use App\Models\ExamAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExamController extends Controller
{
    // 1. Dashboard List Ujian
    public function dashboard()
    {
        $userId = Auth::id();

        // Ambil Data Ujian (Wajib pakai withCount agar jumlah soal muncul)
        // Variabel harus bernama $exams agar sesuai dengan View
        $exams = Exam::withCount('questions')->latest()->get();

        // Statistik: Total Ujian Selesai
        // Variabel harus bernama $totalExamFinished agar sesuai View
        $totalExamFinished = ExamSession::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();

        // Statistik: Rata-rata Skor
        $averageScore = ExamSession::where('user_id', $userId)
            ->where('status', 'completed')
            ->avg('total_score');

        return view('dashboard', compact('exams', 'totalExamFinished', 'averageScore'));
    }

    // 2. Memulai Ujian
    public function startExam($id)
    {
        $exam = Exam::findOrFail($id);
        $user = Auth::user();
        $now = Carbon::now();

        // 1. CEK BATAS WAKTU
        // Jika ada start_date dan sekarang masih sebelum start_date
        if ($exam->start_date && $now->lt($exam->start_date)) {
            return redirect()->back()->with('error', 'Ujian belum dibuka! Dimulai pada: ' . $exam->start_date->format('d M Y H:i'));
        }

        // Jika ada end_date dan sekarang sudah lewat end_date
        if ($exam->end_date && $now->gt($exam->end_date)) {
            return redirect()->back()->with('error', 'Ujian sudah berakhir pada: ' . $exam->end_date->format('d M Y H:i'));
        }

        // 2. CEK SESI ONGOING (Kode Lama)
        $existingSession = ExamSession::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->where('status', 'ongoing')
            ->first();

        if ($existingSession) {
            return redirect()->route('exams.show', ['session' => $existingSession->id, 'page' => 1]);
        }

        // 3. BUAT SESI BARU (Kode Lama)
        $session = ExamSession::create([
            'user_id' => $user->id,
            'exam_id' => $exam->id,
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now()->addMinutes($exam->duration_minutes),
            'status' => 'ongoing'
        ]);

        return redirect()->route('exams.show', ['session' => $session->id, 'page' => 1]);
    }

    // 3. Tampilkan Soal (Show)
    public function showQuestion(Request $request, $sessionId)
    {
        $session = ExamSession::where('id', $sessionId)
            ->where('user_id', Auth::id())
            ->with('exam')
            ->firstOrFail();

        // Jika ujian sudah selesai, lempar ke result
        if ($session->status === 'completed') {
            return redirect()->route('exams.result', $session->id);
        }

        // Cek Waktu Habis
        if (Carbon::now()->greaterThan($session->end_time)) {
            return $this->finishExam($session->id);
        }

        // Ambil Soal (Paginate 1 per halaman)
        $questions = $session->exam->questions()->with('options')->paginate(1);

        // Cek jika halaman melebihi jumlah soal (opsional, untuk safety)
        if ($questions->isEmpty()) {
             return redirect()->route('exams.result', $session->id);
        }

        $currentQuestion = $questions->items()[0];

        // Ambil Jawaban Tersimpan
        $savedAnswer = ExamAnswer::where('exam_session_id', $session->id)
            ->where('question_id', $currentQuestion->id)
            ->first();

        // Hitung Sisa Waktu (Integer)
        $timeLeft = (int) Carbon::now()->diffInSeconds($session->end_time, false);

        // Navigasi Nomor Soal
        $allQuestions = $session->exam->questions()->select('id')->get();
        $answeredQuestionIds = ExamAnswer::where('exam_session_id', $session->id)
            ->pluck('question_id')->toArray();

        return view('exams.show', compact(
            'session',
            'questions',
            'savedAnswer',
            'timeLeft',
            'allQuestions',
            'answeredQuestionIds'
        ));
    }

    // 4. SIMPAN JAWABAN (AJAX)
    public function storeAnswer(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:exam_sessions,id',
            'question_id' => 'required|exists:questions,id',
            'option_id' => 'required|exists:options,id'
        ]);

        $session = ExamSession::where('id', $request->session_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$session) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        ExamAnswer::updateOrCreate(
            [
                'exam_session_id' => $request->session_id,
                'question_id' => $request->question_id
            ],
            [
                'option_id' => $request->option_id
            ]
        );

        return response()->json(['status' => 'success']);
    }

    // 5. Selesai Ujian
    public function finishExam($sessionId)
    {
        $session = ExamSession::where('id', $sessionId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Redirect ke result untuk kalkulasi final
        // Kita tidak update status 'completed' disini, tapi di method result()
        // agar kalkulasi skornya akurat saat halaman result dibuka.
        return redirect()->route('exams.result', $session->id);
    }

    // 6. Halaman Hasil
    public function result($sessionId)
    {
        $session = ExamSession::where('id', $sessionId)
            ->where('user_id', Auth::id())
            ->with(['exam', 'user'])
            ->firstOrFail();

        // 1. Ambil Semua Jawaban Peserta
        $answers = ExamAnswer::where('exam_session_id', $session->id)
            ->with('option')
            ->get();

        // 2. Hitung Statistik
        $totalQuestions = $session->exam->questions()->count();
        $answeredCount = $answers->count();

        $totalScore = 0;
        $correctAnswers = 0;

        foreach ($answers as $ans) {
            if ($ans->option) {
                // Tambahkan poin (bisa 5 utk TIU/TWK, atau 1-5 utk TKP)
                $totalScore += $ans->option->score;

                // Hitung jumlah soal yang dijawab 'benar' (skor > 0)
                if ($ans->option->score > 0) {
                    $correctAnswers++;
                }
            }
        }

        // 3. Update Skor & Status ke Database jika belum completed
        if ($session->status !== 'completed' || $session->total_score != $totalScore) {
            $session->update([
                'total_score' => $totalScore,
                'status' => 'completed'
            ]);
        }

        return view('exams.result', compact(
            'session',
            'totalQuestions',
            'answeredCount',
            'correctAnswers'
        ));
    }

    // 7. Halaman Riwayat Ujian Peserta
    public function history()
    {
        $histories = ExamSession::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->with('exam')
            ->latest()
            ->paginate(10);

        return view('exams.history', compact('histories'));
    }
}
