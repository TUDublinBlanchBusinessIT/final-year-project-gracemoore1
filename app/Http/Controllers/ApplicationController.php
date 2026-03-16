<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Models\LandlordRental;
use App\Models\Application;
use App\Models\Student;
use App\Models\Group;

class ApplicationController extends Controller
{
    /**
     * Show the application selection form (Single or Group).
     * Route: GET /applications/start/{listing}/{type}
     */
    public function start($listing, $type)
    {
        if (!session('student_id')) {
            return redirect('/student/login');
        }

        $student = Student::find(session('student_id'));
        $rental  = LandlordRental::findOrFail($listing);

        if (!in_array($type, ['single', 'group'], true)) {
            abort(404);
        }

        // Only needed for the group flow – populate "Use existing group" dropdown
        $existingGroups = collect();
        if ($type === 'group') {
            $existingGroups = Group::with(['members:id,firstname,surname,email'])
                ->whereHas('members', function ($q) use ($student) {
                    $q->where('student_id', $student->id);
                })
                ->orderByDesc('id')
                ->get();
        }

        return view('applications.start-' . $type, [
            'rental'         => $rental,
            'student'        => $student,
            'type'           => $type,
            'existingGroups' => $existingGroups,
        ]);
    }

    /**
     * Store Single Application
     * Route: POST /applications/submit/single/{listing}
     */
    public function submitSingle(Request $request, $listing)
    {
        if (!session('student_id')) {
            return redirect('/student/login');
        }

        $student = Student::find(session('student_id'));
        $rental  = LandlordRental::findOrFail($listing);

        $request->validate([
            'age'                => 'required|integer|min:16|max:100',
            'gender'             => 'required|string',
            'additional_details' => 'nullable|string|max:500',
        ]);

        Application::create([
            'applicationtype'    => 'single',
            'status'             => 'pending',
            'dateapplied'        => now(),
            'studentid'          => $student->id,
            'rentalid'           => $rental->id,
            'age'                => $request->age,
            'gender'             => $request->gender,
            'additional_details' => $request->additional_details,
            'group_id'           => null, // single apps have no group
        ]);

        return redirect()
            ->route('student.profile.new.applications')
            ->with('success', 'Application created successfully');
    }

