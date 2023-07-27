<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekRole
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
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            $userRole = $user->level->nama_level;

            // Check if the user's role is in the allowed roles
            if (in_array($userRole, $roles)) {
                // Add headers to disable caching
                $response = $next($request);
                $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
                $response->headers->set('Pragma', 'no-cache');
                $response->headers->set('Expires', '0');
                return $response;
            }
        }

        // If the user does not have the required role, redirect to the login page
        return redirect('login');
    }
}
