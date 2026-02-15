<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'kegiatan',
        'keterangan',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}