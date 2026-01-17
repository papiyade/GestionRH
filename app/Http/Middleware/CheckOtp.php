<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckOtp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role === 'rh') {

            if (!session('otp_verified')) {

                // Mémoriser la route cible
                session(['otp_target_route' => $request->url()]);

                return redirect()->route('otp.request');
            }
        }
        return $next($request);
    }
}
