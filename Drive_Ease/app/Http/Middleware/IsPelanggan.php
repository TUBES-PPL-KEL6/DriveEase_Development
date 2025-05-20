<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsPelanggan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    if (auth()->user()?->role !== 'pelanggan') {
        abort(403, 'Akses hanya untuk user/pelanggan');
    }

    return $next($request);
}

}
