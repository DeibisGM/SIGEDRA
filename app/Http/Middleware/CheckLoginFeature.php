<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Pennant\Feature;
use Symfony\Component\HttpFoundation\Response;

class CheckLoginFeature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check the feature for the currently authenticated user.
        if (auth()->check() && Feature::for(auth()->user())->inactive('system-login')) {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return response()->view('errors.mantenimiento', [], 503);
        }

        return $next($request);
    }
}
