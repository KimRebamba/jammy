<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    if (!session()->has('user')) {
        return redirect('/login')->with('error', 'You do not have access to the admin panel');
    }

    if (session('user')->role !== 'admin') {
        return redirect('/login')->with('error', 'You do not have access to the admin panel');
    }

    return $next($request);
}
}
