<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): mixed  $next
     * @param  string[]  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // Cek tiap guard (biasanya hanya 'web')
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Kalau sudah login, redirect ke /home (atau /admin sesuai kebutuhanmu)
                return redirect('/admin');
            }
        }

        return $next($request);
    }
}
