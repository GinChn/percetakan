<?php 

// app/Http/Middleware/DisableDashboardCache.php

namespace App\Http\Middleware;

use Closure;

class DisableDashboardCache
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Add Cache-Control header to disable caching for dashboard
        if (auth()->check() && $request->is('dashboard')) {
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
        }

        return $response;
    }
}
