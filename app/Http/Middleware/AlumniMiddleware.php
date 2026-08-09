<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlumniMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('alumni_login')) {
            return redirect()->route('alumni.login');
        }

        return $next($request);
    }
}