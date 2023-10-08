<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Memeriksa apakah pengguna sudah login
        if (auth()->check()) {
            $user = auth()->user();
    
            // Memeriksa apakah pengguna memiliki relasi 'role' dan peran adalah 'Admin'
            if ($user->role && $user->role->name === 'User') {
                return $next($request);
            }
        }
    
        return redirect()->to('/sign-in');
    }
}
