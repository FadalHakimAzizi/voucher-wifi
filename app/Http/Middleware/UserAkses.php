<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;          // import Auth facade
use Symfony\Component\HttpFoundation\Response;

class UserAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // jika belum login, redirect ke login user
        if (! Auth::check()) {
            return redirect()->route('user.login');
        }

        // jika role tidak sesuai, kirim 403 atau redirect sesuai kebutuhan
        if (Auth::user()->role !== $role) {
            // opsi A: abort 403
            // abort(403, 'Unauthorized');

            // opsi B: redirect ke dashboard milik role pengguna itu sendiri
            // (bukan dashboard role yang diminta, supaya tidak terjadi redirect berulang)
            $redirectRoute = Auth::user()->role === 'admin'
                ? 'admin.dashboard'
                : 'user.dashboard';

            return redirect()->route($redirectRoute);
        }

        return $next($request);
    }
}
