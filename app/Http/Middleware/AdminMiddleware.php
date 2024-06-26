<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Memeriksa apakah pengguna sudah login
        if (Auth::check()) {
            $user = Auth::user();

            // Memeriksa apakah pengguna memiliki peran 'super-admin'
            if ($user->hasRole('admin') || $user->hasRole('Super-Admin')) {
                return $next($request);
            }
        }

        return redirect()->to('/sign-in');
    }

}
