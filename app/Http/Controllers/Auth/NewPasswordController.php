<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email // Pass the email to the view
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

    // Student
        $reset = \Illuminate\Support\Facades\DB::table('student_password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();
        if ($reset) {
            $student = \App\Models\Student::where('email', $request->email)->first();
            if ($student) {
                $student->password = \Illuminate\Support\Facades\Hash::make($request->password);
                $student->save();
                \Illuminate\Support\Facades\DB::table('student_password_resets')->where('email', $request->email)->delete();
                return redirect()->route('login')->with('status', 'Password reset successfully. Please log in.');
            }
     }

    // Default for landlords (NO CHANGE)
        $status = \Illuminate\Support\Facades\Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                    'remember_token' => \Illuminate\Support\Str::random(60),
                ])->save();

                event(new \Illuminate\Auth\Events\PasswordReset($user));
            }
        );

        return $status == \Illuminate\Support\Facades\Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
