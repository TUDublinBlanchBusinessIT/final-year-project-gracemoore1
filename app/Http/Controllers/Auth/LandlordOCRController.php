<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendingLandlord;
use App\Models\Landlord;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LandlordOCRController extends Controller
{
    public function verify(Request $request)
{
    // <<< ADD THIS
    \Log::info('OCR VERIFY ROUTE HIT', [
        'email_received' => $request->email,
        'ocr_text_received' => $request->ocr_text,
    ]);

    $request->validate([
        'email' => 'required|email',
        'ocr_text' => 'required|string',
    ]);

    $pending = PendingLandlord::where('email', $request->email)->first();

    // <<< ADD THIS
    \Log::info('PENDING LOOKUP RESULT', [
        'found' => $pending ? 'YES' : 'NO',
        'email_verified' => $pending->email_verified ?? 'N/A',
    ]);

    if (!$pending || empty($pending->email_verified)) {
        return redirect()->route('landlord.register.show')
            ->withErrors(['ocr_text' => 'Please complete registration and email verification first.']);
    }

    // Clean OCR text
    $text = strtolower($request->input('ocr_text'));

    // <<< ADD THIS
    \Log::info('OCR RAW TEXT', ['text' => $text]);

    $text = preg_replace('/[^a-z0-9\s]/', ' ', $text);
    $text = preg_replace('/\s+/', ' ', $text);

    // Names from registration
    $first = strtolower($pending->first_name);
    $middle = strtolower($pending->middle_name ?? '');
    $surname = strtolower($pending->surname);

    // Combine possible name formats
    $full1 = $first . ' ' . $surname;
    $full2 = $first . ' ' . $middle . ' ' . $surname;
    $full3 = $middle . ' ' . $surname;

    // Helper: fuzzy match function
    function fuzzyMatch($haystack, $needle, $threshold = 60) {
        similar_text($haystack, $needle, $percent);
        return $percent >= $threshold;
    }

    // Check surname (must match strongly)
    $surnameMatch =
        str_contains($text, $surname) ||
        fuzzyMatch($text, $surname, 70);

    // Check first name OR middle name OR full name
    $firstnameMatch =
        str_contains($text, $first) ||
        str_contains($text, $middle) ||
        str_contains($text, $full1) ||
        str_contains($text, $full2) ||
        str_contains($text, $full3) ||
        fuzzyMatch($text, $first, 60) ||
        fuzzyMatch($text, $middle, 60);

    // <<< ADD THIS
    \Log::info('NAME MATCH RESULTS', [
        'firstnameMatch' => $firstnameMatch,
        'surnameMatch' => $surnameMatch,
    ]);

    if ($firstnameMatch && $surnameMatch) {

        // <<< ADD THIS
        \Log::info('OCR MATCH SUCCESS - UPDATING USER', [
            'user_email' => $pending->email
        ]);

        // Create User if not exists
        $user = User::where('email', $pending->email)->first();
        if (!$user) {
            $user = User::create([
                'name' => $pending->first_name . ' ' . $pending->surname,
                'email' => $pending->email,
                'password' => $pending->password,
                'email_verified_at' => now(),
                'ocr_verified' => 1,
            ]);

        } else {
            $user->update([
                'email_verified_at' => now(),
                'ocr_verified' => 1,
            ]);
        }

        // Create Landlord if not exists
        $landlord = Landlord::where('email', $pending->email)->first();
        if (!$landlord) {
            $landlord = Landlord::create([
                'firstname' => $pending->first_name,
                'surname'   => $pending->surname,
                'email'     => $pending->email,
                'phone'     => $pending->phone,
                'password'  => $pending->password,
                'verified'  => 1,
            ]);
        }

        // Clean up pending record
        $pending->delete();

        // Log in and redirect
        Auth::login($user);

        return redirect('/dashboard')->with('welcome', 'Registration complete! Welcome ' . $pending->first_name . '!');
    }

    return back()->withErrors([
        'ocr_text' => 'ID verification failed. Please ensure your ID is upright (not sideways) and that all text is clearly visible.',
    ]);
}

}
