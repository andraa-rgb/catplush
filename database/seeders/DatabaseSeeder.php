<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Jadwal;
use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menggunakan updateOrCreate untuk mencegah duplikasi data pengguna
        $admin = User::updateOrCreate(
            ['email' => 'admin@lab-wicida.ac.id'],
            [
                'name' => 'Admin WICIDA',
                'password' => Hash::make('admin123'),
                'nip' => '999999999999999999',
                'role' => 'admin',
            ]
        );

        $dosen1 = User::updateOrCreate(
            ['email' => 'budi@lab-wicida.ac.id'],
            [
                'name' => 'Dr. Budi Santoso',
                'password' => Hash::make('password'),
                'nip' => '198501151990031001',
                'role' => 'kepala_lab',
            ]
        );

        $dosen2 = User::updateOrCreate(
            ['email' => 'siti@lab-wicida.ac.id'],
            [
                'name' => 'Ir. Siti Nurhayati',
                'password' => Hash::make('password'),
                'nip' => '198703202015032004',
                'role' => 'staf',
            ]
        );

        $dosen3 = User::updateOrCreate(
            ['email' => 'andriana@lab-wicida.ac.id'],
            [
                'name' => 'Andriana Kusuma',
                'password' => Hash::make('password'),
                'nip' => '199005152018032002',
                'role' => 'staf',
            ]
        );

        // Seed status awal untuk setiap dosen
        Status::updateOrCreate(['user_id' => $dosen1->id], ['status' => 'Ada']);
        Status::updateOrCreate(['user_id' => $dosen2->id], ['status' => 'Mengajar']);
        Status::updateOrCreate(['user_id' => $dosen3->id], ['status' => 'Konsultasi']);

        // Hapus jadwal lama dan isi dengan data baru untuk menghindari duplikasi
        // Nonaktifkan foreign key checks untuk truncate tabel yang memiliki relasi
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('bookings')->truncate();
        DB::table('jadwals')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Jadwal::insert([
            // Jadwal Dosen 1
            ['user_id' => $dosen1->id, 'hari' => 'Senin', 'jam_mulai' => '08:00', 'jam_selesai' => '10:00', 'ruangan' => 'Lab A', 'kegiatan' => 'Mengajar', 'keterangan' => 'Kelas Basis Data', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $dosen1->id, 'hari' => 'Rabu', 'jam_mulai' => '10:00', 'jam_selesai' => '12:00', 'ruangan' => 'Kantor', 'kegiatan' => 'Konsultasi', 'keterangan' => 'Bimbingan Mahasiswa', 'created_at' => now(), 'updated_at' => now()],

            // Jadwal Dosen 2
            ['user_id' => $dosen2->id, 'hari' => 'Senin', 'jam_mulai' => '10:00', 'jam_selesai' => '12:00', 'ruangan' => 'Lab B', 'kegiatan' => 'Mengajar', 'keterangan' => 'Kelas Jaringan Komputer', 'created_at' => now(), 'updated_at' => now()],

            // Jadwal Dosen 3
            ['user_id' => $dosen3->id, 'hari' => 'Jumat', 'jam_mulai' => '10:00', 'jam_selesai' => '12:00', 'ruangan' => 'Kantor', 'kegiatan' => 'Konsultasi', 'keterangan' => 'Bimbingan Proyek Akhir', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}