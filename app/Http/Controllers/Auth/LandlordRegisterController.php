<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Landlord;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Log;
use App\Models\PendingLandlord;
use App\Mail\LandlordVerificationCodeMail;
use Illuminate\Support\Facades\Mail;



class LandlordRegisterController extends Controller
{
    public function create()
    {
        return view('auth.landlord-register');
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:pending_landlords,email'],
            'phone' => ['required', 'regex:/^[0-9]{7,15}$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Generate 4-digit verification code
        $code = rand(1000, 9999);

        // Save to pending_landlords table
        $pending = PendingLandlord::create([
            'first_name' => $request->first_name,
            'surname' => $request->surname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'verification_code' => $code,
            'code_expires_at' => now()->addMinutes(10),
        ]);

        // Send verification email
        Mail::to($pending->email)->send(new LandlordVerificationCodeMail($code));

        // Redirect to the 4-digit code entry page
        return redirect()->route('landlord.verify.email', ['email' => $pending->email]);
    }
}



