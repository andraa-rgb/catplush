<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exam_session_id',
        'score',
        'passed',
    ];

    protected $casts = [
        'passed' => 'boolean',
    ];

    public function session()
    {
        return $this->belongsTo(ExamSession::class, 'exam_session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}