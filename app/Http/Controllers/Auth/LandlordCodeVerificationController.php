<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PendingLandlord;
use Illuminate\Http\Request;

class LandlordCodeVerificationController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:4',
        ]);

        $pending = PendingLandlord::where('email', $request->email)->first();

        if (!$pending) {
            return back()->withErrors(['email' => 'No pending registration found.']);
        }

        if ($pending->verification_code != $request->code) {
            return back()->withErrors(['code' => 'Incorrect code.']);
        }

        if (now()->greaterThan($pending->code_expires_at)) {
            return back()->withErrors(['code' => 'Code has expired.']);
        }

        
        $pending->email_verified = true;
        $pending->save();

        return redirect()->route('landlord.verify.id', ['email' => $pending->email]);
    }


    public function resend(Request $request)
    {
        $email = $request->email;

        
        $pending = PendingLandlord::where('email', $email)->first();

        if (!$pending) {
            return back()->withErrors(['email' => 'We could not find your registration.']);
        }

        $newCode = rand(1000, 9999);

        
        $pending->update([
            'verification_code' => $newCode,
            'code_expires_at' => now()->addMinutes(10),
        ]);

        
        Mail::to($pending->email)->send(new LandlordVerificationMail($pending));

        return back()->with('success', 'A new code has been sent to your email.');
    }

}
