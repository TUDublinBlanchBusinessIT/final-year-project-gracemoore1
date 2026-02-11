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
    public function store(LoginRequest $request): RedirectResponse
        {
    // This performs the actual login attempt
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

    // Email must be verified
        if (!$user->email_verified_at) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Please verify your email before logging in.',
            ]);
        }

    // OCR must be verified
        if (!$user->ocr_verified) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Your identity has not been verified yet.',
            ]);
        }

        return redirect()->intended(route('dashboard', absolute: false));
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
