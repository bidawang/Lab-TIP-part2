<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Pastikan pengguna telah login
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Memeriksa apakah level pengguna termasuk dalam daftar roles yang diizinkan
        if (!in_array($user->level, $roles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
