<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Construct - Check if user is admin
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->role === 'admin') {
                return $next($request);
            }
            return redirect('/')->with('error', 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        });
    }

    /**
     * Dashboard admin - list dosen
     */
    public function dashboard()
    {
        $dosens = User::whereIn('role', ['staf', 'kepala_lab'])
            ->withCount('jadwals', 'bookings')
            ->get();

        $stats = [
            'total_dosens' => $dosens->count(),
            'total_jadwals' => $dosens->sum('jadwals_count'),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'total_users' => User::count(),
        ];

        return view('admin.dashboard', compact('dosens', 'stats'));
    }

    /**
     * Create new dosen form
     */
    public function createDosen()
    {
        return view('admin.create-dosen');
    }

    /**
     * Store new dosen
     */
    public function storeDosen(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nip' => 'nullable|string|unique:users,nip',
            'role' => 'required|in:staf,kepala_lab',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Akun dosen berhasil ditambahkan');
    }

    /**
     * Edit dosen form
     */
    public function editDosen($id)
    {
        $dosen = User::findOrFail($id);
        
        // Pastikan yang diedit adalah dosen, bukan admin
        if (!in_array($dosen->role, ['staf', 'kepala_lab'])) {
            return redirect()->route('admin.dashboard')->with('error', 'User ini bukan dosen');
        }

        return view('admin.edit-dosen', compact('dosen'));
    }

    /**
     * Update dosen details
     */
    public function updateDosen(Request $request, $id)
    {
        $dosen = User::findOrFail($id);

        // Pastikan yang diedit adalah dosen
        if (!in_array($dosen->role, ['staf', 'kepala_lab'])) {
            return redirect()->route('admin.dashboard')->with('error', 'User ini bukan dosen');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'nip' => 'nullable|string|unique:users,nip,' . $id,
            'role' => 'required|in:staf,kepala_lab',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validated['password'] ?? null) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $dosen->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Detail dosen berhasil diperbarui');
    }

    /**
     * Delete dosen
     */
    public function deleteDosen($id)
    {
        $dosen = User::findOrFail($id);

        // Pastikan yang dihapus adalah dosen
        if (!in_array($dosen->role, ['staf', 'kepala_lab'])) {
            return redirect()->route('admin.dashboard')->with('error', 'User ini bukan dosen');
        }

        // Delete related data
        $dosen->jadwals()->delete();
        $dosen->bookings()->delete();
        $dosen->status()->delete();
        $dosen->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Akun dosen berhasil dihapus');
    }
}
