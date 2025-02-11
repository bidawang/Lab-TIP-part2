<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $email = $request->session()->get('email');
        $role = $request->session()->get('role'); // Pastikan ada session 'role'

        // Cek jika email bukan @politala.ac.id atau role bukan 'developer'
        if (!str_ends_with($email, '@politala.ac.id') || $role !== 'Developer') {
            return redirect()->route('dlaboran')->with('error', 'Akses ditolak: Anda bukan developer atau email tidak valid.');
        }

        return $next($request);
    }
}