    /**
     * Store Group Application (into `application` table via group_id)
     * Route: POST /applications/submit/group/{listing}
     *
     * UI sends:
     *   mode = 'existing' | 'new' (default should be 'new')
     *   existing_group_id (when mode=existing)
     *   tenants[] (array of members) when mode=new
     */
    public function submitGroup(Request $request, $listing)
    {
        if (!session('student_id')) {
            return redirect('/student/login');
        }

        $student = Student::find(session('student_id'));
        $rental  = LandlordRental::findOrFail($listing);

        // Default to "new" to avoid failing when there are no existing groups
        $mode = $request->input('mode', 'new');

        // Validation depends on mode
        $rules = [
            'additional_details' => 'nullable|string|max:500',
        ];

        if ($mode === 'existing') {
            // We deliberately avoid hard-coding the table name in "exists" to support both `groups_table` or backtick-escaped `groups`.
            // We'll validate presence & integer type here; then rely on Group::findOrFail() below for existence.
            $rules['existing_group_id'] = 'required|integer|min:1';
        } else {
            // Creating a new group – require tenants
            $rules['tenants']                 = 'required|array|min:1|max:5';  // + creator = up to 6 total
            $rules['tenants.*.full_name']     = 'required|string|max:100';
            $rules['tenants.*.email']         = 'required|email';
            $rules['tenants.*.age']           = 'required|integer|min:16|max:100';
            $rules['tenants.*.gender']        = 'required|string';
        }

        $request->validate($rules);

        $group = null;
        $emailsToNotify = []; // collect best-effort emails to notify (registered + any typed emails when creating new group)

        DB::transaction(function () use ($mode, $request, $student, $rental, &$group, &$emailsToNotify) {

            if ($mode === 'existing') {
                $groupId = (int) $request->input('existing_group_id');
                $group   = Group::findOrFail($groupId);

                // Ensure requester is a member (optional; you may abort(403) instead)
                $isMember = $group->members()->where('student_id', $student->id)->exists();
                if (!$isMember) {
                    $group->members()->syncWithoutDetaching([$student->id => ['role' => 'leader']]);
                }

                // Collect registered member emails for notification (exclude creator later)
                $emailsToNotify = $group->members()
                    ->pluck('email')
                    ->filter()
                    ->map(fn($e) => strtolower(trim($e)))
                    ->unique()
                    ->values()
                    ->all();

            } else {
                // Create a new reusable group & attach known registered students (by email)
                $tenants = $request->input('tenants', []);
                if (empty($tenants)) {
                    throw new \RuntimeException('Please add at least one additional member.');
                }

                $group = Group::create([
                    'name'        => null,
                    'created_by'  => $student->id,
                    'status'      => 'active',
                    'dateapplied' => now(),
                ]);

                // Creator is leader
                $group->members()->syncWithoutDetaching([$student->id => ['role' => 'leader']]);

                foreach ($tenants as $member) {
                    $rawEmail = strtolower(trim($member['email'] ?? ''));
                    if (!$rawEmail) {
                        continue;
                    }

                    $existing = Student::whereRaw('LOWER(email)=?', [$rawEmail])->first();
                    if ($existing) {
                        $group->members()->syncWithoutDetaching([$existing->id => ['role' => 'member']]);
                    }

                    // Add to notification list regardless; (duplicates deduped later)
                    $emailsToNotify[] = $rawEmail;
                }

                // Also include registered member emails (including creator for now; we'll exclude below)
                $registeredEmails = $group->members()->pluck('email')->filter()->map(fn($e) => strtolower(trim($e)))->all();
                $emailsToNotify   = collect($emailsToNotify)->merge($registeredEmails)->unique()->values()->all();
            }

            // Create one group application row in `application`
            Application::create([
                'applicationtype'    => 'group',
                'status'             => 'pending',
                'dateapplied'        => now(),
                'studentid'          => $student->id,          // initiator (optional for UI)
                'rentalid'           => $rental->id,
                'additional_details' => $request->input('additional_details'),
                'group_id'           => $group->id,
                'age'                => null,
                'gender'             => null,
            ]);
        });

        // ---- Email notifications (best-effort, ignore failures) ----
        $rentalAddress = trim(($rental->housenumber ? $rental->housenumber . ' ' : '') . $rental->street . ', ' . $rental->county);
        $creatorName   = trim($student->firstname . ' ' . $student->surname);
        $creatorEmail  = strtolower($student->email);

        $sent = [];
        foreach ($emailsToNotify as $email) {
            $email = strtolower(trim($email));
            if (!$email || $email === $creatorEmail || isset($sent[$email])) {
                continue;
            }
            try {
                Mail::raw(
                    "Hello,\n\n{$creatorName} included you in a group application for {$rentalAddress}.\n\n".
                    "Log in with your student account to view it in your profile.\n\nThanks,\nRentConnect",
                    function ($m) use ($email, $rentalAddress) {
                        $m->to($email)->subject("You were added to a group application – {$rentalAddress}");
                    }
                );
                $sent[$email] = true;
            } catch (\Throwable $e) {
                Log::warning('Mail send failed (group application notice)', ['to' => $email, 'error' => $e->getMessage()]);
            }
        }

        return redirect()
            ->route('student.profile.new.applications')
            ->with('success', 'Group application submitted.');
    }

    /**
     * Delete ENTIRE application (creator or any group member)
     */
    public function withdraw($id)
    {
        if (!session()->has('student_id')) {
            return redirect('/student/login');
        }

        $app = Application::findOrFail($id);
        $app->delete();

        return redirect()
            ->route('student.profile.new.applications')
            ->with('success', 'Group application deleted for all tenants.');
    }
}