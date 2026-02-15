<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
{
    // 1. SUPER ADMIN (God Mode)
    \App\Models\User::create([
        'name' => 'Super Administrator',
        'email' => 'super@cat.com',
        'password' => bcrypt('password'),
        'role' => 'super_admin',
    ]);

    // 2. ADMIN UJIAN (Operational)
    \App\Models\User::create([
        'name' => 'Panitia Ujian',
        'email' => 'admin@cat.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
    ]);

    // 3. PESERTA (Student)
    \App\Models\User::create([
        'name' => 'Peserta Ujian',
        'email' => 'siswa@cat.com',
        'password' => bcrypt('password'),
        'role' => 'student', // atau 'user' sesuai migration default
    ]);
        // Panggil Seeder Ujian (Agar ada contoh soal)
        // Pastikan file ExamSeeder ada, jika tidak, hapus baris ini
        $this->call(ExamSeeder::class);
    }
}