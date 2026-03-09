<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentCodeMail;
use App\Models\LandlordRental;
use App\Models\Application;
use Illuminate\Support\Facades\Log;

class StudentRegisterController extends Controller
{
    public function showForm() {
        return view('student.register');
    }

    public function register(Request $request) {
        //  Allowlist of Irish HEI domains (annotated with institution names)
        $allowedEduDomainsIE = [
            'ucd.ie', 'ucdconnect.ie',
            'mu.ie',
            'dcu.ie', 'mail.dcu.ie',
            'mumail.ie',
            'ul.ie',
            'nuigalway.ie', 'universityofgalway.ie',
            'ucc.ie',
            'tcd.ie',
            'rcsi.ie',
            'setu.ie', 'itcarlow.ie',
            'mtu.ie', 'ittralee.ie',
            'dkit.ie',
            'itsligo.ie', 'gmit.ie', 'lyit.ie', 'atu.ie',
            'ait.ie', 'lit.ie', 'tus.ie',
            'ncirl.ie',
            'ncad.ie',
            'iadt.ie',
            'mie.ie',
            'riam.ie',
            'carlowcollege.ie',
            'ipa.ie',
            'mytudublin.ie', 'tudublin.ie',
        ];

        $data = $request->validate([
            'firstname'   => 'required',
            'surname'     => 'required',
            'dateofbirth' => 'required|date',
            // College email validation only
            'email' => ['required','email', function($attribute, $value, $fail) use ($allowedEduDomainsIE) {
                $domain = strtolower(substr(strrchr($value, "@"), 1) ?: '');
                $parts  = explode('.', $domain);
                $base   = implode('.', array_slice($parts, -2)); // "mail.tcd.ie" -> "tcd.ie"
                if (!in_array($base, $allowedEduDomainsIE)) {
                    $fail('Please use your university email address.');
                }
            }],
            'password' => 'required|confirmed|min:6',
        ]);

        $code = rand(1000, 9999);

        Log::info('Student email verification code generated', [
            'email' => $data['email'],
            'code'  => $code,
        ]);

        session([
            'registration_data' => [
                'firstname'               => $data['firstname'],
                'surname'                 => $data['surname'],
                'dateofbirth'             => $data['dateofbirth'],
                'email'                   => $data['email'],
                'password'                => Hash::make($data['password']),
                'email_verification_code' => $code
            ]
        ]);

        Mail::to($data['email'])->send(new StudentCodeMail($code));

        return redirect('/student/verify-email');
    }

    /*** SHOW EMAIL VERIFICATION PAGE (GET) ***/
    public function showVerify() {
        return view('student.verify-email');
    }

    /*** HANDLE EMAIL VERIFICATION CODE (POST) ***/
    public function verifyEmail(Request $request) {
        $request->validate(['code' => 'required|digits:4']);
        $registration = session('registration_data');

        if (!$registration) {
            return back()->withErrors(['code' => 'No registration data found.']);
        }

        if ((string)$request->code !== (string)$registration['email_verification_code']) {
            return back()->withErrors(['code' => 'Invalid verification code']);
        }

        $registration['email_verified'] = true;
        session(['registration_data' => $registration]);

        return redirect('/student/verify-id');
    }

    /*** SHOW ID VERIFICATION PAGE (GET) ***/
    public function showVerifyId() {
        return view('student.verify-id');
    }

