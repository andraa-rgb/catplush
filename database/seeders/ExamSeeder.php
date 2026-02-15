<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Facades\DB;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   // SETELAH PERUBAHAN (Kompatibel dengan SQLite)
        public function run()
        {
            // Menonaktifkan Foreign Key Checks untuk SQLite/MySQL yang support
            if (DB::connection()->getDriverName() == 'sqlite') {
                DB::statement('PRAGMA foreign_keys = OFF;');
            } else {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            }

            Option::truncate();
            Question::truncate();
            Exam::truncate();
            
            // Mengaktifkan kembali Foreign Key Checks
            if (DB::connection()->getDriverName() == 'sqlite') {
                DB::statement('PRAGMA foreign_keys = ON;');
            } else {
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }

            // 1. Buat Paket Ujian SKD CPNS Lengkap
            $exam = Exam::create([
                'title' => 'Simulasi SKD CPNS Paket Lengkap (TWK, TIU, TKP)',
                'description' => 'Paket latihan soal lengkap SKD yang mencakup TWK, TIU, dan TKP dengan passing grade standar CPNS.',
                'duration_minutes' => 100,
            ]);



        // --- FUNGSI BANTU UNTUK MEMBUAT SOAL DAN OPSI ---
        $createQuestionWithOptions = function ($examId, $type, $questionText, $optionsData) {
            $question = Question::create([
                'exam_id' => $examId,
                'question_text' => $questionText,
                'type' => $type,
            ]);

            foreach ($optionsData as $opt) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $opt['text'],
                    'score' => $opt['score'],
                    'is_correct' => $opt['correct'] ?? 0, // Default 0 jika tidak diset (khusus TKP)
                ]);
            }
        };


        // --- 2. Tambahkan Soal TWK (Total 5 soal contoh) ---

        $createQuestionWithOptions($exam->id, 'TWK', 'Lambang negara Indonesia adalah Garuda Pancasila dengan semboyan Bhinneka Tunggal Ika. Lambang negara diatur dalam UUD 1945 pasal...', [
            ['text' => 'Pasal 35', 'score' => 0, 'correct' => 0],
            ['text' => 'Pasal 36A', 'score' => 5, 'correct' => 1], // Benar
            ['text' => 'Pasal 36B', 'score' => 0, 'correct' => 0],
            ['text' => 'Pasal 36C', 'score' => 0, 'correct' => 0],
            ['text' => 'Pasal 36', 'score' => 0, 'correct' => 0],
        ]);
        
        $createQuestionWithOptions($exam->id, 'TWK', 'Pancasila disahkan sebagai dasar negara pada tanggal...', [
            ['text' => '1 Juni 1945', 'score' => 0],
            ['text' => '22 Juni 1945', 'score' => 0],
            ['text' => '17 Agustus 1945', 'score' => 0],
            ['text' => '18 Agustus 1945', 'score' => 5, 'correct' => 1], // Benar
            ['text' => '19 Agustus 1945', 'score' => 0],
        ]);
        
        // Dummy TWK lainnya
        for($i=3; $i<=5; $i++) {
            $createQuestionWithOptions($exam->id, 'TWK', "Contoh soal TWK nomor $i: Pertanyaan terkait sejarah kemerdekaan...", [
                ['text' => 'Opsi A', 'score' => 0],
                ['text' => 'Opsi B', 'score' => 0],
                ['text' => 'Opsi C (Benar)', 'score' => 5, 'correct' => 1],
                ['text' => 'Opsi D', 'score' => 0],
                ['text' => 'Opsi E', 'score' => 0],
            ]);
        }


        // --- 3. Tambahkan Soal TIU (Total 5 soal contoh) ---

        $createQuestionWithOptions($exam->id, 'TIU', 'Semua dokter adalah orang pintar. Sebagian orang pintar suka membaca. Kesimpulan yang paling tepat adalah...', [
            ['text' => 'Sebagian dokter suka membaca', 'score' => 0],
            ['text' => 'Semua orang pintar adalah dokter', 'score' => 0],
            ['text' => 'Sebagian orang pintar adalah dokter', 'score' => 5, 'correct' => 1], // Jawaban Benar
            ['text' => 'Semua dokter suka membaca', 'score' => 0],
            ['text' => 'Tidak ada kesimpulan yang benar', 'score' => 0],
        ]);

        $createQuestionWithOptions($exam->id, 'TIU', 'Deret angka: 2, 4, 6, 8, ... Angka selanjutnya adalah?', [
            ['text' => '9', 'score' => 0],
            ['text' => '10', 'score' => 5, 'correct' => 1], // Benar
            ['text' => '11', 'score' => 0],
            ['text' => '12', 'score' => 0],
            ['text' => '14', 'score' => 0],
        ]);
        
        // Dummy TIU lainnya
        for($i=3; $i<=5; $i++) {
             $createQuestionWithOptions($exam->id, 'TIU', "Contoh soal TIU nomor $i: Pertanyaan terkait hitungan cepat...", [
                ['text' => 'Jawaban A', 'score' => 0],
                ['text' => 'Jawaban B', 'score' => 0],
                ['text' => 'Jawaban C', 'score' => 0],
                ['text' => 'Jawaban D (Benar)', 'score' => 5, 'correct' => 1],
                ['text' => 'Jawaban E', 'score' => 0],
            ]);
        }


        // --- 4. Tambahkan Soal TKP (Total 5 soal contoh) ---
        // Penilaian TKP: Semua opsi punya poin (1 s.d 5), is_correct hanya formalitas

        $createQuestionWithOptions($exam->id, 'TKP', 'Saat menghadapi rekan kerja yang sulit diajak bekerja sama dalam sebuah proyek, sikap saya adalah...', [
            ['text' => 'Melaporkannya kepada atasan dan meminta anggota tim baru.', 'score' => 1],
            ['text' => 'Mengabaikannya dan mengerjakan bagian saya sendiri.', 'score' => 2],
            ['text' => 'Mencoba memahami perspektifnya dan mencari solusi kompromi.', 'score' => 4],
            ['text' => 'Mengajaknya berdiskusi secara pribadi untuk mencari tahu masalahnya.', 'score' => 5, 'correct' => 1], // Poin tertinggi
            ['text' => 'Memintanya untuk segera berubah sikap demi kelancaran proyek.', 'score' => 3],
        ]);
        
        $createQuestionWithOptions($exam->id, 'TKP', 'Anda diberikan tugas tambahan yang melebihi deskripsi pekerjaan Anda. Apa yang Anda lakukan?', [
            ['text' => 'Menerima tugas tersebut dengan berat hati.', 'score' => 2],
            ['text' => 'Menolak tugas tersebut karena bukan tanggung jawab saya.', 'score' => 1],
            ['text' => 'Menerima tugas dengan antusias sebagai kesempatan belajar.', 'score' => 5, 'correct' => 1], // Poin tertinggi
            ['text' => 'Menerima tugas, tetapi meminta kompensasi tambahan.', 'score' => 3],
            ['text' => 'Menerima tugas setelah bernegosiasi tentang beban kerja.', 'score' => 4],
        ]);

        // Dummy TKP lainnya
        for($i=3; $i<=5; $i++) {
             $createQuestionWithOptions($exam->id, 'TKP', "Contoh soal TKP nomor $i: Pertanyaan terkait integritas kerja...", [
                ['text' => 'Opsi A (Poin 1)', 'score' => 1],
                ['text' => 'Opsi B (Poin 2)', 'score' => 2],
                ['text' => 'Opsi C (Poin 3)', 'score' => 3],
                ['text' => 'Opsi D (Poin 4)', 'score' => 4],
                ['text' => 'Opsi E (Poin 5)', 'score' => 5, 'correct' => 1], // Poin tertinggi
            ]);
        }
    }
}
