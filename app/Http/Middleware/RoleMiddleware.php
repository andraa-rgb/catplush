<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // kalau belum login → redirect ke login
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // kalau role tidak sesuai → forbidden
        if ($request->user()->role !== $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}