<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SuperAdminController extends Controller
{
    // 1. Daftar Semua User
    public function index()
    {
        // PERBAIKAN DI SINI:
        // Cukup gunakan Auth::id()
        $users = User::where('id', '!=', Auth::id())
                     ->orderByRaw("CASE 
                        WHEN role = 'super_admin' THEN 1 
                        WHEN role = 'admin' THEN 2 
                        ELSE 3 END")
                     ->latest()
                     ->get();

        return view('super.users.index', compact('users'));
    }

    // 2. Form Tambah User Baru
    public function create()
    {
        return view('super.users.create');
    }

    // 3. Simpan User Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:super_admin,admin,student',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('super.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    // 4. Form Edit User
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('super.users.edit', compact('user'));
    }

    // 5. Update User
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:super_admin,admin,student',
        ]);

        // Update data dasar
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('super.users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    // 6. Hapus User
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Proteksi ganda (Server Side)
        if ($user->role === 'super_admin') {
            return back()->with('error', 'Demi keamanan, Super Admin tidak bisa dihapus sembarangan.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}