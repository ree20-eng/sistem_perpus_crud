<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserOnlyMiddleware
{
    /**
     * Halaman ini khusus untuk role 'User'. Admin tidak perlu mengaksesnya
     * (Riwayat Saya & Edit Profil pribadi), karena Admin punya halaman
     * Kelola Peminjaman dan Kelola Akun tersendiri.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            abort(403);
        }

        if (auth()->user()->isAdmin()) {
            abort(403, 'Halaman ini khusus untuk akun User. Admin dapat menggunakan menu Kelola Peminjaman dan Kelola Akun.');
        }

        return $next($request);
    }
}
