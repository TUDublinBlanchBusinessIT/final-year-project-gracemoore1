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
        // ✅ Allowlist of Irish HEI domains (annotated with institution names)
        $allowedEduDomainsIE = [
            'ucd.ie',               // University College Dublin (UCD)
            'ucdconnect.ie',        // University College Dublin — Student Email

            'mu.ie',                // Maynooth University (MU)

            'dcu.ie',               // Dublin City University (DCU)

            'ul.ie',                // University of Limerick (UL)

            'nuigalway.ie',         // National University of Ireland, Galway (legacy)
            'universityofgalway.ie',// University of Galway (current)

            'ucc.ie',               // University College Cork (UCC)

            'tcd.ie',               // Trinity College Dublin (TCD)

            'rcsi.ie',              // Royal College of Surgeons in Ireland (RCSI)

            'setu.ie',              // South East Technological University (SETU)
            'itcarlow.ie',          // IT Carlow (legacy, now part of SETU)

            'mtu.ie',               // Munster Technological University (MTU)
            'ittralee.ie',          // IT Tralee (legacy, now part of MTU)

            'dkit.ie',              // Dundalk Institute of Technology (DKIT)

            'itsligo.ie',           // IT Sligo (legacy, now ATU)
            'gmit.ie',              // Galway-Mayo Institute of Technology (legacy, now ATU)
            'lyit.ie',              // Letterkenny Institute of Technology (legacy, now ATU)
            'atu.ie',               // Atlantic Technological University (ATU)

            'ait.ie',               // Athlone Institute of Technology (legacy, now TUS)
            'lit.ie',               // Limerick Institute of Technology (legacy, now TUS)
            'tus.ie',               // Technological University of the Shannon (TUS)

            'ncirl.ie',             // National College of Ireland (NCI)

            'ncad.ie',              // National College of Art and Design (NCAD)

            'iadt.ie',              // IADT Dún Laoghaire (Institute of Art, Design and Technology)

            'mie.ie',               // Marino Institute of Education (MIE)

            'riam.ie',              // Royal Irish Academy of Music (RIAM)

            'carlowcollege.ie',     // Carlow College (St. Patrick’s)

            'ipa.ie',               // Institute of Public Administration (IPA)

            'mytudublin.ie',        // Technological University Dublin (TUD) — Student Email
            'tudublin.ie',          // Technological University Dublin (TUD)
        ];

        $data = $request->validate([
            'firstname' => 'required',
            'surname' => 'required',
            'dateofbirth' => 'required|date',
            // ✅ College email check — ONLY affects validation; no other behavior changes
            'email' => ['required','email', function($attribute, $value, $fail) use ($allowedEduDomainsIE) {
                $domain = strtolower(substr(strrchr($value, "@"), 1) ?: '');
                // Reduce to base (eTLD+1) simply: e.g. "mail.tcd.ie" -> "tcd.ie"
                $parts = explode('.', $domain);
                $base = implode('.', array_slice($parts, -2));
                if (!in_array($base, $allowedEduDomainsIE)) {
                    $fail('Please use your university email address.');
                }
            }],
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

        // Mark email as verified in session (unchanged)
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

        // Prepare names for matching (existing logic)
        $firstname = strtolower($registration['firstname']);
        $surname = strtolower($registration['surname']);
        $firstname_nospace = str_replace(' ', '', $firstname);
        $surname_nospace = str_replace(' ', '', $surname);

        // Exact/substring checks (existing logic)
        $firstnameMatch =
            str_contains($text, $firstname) ||
            str_contains($text_clean, $firstname) ||
            str_contains($text, $firstname_nospace) ||
            str_contains($text_clean, $firstname_nospace);

        $surnameMatch =
            str_contains($text, $surname) ||
            str_contains($text_clean, $surname) ||
            str_contains($text, $surname_nospace) ||
            str_contains($text_clean, $surname_nospace);

        // ✅ Minimal MRZ-based matching (first given-name token only; middle name optional)
        // This augments your existing checks; it doesn't replace them.
        $mrzFirstMatches = false;
        $mrzSurnameMatches = false;
        (function() use ($request, $registration, &$mrzFirstMatches, &$mrzSurnameMatches) {
            $raw = strtoupper($request->input('ocr_text'));
            // Keep only characters typical in MRZ
            $norm = preg_replace('/[^A-Z0-9<\n]/', '', $raw);
            $lines = array_values(array_filter(array_map('trim', explode("\n", $norm))));
            if (count($lines) === 0) return;

            // Look for SURNAME<<GIVEN<NAMES>
            $line1 = null;
            foreach ($lines as $ln) {
                if (strpos($ln, '<<') !== false) { $line1 = $ln; break; }
            }
            if (!$line1) return;

            $parts = explode('<<', $line1, 2);
            if (count($parts) < 2) return;

            $surnameRaw = $parts[0];        // e.g., OBRIEN
            $givenRaw   = $parts[1];        // e.g., JOHN<PAUL
            $givenTokens = array_values(array_filter(explode('<', $givenRaw)));
            if (!$givenTokens) return;

            $firstFromMrz = $givenTokens[0]; // ONLY the first given name
            $surFromMrz   = str_replace('<','', $surnameRaw);

            $userFirst = strtoupper($registration['firstname']);
            $userSur   = strtoupper($registration['surname']);

            // exact or prefix/substring tolerance (OCR may merge tokens)
            $mrzFirstMatches   = ($firstFromMrz === $userFirst) || (strpos($firstFromMrz, $userFirst) === 0);
            $mrzSurnameMatches = ($surFromMrz === $userSur) || (strpos($surFromMrz, $userSur) !== false);
        })();

        // Fuzzy match if not exact (existing logic)
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

        // ✅ Incorporate MRZ-derived matches so first name alone is enough
        $firstnameMatch = $firstnameMatch || $mrzFirstMatches;
        $surnameMatch   = $surnameMatch   || $mrzSurnameMatches;

        // Robust date-of-birth matching (existing logic)
        $dob = strtotime($registration['dateofbirth']);
        $day = date('d', $dob);
        $year = date('Y', $dob);
        $month = date('M', $dob); // e.g. JAN

        $possibleMonths = [
            strtolower($month), // jan
            strtolower(date('F', $dob)), // january
            strtolower(substr($month, 0, 2)), // ja
            'ean', // common OCR error for JAN
            'ian',
            'jan.',
            'janua',
            'january',
        ];

        $dayFound = stripos($text, ltrim($day, '0')) !== false || stripos($text, $day) !== false;
        $yearFound = stripos($text, $year) !== false;

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
                    // Your existing behavior: email was verified earlier in session
                    'email_verified' => true,
                    // ✅ Set ID verified only after OCR success
                    'id_verified' => true,
                ]);
            } else {
                // ✅ If a record exists, mark ID as verified now (no other logic changes)
                $student->update([
                    'id_verified' => true,
                ]);
            }
            session()->forget('registration_data');
            session(['student_id' => $student->id]);
            return redirect('/home')->with('success', 'ID verified!');
        }

        return back()->withErrors(['ocr_text' => 'ID verification failed. Make sure your details are clearly visible.']);
    }

    public function dashboard() {
        if (!session()->has('student_id')) {
            return redirect('/login');
        }
        $listings = [];  
        return view('student.dashboard', compact('listings'));
    }
}




