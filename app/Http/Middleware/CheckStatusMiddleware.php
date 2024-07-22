<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (!Auth::check()) {
        //     Log::info('Redirection vers login');
        //     return redirect()->route('login');
        // }

        // if (Auth::check() && Auth::user()->status == false) {
        //     Log::info('Redirection vers status.not.approuved');
        //     return redirect()->route('status.not.approuved');
        // }

        return $next($request);
    }
}