    /**
     * HANDLE ID OCR VERIFICATION (POST)
     * Names-only verification (DOB removed).
     * - Accent-insensitive, fuzzy, and MRZ support
     */
    public function verifyId(Request $request)
    {
        $request->validate([
            'ocr_text' => 'required|string',
        ]);

        $registration = session('registration_data');
        if (!$registration || empty($registration['email_verified'])) {
            return redirect('/student/register')->withErrors([
                'ocr_text' => 'Please complete registration and email verification first.',
            ]);
        }

        // ---- OCR text in multiple forms ----
        $rawOcr     = (string)$request->input('ocr_text', '');
        $text       = mb_strtolower($rawOcr, 'UTF-8');       // raw lowercase
        $text_clean = str_replace(['<', ' '], '', $text);    // historical clean

        // Irish transliteration BEFORE iconv; keep letters+digits only to handle fadas robustly
        $norm_ie = function ($s) {
            $s = strtr($s, [
                'Á'=>'A','É'=>'E','Í'=>'I','Ó'=>'O','Ú'=>'U',
                'á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u',
            ]);
            $s = mb_strtolower((string)$s, 'UTF-8');
            $x = @iconv('UTF-8', 'ASCII//TRANSLIT', $s);
            if ($x === false || $x === null) $x = $s;
            return preg_replace('/[^a-z0-9]/', '', $x); // keep a-z0-9 only
        };

        $text_norm = $norm_ie($rawOcr);

        // ---- Name matching only (DOB removed) ----
        $firstname = mb_strtolower($registration['firstname'], 'UTF-8');
        $surname   = mb_strtolower($registration['surname'], 'UTF-8');

        $firstname_nospace = str_replace(' ', '', $firstname);
        $surname_nospace   = str_replace(' ', '', $surname);

        // Accentless variants for names too (so Ó/á/etc. match even if OCR is inconsistent)
        $firstname_norm = $norm_ie($firstname);
        $surname_norm   = $norm_ie($surname);

        // Exact/substring checks across multiple text forms
        $firstnameMatch =
            str_contains($text, $firstname) ||
            str_contains($text_clean, $firstname_nospace) ||
            ($firstname_norm !== '' && strpos($text_norm, $firstname_norm) !== false);

        $surnameMatch =
            str_contains($text, $surname) ||
            str_contains($text_clean, $surname_nospace) ||
            ($surname_norm !== '' && strpos($text_norm, $surname_norm) !== false);

        // Fuzzy backups if still not matched
        if (!$firstnameMatch) {
            $firstPercent = $firstPercentClean = $firstPercentNoSpace = $firstPercentCleanNoSpace = $firstPercentNorm = 0.0;
            similar_text($firstname, $text, $firstPercent);
            similar_text($firstname, $text_clean, $firstPercentClean);
            similar_text($firstname_nospace, $text, $firstPercentNoSpace);
            similar_text($firstname_nospace, $text_clean, $firstPercentCleanNoSpace);
            similar_text($firstname_norm, $text_norm, $firstPercentNorm);
            $firstnameMatch = max(
                (float)$firstPercent,
                (float)$firstPercentClean,
                (float)$firstPercentNoSpace,
                (float)$firstPercentCleanNoSpace,
                (float)$firstPercentNorm
            ) >= 80.0;
        }

        if (!$surnameMatch) {
            $surPercent = $surPercentClean = $surPercentNoSpace = $surPercentCleanNoSpace = $surPercentNorm = 0.0;
            similar_text($surname, $text, $surPercent);
            similar_text($surname, $text_clean, $surPercentClean);
            similar_text($surname_nospace, $text, $surPercentNoSpace);
            similar_text($surname_nospace, $text_clean, $surPercentCleanNoSpace);
            similar_text($surname_norm, $text_norm, $surPercentNorm);
            $surnameMatch = max(
                (float)$surPercent,
                (float)$surPercentClean,
                (float)$surPercentNoSpace,
                (float)$surPercentCleanNoSpace,
                (float)$surPercentNorm
            ) >= 80.0;
        }

        // ---- Optional MRZ augment (kept): helps when the readable zone is poor but MRZ is good ----
        $mrzFirstMatches = false;
        $mrzSurnameMatches = false;
        (function() use ($request, $registration, &$mrzFirstMatches, &$mrzSurnameMatches) {
            $raw  = strtoupper($request->input('ocr_text'));
            $norm = preg_replace('/[^A-Z0-9<\n]/', '', $raw);
            $lines = array_values(array_filter(array_map('trim', explode("\n", $norm))));
            if (count($lines) === 0) return;

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

            $firstFromMrz = $givenTokens[0];
            $surFromMrz   = str_replace('<','', $surnameRaw);

            $userFirst = strtoupper($registration['firstname']);
            $userSur   = strtoupper($registration['surname']);

            $mrzFirstMatches   = ($firstFromMrz === $userFirst) || (strpos($firstFromMrz, $userFirst) === 0);
            $mrzSurnameMatches = ($surFromMrz === $userSur) || (strpos($surFromMrz, $userSur) !== false);
        })();

        // Final decision: names only
        $firstnameMatch = $firstnameMatch || $mrzFirstMatches;
        $surnameMatch   = $surnameMatch   || $mrzSurnameMatches;

        if ($firstnameMatch && $surnameMatch) {
            // Create/update student & mark ID verified
            $student = Student::where('email', $registration['email'])->first();
            if (!$student) {
                $student = Student::create([
                    'firstname'               => $registration['firstname'],
                    'surname'                 => $registration['surname'],
                    'dateofbirth'             => $registration['dateofbirth'], // kept in profile
                    'email'                   => $registration['email'],
                    'password'                => $registration['password'],     // already hashed
                    'email_verification_code' => null,
                    'email_verified'          => true,
                    'id_verified'             => true,
                ]);
            } else {
                $student->update(['id_verified' => true]);
            }

            session()->forget('registration_data');
            session(['student_id' => $student->id]);

            return redirect('/home')->with('success', 'ID verified!');
        }

        // Helpful debug (no raw OCR stored). Confirms DOB is disabled now.
        Log::debug('Student ID verification failed (names only, DOB check disabled)', [
            'email'           => $registration['email'] ?? null,
            'ocr_sha256'      => hash('sha256', $rawOcr),
            'firstnameMatch'  => $firstnameMatch,
            'surnameMatch'    => $surnameMatch,
        ]);

        return back()->withErrors([
            'ocr_text' => 'ID verification failed. Make sure your name is clearly visible.',
        ]);
    }

