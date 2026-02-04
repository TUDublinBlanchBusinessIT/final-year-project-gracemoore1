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

class LandlordRegisterController extends Controller
{
    public function create()
    {
        return view('auth.landlord-register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // if you later add role column, we’ll set it here
        ]);

        Landlord::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'surname' => $request->surname,
        ]);

        event(new Registered($user)); // triggers email verification if enabled

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}

