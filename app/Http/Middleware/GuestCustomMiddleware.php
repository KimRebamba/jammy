<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestCustomMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    if (session()->has('user')) {

        if (session('user')->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/home');
    }

    return $next($request);
}
}
