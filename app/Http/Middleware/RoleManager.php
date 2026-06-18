<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Menggunakan Auth Facade sebagai ganti auth() helper
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }
    
        // Redirect unauthorized users to their respective dashboards
        $user = Auth::user();
        $redirectRoute = $user && $user->role === 'admin' ? 'admin.dashboard' : 'karyawan.dashboard';
        return redirect()->route($redirectRoute)->with('error', 'Akses ditolak.');
    }
}
