<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthFilament
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // middleware for filament user UserFilament model
        if (!auth()->guard('filament')->check()) {
            return redirect()->route('filament.filament.auth.login');
        }
        return $next($request);
    }
}
