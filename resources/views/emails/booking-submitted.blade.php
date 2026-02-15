<x-mail::message>
# 📋 Booking Konsultasi Diterima

Halo **{{ $booking->nama_mahasiswa }}**,

Terima kasih telah mengajukan booking konsultasi dengan dosen. Kami telah menerima permintaan Anda dan akan segera memproses dengan sebaik-baiknya.

## Detail Booking Anda:

**Informasi Pribadi:**
- Nama: {{ $booking->nama_mahasiswa }}
- Email: {{ $booking->email_mahasiswa }}
- NIM: {{ $booking->nim_mahasiswa ?? 'Tidak tercantum' }}

**Jadwal Konsultasi:**
- Tanggal: {{ $booking->tanggal_booking->format('d MMMM Y', locale: 'id') }}
- Waktu: {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
- Topik: {{ $booking->keperluan }}

---

**Status:** ⏳ Menunggu Konfirmasi dari Dosen

Dosen akan meninjau booking Anda dan mengirimkan email konfirmasi dalam waktu 1x24 jam. Mohon periksa email Anda secara berkala.

Jika ada pertanyaan atau perubahan, silakan hubungi dosen secara langsung.

Terima kasih,
<x-mail::footer>
Lab WICIDA - Sistem Jadwal Dosen Real-Time<br>
{{ config('app.name') }}
</x-mail::footer>
</x-mail::message>
