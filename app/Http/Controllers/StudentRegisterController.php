<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class StudentRegisterController extends Controller
{
    public function showForm() {
        return view('student.register');
    }

    public function register(Request $request) {
        $data = $request->validate([
            'firstname' => 'required',
            'surname' => 'required',
            'dateofbirth' => 'required|date',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $code = rand(1000, 9999); // 4-digit verification code

        session([
            'registration_data' => [
                'firstname' => $data['firstname'],
                'surname' => $data['surname'],
                'dateofbirth' => $data['dateofbirth'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'email_verification_code' => $code
            ]
        ]);

        Mail::raw("Your verification code is: $code", function($m) use ($data) {
            $m->to($data['email'])->subject('Verify your email');
        });

        return redirect('/student/verify-email');
    }

    public function showVerify() {
        return view('student.verify-email');
    }

    public function verifyEmail(Request $request) {
        $request->validate(['code' => 'required|digits:4']);
        $registration = session('registration_data');

        if (!$registration) {
            return back()->withErrors(['code' => 'No registration data found.']);
        }

        if ($request->code != $registration['email_verification_code']) {
            return back()->withErrors(['code' => 'Invalid verification code']);
        }

        // Mark email as verified in session
        $registration['email_verified'] = true;
        session(['registration_data' => $registration]);

        return redirect('/student/verify-id');
    }

    public function showVerifyId() {
        return view('student.verify-id');
    }

    // Accept ocr_text from browser-based OCR, not an image file
    public function verifyId(Request $request)
    {
        $request->validate([
            'ocr_text' => 'required|string',
        ]);

        $registration = session('registration_data');
        if (!$registration || empty($registration['email_verified'])) {
            return redirect('/student/register')->withErrors(['ocr_text' => 'Please complete registration and email verification first.']);
        }

        $text = strtolower($request->input('ocr_text'));

        // Check first name and surname
        $firstnameMatch = str_contains($text, strtolower($registration['firstname']));
        $surnameMatch = str_contains($text, strtolower($registration['surname']));

        // Match dateofbirth loosely (day + year only)
        preg_match_all('/\d{1,2}[\/\-]?[A-Z]{3,9}[\/\-]?\d{4}|\d{2}\/\d{2}\/\d{4}/i', $text, $matches);
        $dobFound = false;
        foreach ($matches[0] as $dateText) {
            $dateTextLower = strtolower($dateText);
            if (stripos($dateTextLower, date('d', strtotime($registration['dateofbirth']))) !== false &&
                stripos($dateTextLower, date('Y', strtotime($registration['dateofbirth']))) !== false) {
                $dobFound = true;
                break;
            }
        }

        if ($firstnameMatch && $surnameMatch && $dobFound) {
            // Only create the student now, if not already created
            $student = Student::where('email', $registration['email'])->first();
            if (!$student) {
                $student = Student::create([
                    'firstname' => $registration['firstname'],
                    'surname' => $registration['surname'],
                    'dateofbirth' => $registration['dateofbirth'],
                    'email' => $registration['email'],
                    'password' => $registration['password'],
                    'email_verification_code' => null,
                    'email_verified' => true,
                ]);
            }
            session()->forget('registration_data');
            session(['student_id' => $student->id]);
            return redirect('/home')->with('success', 'ID verified!');
        }

        return back()->withErrors(['ocr_text' => 'ID verification failed. Make sure your details are clearly visible.']);
    }
}




