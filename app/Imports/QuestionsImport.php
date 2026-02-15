<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts; // Tambahkan ini
use Illuminate\Support\Facades\DB; // Tambahkan ini

class QuestionsImport implements ToCollection, WithHeadingRow, WithBatchInserts
{
    protected $examId;

    public function __construct($examId)
    {
        $this->examId = $examId;
    }

    // Tentukan jumlah baris per satu kali kirim ke database
    public function batchSize(): int
    {
        return 100; 
    }

    public function collection(Collection $rows)
    {
        // Bungkus dengan Transaction agar database aman
        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                if (!isset($row['pertanyaan']) || $row['pertanyaan'] == null) continue;

                // 1. Simpan Soal
                $question = Question::create([
                    'exam_id' => $this->examId,
                    'question_text' => $row['pertanyaan'],
                    'type' => $row['kategori'] ?? 'Umum',
                ]);

                // 2. Simpan Opsi Jawaban (A-E)
                $options = ['a', 'b', 'c', 'd', 'e'];
                
                foreach ($options as $optKey) {
                    $columnName = 'opsi_' . $optKey;
                    
                    if (isset($row[$columnName]) && $row[$columnName] != null) {
                        $isCorrect = (strtolower($row['kunci'] ?? '') == $optKey);
                        
                        // Logika skor
                        $score = 0;
                        if ($isCorrect) {
                            $score = isset($row['poin']) ? $row['poin'] : 5;
                        }

                        Option::create([
                            'question_id' => $question->id,
                            'option_text' => $row[$columnName],
                            'is_correct' => $isCorrect,
                            'score' => $score
                        ]);
                    }
                }
            }
        });
    }
}
