<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentCodeMail;

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

        $code = rand(1000, 9999);

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

        Mail::to($data['email'])->send(new StudentCodeMail($code));
    // ⬆️ END DEBUG BLOCK

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

        if ((string)$request->code !== (string)$registration['email_verification_code']) {
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
        $text_clean = str_replace(['<', ' '], '', $text);

        // Prepare names for matching
        $firstname = strtolower($registration['firstname']);
        $surname = strtolower($registration['surname']);
        $firstname_nospace = str_replace(' ', '', $firstname);
        $surname_nospace = str_replace(' ', '', $surname);

        // Check for first name (with and without spaces, in both text and cleaned text)
        $firstnameMatch =
            str_contains($text, $firstname) ||
            str_contains($text_clean, $firstname) ||
            str_contains($text, $firstname_nospace) ||
            str_contains($text_clean, $firstname_nospace);

        // Check for surname (with and without spaces, in both text and cleaned text)
        $surnameMatch =
            str_contains($text, $surname) ||
            str_contains($text_clean, $surname) ||
            str_contains($text, $surname_nospace) ||
            str_contains($text_clean, $surname_nospace);

        // Fuzzy match if not exact (80% similarity or higher)
        if (!$firstnameMatch) {
            similar_text($firstname, $text, $firstPercent);
            similar_text($firstname, $text_clean, $firstPercentClean);
            similar_text($firstname_nospace, $text, $firstPercentNoSpace);
            similar_text($firstname_nospace, $text_clean, $firstPercentCleanNoSpace);
            $firstnameMatch = max($firstPercent, $firstPercentClean, $firstPercentNoSpace, $firstPercentCleanNoSpace) >= 80;
        }
        if (!$surnameMatch) {
            similar_text($surname, $text, $surPercent);
            similar_text($surname, $text_clean, $surPercentClean);
            similar_text($surname_nospace, $text, $surPercentNoSpace);
            similar_text($surname_nospace, $text_clean, $surPercentCleanNoSpace);
            $surnameMatch = max($surPercent, $surPercentClean, $surPercentNoSpace, $surPercentCleanNoSpace) >= 80;
        }

        // Robust date-of-birth matching for Irish passports and OCR quirks
        $dob = strtotime($registration['dateofbirth']);
        $day = date('d', $dob);
        $year = date('Y', $dob);
        $month = date('M', $dob); // e.g. JAN

        // List of possible month representations (add more if needed)
        $possibleMonths = [
            strtolower($month), // jan
            strtolower(date('F', $dob)), // january
            strtolower(substr($month, 0, 2)), // ja
            'ean', // common OCR error for JAN
            'ian', // another OCR error for JAN
            'jan.', // with dot
            'janua', // partial
            'january', // full
            // Add more if you see other OCR mistakes
        ];

        // Check if day and year are anywhere in the text
        $dayFound = stripos($text, ltrim($day, '0')) !== false || stripos($text, $day) !== false;
        $yearFound = stripos($text, $year) !== false;

        // Check if any possible month representation is in the text
        $monthFound = false;
        foreach ($possibleMonths as $m) {
            if (stripos($text, $m) !== false) {
                $monthFound = true;
                break;
            }
        }

        $dobFound = $dayFound && $monthFound && $yearFound;

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

    public function dashboard() {
        $listings = [];  
        return view('student.dashboard', compact('listings'));
    }
}




