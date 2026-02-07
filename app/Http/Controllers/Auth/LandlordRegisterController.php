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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email', 'unique:landlord,email'],
            'phone' => ['required', 'regex:/^[0-9]{7,15}$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        Log::info('Before login, Auth check:', ['auth' => Auth::check()]);


        $user = User::create([
            'name' => $request->first_name . ' ' . $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Landlord::create([
            'firstname' => $request->first_name,
            'surname'   => $request->surname,
            'email'     => $request->email,
            'phone' => $request->phone,
            'password'  => Hash::make($request->password),
            'verified'  => 0,
        ]);


       event(new Registered($user));

        Auth::login($user);
        Log::info('After login, Auth check:', ['auth' => Auth::check()]);

        //Log::info('Landlord registered + logged in', [
            //'user_id' => $user->id,
            //'auth_check' => Auth::check(),
        //]);

        return view('auth.verify-email');

 
    }}

