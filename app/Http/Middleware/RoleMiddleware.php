<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // cek sudah login atau belum
        if (!auth()->check()) {
            return redirect('/login');
        }

        // ambil nama role user (dari relasi)
        $userRole = auth()->user()->role->name;

        // cek apakah role user diizinkan
        if (!in_array($userRole, $roles)) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES');
        }

        return $next($request);
    }
}
