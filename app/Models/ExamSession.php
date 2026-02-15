<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSession extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Agar kolom tanggal otomatis jadi Carbon object
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function exam() {
        return $this->belongsTo(Exam::class);
    }

    public function answers() {
        return $this->hasMany(ExamAnswer::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
