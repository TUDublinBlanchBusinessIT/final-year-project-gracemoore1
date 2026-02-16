<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Student;
use App\Mail\StudentResetPasswordMail;

class StudentPasswordResetController extends Controller
{
    public function showForgot()
    {
        return view('student.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        dd('SEND RESET LINK FUNCTION IS RUNNING');
        $request->validate(['email' => 'required|email']);

        $student = Student::where('email', $request->email)->first();

        if (!$student) {
            return back()->withErrors(['email' => 'No student found with that email.']);
        }

        $token = Str::random(64);

        DB::table('student_password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        Mail::to($request->email)->send(new StudentResetPasswordMail($token));

        return back()->with('success', 'A password reset link has been emailed to you.');
    }

    public function showResetForm($token)
    {
        return view('student.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        $resetRecord = DB::table('student_password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetRecord) {
            return back()->withErrors(['email' => 'Invalid or expired reset link.']);
        }

        $student = Student::where('email', $request->email)->first();

        if (!$student) {
            return back()->withErrors(['email' => 'Student not found.']);
        }

        $student->password = Hash::make($request->password);
        $student->save();

        DB::table('student_password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Password reset successfully. Please log in.');
    }
}