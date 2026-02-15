<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_mahasiswa',
        'email_mahasiswa',
        'nim_mahasiswa',
        'tanggal_booking',
        'jam_mulai',
        'jam_selesai',
        'keperluan',
        'status',
        'alasan_reject',
        'catatan_dosen',
        'approved_at',
        'rejected_at',
    ];

    protected $casts = [
        'tanggal_booking' => 'date',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