    public function dashboard(Request $request) {
        if (!session()->has('student_id')) {
            return redirect('/login');
        }

        $student = \App\Models\Student::find(session('student_id'));

        $q                 = trim((string) $request->query('q', ''));
        $county            = trim((string) $request->query('county', ''));
        $housetype         = $request->query('housetype');
        $accommodationType = $request->query('accommodation_type');
        $applicationType   = $request->query('application_type');
        $fromDate          = $request->query('from');
        $untilDate         = $request->query('until');
        $minRent           = $request->query('min_rent');
        $maxRent           = $request->query('max_rent');
        $nightsBucket      = $request->query('nights_bucket');

        $query = \App\Models\LandlordRental::query()
            ->join('landlord', 'landlord.id', '=', 'rental.landlordid')
            ->where('landlord.status', 'active')
            ->where('rental.status', 'available')
            ->select('rental.*');

        if ($q !== '') {
            $like = '%' . str_replace('%', '\%', $q) . '%';
            $query->where(function ($sub) use ($like) {
                $sub->where('rental.street', 'like', $like)
                    ->orWhere('rental.county', 'like', $like)
                    ->orWhere('rental.postcode', 'like', $like)
                    ->orWhere('rental.description', 'like', $like);
            });
        }

        if ($county !== '') {
            $query->where('rental.county', $county);
        }

        if ($housetype !== null && $housetype !== '' && $housetype !== 'any') {
            $allowed = ['any','single_private','private_shared','whole_property_group'];
            if (in_array($housetype, $allowed, true)) {
                $query->where('rental.housetype', $housetype);
            }
        }

        if ($accommodationType !== null && $accommodationType !== '') {
            $allowed = ['house','apartment'];
            if (in_array($accommodationType, $allowed, true)) {
                $query->where('rental.accommodation_type', $accommodationType);
            }
        }

        if ($applicationType !== null && $applicationType !== '') {
            $allowed = ['single','group'];
            if (in_array($applicationType, $allowed, true)) {
                $query->where('rental.application_type', $applicationType);
            }
        }

        // DATE OVERLAP
        if ($fromDate && $untilDate) {
            $query->whereDate('rental.availablefrom', '<=', $untilDate)
                ->whereDate('rental.availableuntil', '>=', $fromDate);
        } elseif ($fromDate) {
            $query->whereDate('rental.availableuntil', '>=', $fromDate);
        } elseif ($untilDate) {
            $query->whereDate('rental.availablefrom', '<=', $untilDate);
        }

        if ($minRent !== null && $minRent !== '') {
            $query->where('rental.rentpermonth', '>=', (float)$minRent);
        }
        if ($maxRent !== null && $maxRent !== '') {
            $query->where('rental.rentpermonth', '<=', (float)$maxRent);
        }

        if ($nightsBucket && $nightsBucket !== 'any') {
            switch ($nightsBucket) {
                case '1-3':
                    $query->whereRaw('CAST(rental.nightsperweek AS UNSIGNED) BETWEEN 1 AND 3');
                    break;
                case '4-5':
                    $query->whereRaw('CAST(rental.nightsperweek AS UNSIGNED) BETWEEN 4 AND 5');
                    break;
                case '6-7':
                    $query->whereRaw('CAST(rental.nightsperweek AS UNSIGNED) BETWEEN 6 AND 7');
                    break;
            }
        }

        $listings = $query->orderByDesc('rental.id')->get();

        return view('student.dashboard', compact('listings', 'student'));
    }
    
