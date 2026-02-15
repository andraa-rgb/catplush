<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    use HasFactory;
    
    // TAMBAHKAN INI: Agar data bisa disimpan
    protected $fillable = [
        'exam_session_id',
        'question_id',
        'option_id'
    ];

      public function question()
    {
        return $this->belongsTo(Question::class);
    }


    // Relasi (Opsional tapi bagus untuk nanti)
    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}