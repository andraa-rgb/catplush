<x-mail::message>
# ✗ Booking Konsultasi Anda Ditolak

Halo **{{ $booking->nama_mahasiswa }}**,

Mohon maaf, booking konsultasi Anda telah **ditolak** oleh dosen. Silakan baca penjelasan di bawah dan hubungi dosen untuk mengatur jadwal alternatif jika diperlukan.

## Detail Booking yang Ditolak:

**Informasi Pribadi:**
- Nama: {{ $booking->nama_mahasiswa }}
- Email: {{ $booking->email_mahasiswa }}
- NIM: {{ $booking->nim_mahasiswa ?? 'Tidak tercantum' }}

**Jadwal yang Diajukan:**
- Tanggal: {{ $booking->tanggal_booking->format('d MMMM Y', locale: 'id') }}
- Waktu: {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
- Topik: {{ $booking->keperluan }}

**Dosen Pembimbing:** {{ $booking->user->name }}
**Email Dosen:** {{ $booking->user->email }}

---

## 📌 Alasan Penolakan:

{{ $booking->alasan_reject }}

---

**Status:** ✗ Ditolak

Anda dapat mengajukan booking kembali dengan memilih jadwal alternatif yang sesuai dengan ketersediaan dosen. Silakan kunjungi sistem booking atau hubungi dosen untuk informasi lebih lanjut.

Terima kasih atas pemahaman Anda.

Terima kasih,
<x-mail::footer>
Lab WICIDA - Sistem Jadwal Dosen Real-Time<br>
{{ config('app.name') }}
</x-mail::footer>
</x-mail::message>
