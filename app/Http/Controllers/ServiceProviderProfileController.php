<?php

namespace App\Http\Controllers;

use App\Models\ServiceProviderPartnership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ServiceProviderProfileController extends Controller
{
    /**
     * Show the service provider profile page (read-only details + password form).
     */
    public function show(Request $request)
    {
        $provider = $this->currentProvider();

        return view('serviceprovider.profile', [
            'provider' => $provider,
        ]);
    }

    /**
     * Update the service provider password.
     */
    public function updatePassword(Request $request)
    {
        $provider = $this->currentProvider();

        $request->validate([
            'current_password'      => ['required'],
            'password'              => ['required', 'min:8', 'confirmed'],
        ]);

        // Confirm current password matches
        if (!Hash::check($request->current_password, $provider->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ])->withInput();
        }

        $provider->password = Hash::make($request->password);
        $provider->save();

        return back()->with('status', 'password-updated');
    }

    /**
     * Resolve currently logged-in provider.
     * Supports:
     *  - session('serviceprovider_id') (custom login)
     *  - Auth::id() (if you authenticated providers via Laravel Auth)
     */
    private function currentProvider(): ServiceProviderPartnership
    {
        $id = session('serviceprovider_id');

        if (!$id && Auth::check()) {
            $id = Auth::id();
        }

        abort_unless($id, 403, 'Service provider not authenticated.');

        return ServiceProviderPartnership::findOrFail($id);
    }
}