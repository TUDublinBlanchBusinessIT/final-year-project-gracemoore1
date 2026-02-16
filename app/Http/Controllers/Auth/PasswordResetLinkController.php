<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email']);

    // Check Student
        $student = \App\Models\Student::where('email', $request->email)->first();
        if ($student) {
            $token = \Illuminate\Support\Str::random(64);
            \Illuminate\Support\Facades\DB::table('student_password_resets')->updateOrInsert(
                ['email' => $request->email],
                ['email' => $request->email, 'token' => $token, 'created_at' => now()]
            );
            \Illuminate\Support\Facades\Mail::to($request->email)->send(new \App\Mail\StudentResetPasswordMail($token));
            return back()->with('status', 'A password reset link has been emailed to you.');
        }

    // Default for landlords (NO CHANGE)
        $status = \Illuminate\Support\Facades\Password::sendResetLink(
            $request->only('email')
        );

        return $status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