    public function showListing($id)
    {
        if (!session()->has('student_id')) {
            return redirect('/login');
        }

        $rental = \App\Models\LandlordRental::findOrFail($id);

        return view('student.listing-show', compact('rental'));
    }

    public function studentProfile()
    {
        if (!session()->has('student_id')) return redirect('/student/login');
        return view('student.profile-new');
    }

    public function studentProfileApplications()
    {
        if (!session()->has('student_id')) {
            return redirect('/student/login');
        }

        $student = Student::find(session('student_id'));
        $myId    = $student->id;
        $myEmail = strtolower(trim($student->email));

        $pattern = '"email"[[:space:]]*:[[:space:]]*"'.$myEmail.'"';

        $pending = Application::with('rental')
            ->where(function ($q) use ($myId, $pattern) {
                $q->where('studentid', $myId)
                  ->orWhereRaw('LOWER(group_members) REGEXP ?', [$pattern]);
            })
            ->where('status','pending')
            ->orderByDesc('dateapplied')
            ->get();

        $accepted = Application::with('rental')
            ->where(function ($q) use ($myId, $pattern) {
                $q->where('studentid', $myId)
                  ->orWhereRaw('LOWER(group_members) REGEXP ?', [$pattern]);
            })
            ->where('status','accepted')
            ->orderByDesc('dateapplied')
            ->get();

        $rejected = Application::with('rental')
            ->where(function ($q) use ($myId, $pattern) {
                $q->where('studentid', $myId)
                  ->orWhereRaw('LOWER(group_members) REGEXP ?', [$pattern]);
            })
            ->where('status','rejected')
            ->orderByDesc('dateapplied')
            ->get();

        return view('student.profile-applications', compact('pending','accepted','rejected'));
    }

    public function studentProfileAccount()
    {
        if (!session()->has('student_id')) return redirect('/student/login');

        $student = Student::find(session('student_id'));
        return view('student.profile-account', compact('student'));
    }
    
    public function studentResetPassword(Request $request)
    {
        if (!session()->has('student_id')) {
            return redirect('/student/login');
        }

        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', 'min:6'],
        ]);

        $student = Student::find(session('student_id'));
        if (!$student) {
            return back()->withErrors(['current_password' => 'Student not found.']);
        }

        if (!Hash::check($request->input('current_password'), $student->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $student->password = Hash::make($request->input('password'));
        $student->save();

        $request->session()->regenerate();

        return back()->with('status', 'password-updated');
    }

    public function studentDeleteAccount()
    {
        if (!session()->has('student_id')) return redirect('/student/login');

        $student = Student::find(session('student_id'));
        if ($student) {
            $student->delete();
        }
        session()->forget('student_id');

        return redirect('/')->with('success', 'Account deleted.');
    }
}