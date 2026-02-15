<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle request.
     * $roles diambil dari parameter route (misal: role:super_admin,admin)
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Cek apakah role user ada di dalam daftar role yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika user memaksa masuk ke halaman yang bukan haknya
        // Redirect dashboard sesuai role agar tidak nyasar
        if ($user->role === 'super_admin' || $user->role === 'admin') {
             return redirect()->route('admin.exams.index')->with('error', 'Akses ditolak.');
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki izin akses.');
    }
}