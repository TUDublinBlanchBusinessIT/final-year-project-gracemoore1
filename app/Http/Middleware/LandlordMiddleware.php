<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LandlordMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('landlord_id')) {
            return redirect('/login');
        }

        return $next($request);
    }
}