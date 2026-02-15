<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'duration_minutes',
        'start_date', 
        'end_date'    
    ];

    // Agar otomatis jadi objek Carbon (Mudah diformat tanggalnya)
    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}