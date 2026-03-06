<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class RejectSuspended
{
    public function handle($request, Closure $next)
    {
        // STUDENT
        if (session('student_id')) {
            $status = DB::table('student')
                ->where('id', session('student_id'))
                ->value('status');
            $status = strtolower(trim((string) $status));
            if ($status === 'suspended') {
                session()->flush();
                return redirect()->route('login')
                    ->withErrors(['email' => 'Account is suspended - for enquiries contact rentconnect.app@gmail.com']);
            }
        }

        // LANDLORD
        if (session('landlord_id')) {
            $status = DB::table('landlord')
                ->where('id', session('landlord_id'))
                ->value('status');
            $status = strtolower(trim((string) $status));
            if ($status === 'suspended') {
                session()->flush();
                return redirect()->route('login')
                    ->withErrors(['email' => 'Account is suspended - for enquiries contact rentconnect.app@gmail.com']);
            }
        }

        // SERVICE PROVIDER
        if (session('serviceprovider_id')) {
            $status = DB::table('serviceproviderpartnership')
                ->where('id', session('serviceprovider_id'))
                ->value('status');
            $status = strtolower(trim((string) $status));
            if ($status === 'suspended') {
                session()->flush();
                return redirect()->route('login')
                    ->withErrors(['email' => 'Account is suspended - for enquiries contact rentconnect.app@gmail.com']);
            }
        }

        // Admins are not suspended by policy — no check for admin_id.

        return $next($request);
    }
}