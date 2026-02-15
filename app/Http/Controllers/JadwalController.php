<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingSubmitted;
use App\Mail\BookingApproved;
use App\Mail\BookingRejected;

class JadwalController extends Controller
{
    // ===== PUBLIC ROUTES =====
    
    /**
     * Halaman utama publik - grid dosen dengan status real-time
     */
    public function home()
    {
        // Ambil semua dosen dari Lab WICIDA (role staf/kepala_lab)
        $dosens = User::whereIn('role', ['staf', 'kepala_lab'])
            ->orderBy('created_at', 'desc')
            ->with('status')
            ->get();

        return view('home', compact('dosens'));
    }

    /**
     * Halaman detail dosen - calendar + form booking
     */
    public function show($id)
    {
        $dosen = User::with(['jadwals', 'status'])->findOrFail($id);
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        
        // Group jadwal by hari
        $jadwalByHari = [];
        foreach ($hari as $h) {
            $jadwalByHari[$h] = $dosen->jadwals()->where('hari', $h)->get();
        }

        return view('jadwal.detail', compact('dosen', 'jadwalByHari', 'hari'));
    }

    /**
     * Submit booking konsultasi
     */
    public function storeBooking(Request $request, $dosenId)
    {
        $validated = $request->validate([
            'nama_mahasiswa' => 'required|string|max:255',
            'email_mahasiswa' => 'required|email',
            'nim_mahasiswa' => 'nullable|string|max:20',
            'tanggal_booking' => 'required|date|after:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'keperluan' => 'required|string|max:500',
        ]);

        $validated['user_id'] = $dosenId;
        $booking = Booking::create($validated);

        // Send submission confirmation email
        try {
            Mail::to($booking->email_mahasiswa)->send(new BookingSubmitted($booking));
        } catch (\Exception $e) {
            // Log error but don't fail the booking
            \Log::error('Failed to send booking submission email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Booking berhasil dikirim. Email konfirmasi telah dikirim ke ' . $booking->email_mahasiswa . ' dan tunggu persetujuan dari dosen.');
    }

    /**
     * Get jadwal untuk AJAX (timeline mahasiswa)
     */
    public function getJadwalByDay(Request $request, $dosenId)
    {
        $hari = $request->query('hari');
        $jadwals = Jadwal::where('user_id', $dosenId)
            ->where('hari', $hari)
            ->get();

        return response()->json($jadwals);
    }

    // ===== DOSEN ROUTES (AUTH REQUIRED) =====

    /**
     * Dashboard dosen - jadwal minggu ini
     */
    public function dashboard()
    {
        $dosen = Auth::user();
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        
        $jadwalByHari = [];
        foreach ($hari as $h) {
            $jadwalByHari[$h] = $dosen->jadwals()->where('hari', $h)->get();
        }

        return view('dosen.dashboard', compact('jadwalByHari', 'hari'));
    }

    /**
     * List jadwal dosen untuk manage
     */
    public function indexJadwal()
    {
        $dosen = Auth::user();
        $jadwals = $dosen->jadwals()->orderBy('hari')->get();

        return view('dosen.jadwal.index', compact('jadwals'));
    }

    /**
     * Form create jadwal
     */
    public function createJadwal()
    {
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $kegiatan = ['Mengajar', 'Konsultasi', 'Rapat', 'Lainnya'];

        return view('dosen.jadwal.create', compact('hari', 'kegiatan'));
    }

    /**
     * Store jadwal baru
     */
    public function storeJadwal(Request $request)
    {
        $validated = $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'nullable|string|max:100',
            'kegiatan' => 'required|in:Mengajar,Konsultasi,Rapat,Lainnya',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $validated['user_id'] = Auth::id();
        Jadwal::create($validated);

        return redirect()->route('dosen.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Form edit jadwal
     */
    public function editJadwal($id)
    {
        $jadwal = Jadwal::where('user_id', Auth::id())->findOrFail($id);
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $kegiatan = ['Mengajar', 'Konsultasi', 'Rapat', 'Lainnya'];

        return view('dosen.jadwal.edit', compact('jadwal', 'hari', 'kegiatan'));
    }

    /**
     * Update jadwal
     */
    public function updateJadwal(Request $request, $id)
    {
        $jadwal = Jadwal::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'nullable|string|max:100',
            'kegiatan' => 'required|in:Mengajar,Konsultasi,Rapat,Lainnya',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $jadwal->update($validated);

        return redirect()->route('dosen.jadwal.index')->with('success', 'Jadwal berhasil diubah.');
    }

    /**
     * Delete jadwal
     */
    public function destroyJadwal($id)
    {
        $jadwal = Jadwal::where('user_id', Auth::id())->findOrFail($id);
        $jadwal->delete();

        return redirect()->route('dosen.jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    // ===== BOOKING ROUTES (DOSEN) =====

    /**
     * List booking requests untuk dosen
     */
    public function indexBooking(Request $request)
    {
        $dosen = Auth::user();
        $query = $dosen->bookings();
        
        // Apply status filter if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $bookings = $query->orderBy('tanggal_booking', 'desc')
            ->paginate(10);

        return view('dosen.booking.index', compact('bookings'));
    }

    /**
     * Approve booking
     */
    public function approveBooking(Request $request, $id)
    {
        $validated = $request->validate([
            'catatan_dosen' => 'nullable|string|max:1000',
        ]);

        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);
        
        $booking->update([
            'status' => 'approved',
            'catatan_dosen' => $validated['catatan_dosen'] ?? null,
            'approved_at' => now(),
        ]);

        // Send approval email
        try {
            Mail::to($booking->email_mahasiswa)->send(new BookingApproved($booking));
        } catch (\Exception $e) {
            // Log error but don't fail the approval
            \Log::error('Failed to send booking approval email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Booking disetujui dan email notifikasi telah dikirim ke ' . $booking->email_mahasiswa);
    }

    /**
     * Reject booking
     */
    public function rejectBooking(Request $request, $id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'alasan_reject' => 'required|string|max:500',
        ]);

        $booking->update([
            'status' => 'rejected',
            'alasan_reject' => $validated['alasan_reject'],
            'rejected_at' => now(),
        ]);

        // Send rejection email
        try {
            Mail::to($booking->email_mahasiswa)->send(new BookingRejected($booking));
        } catch (\Exception $e) {
            // Log error but don't fail the rejection
            \Log::error('Failed to send booking rejection email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Booking ditolak dan email notifikasi telah dikirim ke ' . $booking->email_mahasiswa);
    }

    // ===== STATUS ROUTES (IoT) =====

    /**
     * Update status dari IoT / manual
     */
    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:Ada,Mengajar,Konsultasi,Tidak Ada',
        ]);

        $dosen = Auth::user();
        $dosen->status()->updateOrCreate(
            ['user_id' => $dosen->id],
            [
                'status' => $validated['status'],
                'updated_at_iot' => now(),
            ]
        );

        return response()->json(['message' => 'Status berhasil diperbarui']);
    }

    /**
     * Get current status dosen
     */
    public function getStatus($dosenId)
    {
        $status = User::find($dosenId)->status;

        return response()->json($status ?? [
            'status' => 'Tidak Ada',
            'updated_at_iot' => null,
        ]);
    }
}