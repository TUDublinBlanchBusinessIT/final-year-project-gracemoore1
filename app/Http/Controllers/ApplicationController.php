<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandlordRental;
use App\Models\Application;
use App\Models\Student;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    /**
     * Show the application selection form (Single or Group)
     */
    public function start($rentalId, $type)
    {
        if (!session('student_id')) {
            return redirect('/student/login');
        }

        $student = Student::find(session('student_id'));
        $listing = LandlordRental::findOrFail($rentalId);

        if (!in_array($type, ['single', 'group'])) {
            abort(404);
        }

        return view('applications.start-' . $type, [
            'rental'  => $listing,
            'student' => $student,
            'type'    => $type,
        ]);
    }

    /**
     * Store Single Application
     */
    public function submitSingle(Request $request, $rentalId)
    {
        if (!session('student_id')) {
            return redirect('/student/login');
        }

        $student = Student::find(session('student_id'));
        $listing = LandlordRental::findOrFail($rentalId);

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
            'rentalid'           => $listing->id,
            'age'                => $request->age,
            'gender'             => $request->gender,
            'additional_details' => $request->additional_details,
            'group_members'      => null,
        ]);

        return redirect()
            ->route('student.profile.new.applications')
            ->with('success', 'Application created successfully');
    }

    /**
     * Store Group Application
     *
     * - Creates ONE leader application row (for the logged-in student)
     * - Saves all tenants into group_members JSON (your current pattern)
     * - Emails each additional tenant to notify them they were included
     * - NO extra DB columns, NO invite flow
     */
    public function submitGroup(Request $request, $rentalId)
    {
        if (!session('student_id')) {
            return redirect('/student/login');
        }

        $student = Student::find(session('student_id'));
        $listing = LandlordRental::findOrFail($rentalId);

        $request->validate([
            'tenants'               => 'required|array|min:1|max:6',
            'tenants.*.full_name'   => 'required|string|max:100',
            'tenants.*.email'       => 'required|email',
            'tenants.*.age'         => 'required|integer|min:16|max:100',
            'tenants.*.gender'      => 'required|string',
            'additional_details'    => 'nullable|string|max:500',
        ]);

        $tenants = $request->tenants;

        // (Safety) Force the first tenant to be the logged-in student data,
        // in case a client tries to tamper with hidden fields.
        $tenants[0]['full_name'] = trim($student->firstname . ' ' . $student->surname);
        $tenants[0]['email']     = $student->email;

        // Create the single leader application row
        Application::create([
            'applicationtype'    => 'group',
            'status'             => 'pending',
            'dateapplied'        => now(),
            'studentid'          => $student->id,
            'rentalid'           => $listing->id,
            'additional_details' => $request->additional_details,
            'group_members'      => json_encode($tenants),
        ]);

        // Email each additional tenant to notify them they were added
        $rentalAddress = trim(($listing->housenumber ? $listing->housenumber . ' ' : '') . $listing->street . ', ' . $listing->county);
        $leaderName    = $tenants[0]['full_name'];

        foreach (array_slice($tenants, 1) as $member) {
            $inviteeName  = $member['full_name'] ?? '';
            $inviteeEmail = $member['email']     ?? '';
            if (!$inviteeEmail) {
                continue;
            }

            // Simple, dependency-free mail (no new Mailable class required)
            Mail::raw(
                "Hello {$inviteeName},\n\n" .
                "{$leaderName} included you as a tenant on a group application for {$rentalAddress}.\n\n" .
                "If this application is unwanted on your behalf, you can withdraw it on your profile (Applications).\n\n" .
                "If you do not yet have an account, register with your university email and you will see it under Applications.\n\n" .
                "Thanks,\nRentConnect",
                function ($message) use ($inviteeEmail, $rentalAddress) {
                    $message->to($inviteeEmail)
                            ->subject("You were added to a group application – {$rentalAddress}");
                }
            );
        }

        return redirect()
            ->route('student.profile.new.applications')
            ->with('success', 'Group application submitted.');
    }

    public function withdraw($id)
    {
        if (!session()->has('student_id')) {
            return redirect('/student/login');
        }

        $app = Application::where('id', $id)
            ->where('studentid', session('student_id'))
            ->firstOrFail();

        $app->delete();

        return redirect()
            ->route('student.profile.new.applications')
            ->with('success', 'Application withdrawn successfully.');
    }
}