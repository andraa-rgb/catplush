<x-mail::message>
# ✓ Booking Konsultasi Anda Telah Disetujui

Halo **{{ $booking->nama_mahasiswa }}**,

Selamat! Booking konsultasi Anda telah **disetujui** oleh dosen. Anda sudah bisa berkonsultasi sesuai dengan jadwal yang telah ditentukan.

## Detail Booking Anda:

**Informasi Pribadi:**
- Nama: {{ $booking->nama_mahasiswa }}
- Email: {{ $booking->email_mahasiswa }}
- NIM: {{ $booking->nim_mahasiswa ?? 'Tidak tercantum' }}

**Jadwal Konsultasi:**
- Tanggal: {{ $booking->tanggal_booking->format('d MMMM Y', locale: 'id') }}
- Waktu: {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
- Topik: {{ $booking->keperluan }}

**Dosen Pembimbing:** {{ $booking->user->name }}
**Email Dosen:** {{ $booking->user->email }}

---

@if($booking->catatan_dosen)
## 📌 Catatan dari Dosen:

{{ $booking->catatan_dosen }}

---
@endif

**Status:** ✓ Disetujui

Pastikan Anda hadir tepat waktu pada jadwal yang telah ditentukan. Jika ada pertanyaan atau perlu mengubah jadwal, hubungi dosen secara langsung.

Terima kasih,
<x-mail::footer>
Lab WICIDA - Sistem Jadwal Dosen Real-Time<br>
{{ config('app.name') }}
</x-mail::footer>
</x-mail::message>
