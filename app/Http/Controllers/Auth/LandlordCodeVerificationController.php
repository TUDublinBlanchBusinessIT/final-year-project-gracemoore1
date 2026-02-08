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
}
