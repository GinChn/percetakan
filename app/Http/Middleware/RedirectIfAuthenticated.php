<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {

        if (Auth::check() && $request->is('login', 'lupa-password', 'reset-password', 'reset-password*')) {
            return redirect('/dashboard');
        } elseif (Auth::guest() && !$request->is('login', 'lupa-password', 'reset-password*')) {
            return redirect('/');
        }


        return $next($request);
    }
}
