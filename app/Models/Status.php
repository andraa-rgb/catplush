<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'updated_at_iot',
    ];

    protected $casts = [
        'updated_at_iot' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk badge status
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'Ada' => ['color' => 'green', 'icon' => '🟢'],
            'Mengajar' => ['color' => 'red', 'icon' => '🔴'],
            'Konsultasi' => ['color' => 'yellow', 'icon' => '🟡'],
            'Tidak Ada' => ['color' => 'gray', 'icon' => '⚪'],
            default => ['color' => 'gray', 'icon' => '⚪'],
        };
    }
}
