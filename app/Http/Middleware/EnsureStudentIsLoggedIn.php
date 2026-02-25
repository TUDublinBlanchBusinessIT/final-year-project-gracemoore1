<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureStudentIsLoggedIn
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Students authenticate via session('student_id'), not Auth::user()
        if (!session('student_id')) {
            return redirect('/student/login');
        }

        return $next($request);
    }
}