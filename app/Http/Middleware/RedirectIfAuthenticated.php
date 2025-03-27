<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        if (auth()->check()) {
            return redirect('/home'); // Ganti sesuai halaman yang kamu inginkan
        }

        return $next($request);
    }
}
