<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

    // Check Student
        $student = \App\Models\Student::where('email', $request->email)->first();
        if ($student && \Illuminate\Support\Facades\Hash::check($request->password, $student->password)) {
            // Optionally check for email/ID verification if you want
            if (!$student->email_verified) {
                return back()->withErrors(['email' => 'Please verify your email before logging in.']);
            }
            if (!$student->id_verified) {
                return back()->withErrors(['email' => 'Your identity has not been verified yet.']);
            }
            $request->session()->put('student_id', $student->id);
            $request->session()->forget('landlord_id');
            return redirect()->route('student.dashboard');
        }

        // Check Landlord
        $landlord = \App\Models\Landlord::where('email', $request->email)->first();
        if ($landlord && \Illuminate\Support\Facades\Hash::check($request->password, $landlord->password)) {
            // If you have similar verification for landlords, add here
            $request->session()->put('landlord_id', $landlord->id);
            $request->session()->forget('student_id');
            return redirect()->route('landlord.dashboard');
        }

        // Not found or wrong password
        return back()->withErrors(['email' => 'Invalid email or password.']);
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
