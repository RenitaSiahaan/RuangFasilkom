<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PreventAdminAccessToUserRoutes
{
    public function handle($request, Closure $next)
    {
        // Jika user admin, redirect ke dashboard
        if (Auth::check() && Auth::user()->role_id === 1) {
            return redirect()->route('dashboard.index');
        }

        return $next($request); // lanjutkan untuk dosen/mahasiswa
    }
}
