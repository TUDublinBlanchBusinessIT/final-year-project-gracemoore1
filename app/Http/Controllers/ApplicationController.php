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

        // Always force tenant 1 to be the creator
        $tenants[0]['full_name'] = trim($student->firstname . ' ' . $student->surname);
        $tenants[0]['email']     = $student->email;

        // Create the single group application row
        Application::create([
            'applicationtype'    => 'group',
            'status'             => 'pending',
            'dateapplied'        => now(),
            'studentid'          => $student->id,
            'rentalid'           => $listing->id,
            'additional_details' => $request->additional_details,
            'group_members'      => json_encode($tenants),
        ]);

        // Email all other tenants
        $rentalAddress = trim(($listing->housenumber ? $listing->housenumber . ' ' : '') . $listing->street . ', ' . $listing->county);
        $creatorName   = $tenants[0]['full_name'];

        foreach (array_slice($tenants, 1) as $member) {
            $name  = $member['full_name'] ?? '';
            $email = $member['email'] ?? '';
            if (!$email) continue;

            Mail::raw(
                "Hello {$name},\n\n".
                "{$creatorName} included you in a group application for {$rentalAddress}.\n\n".
                "If you do not have an account yet, register with your university email to see it.\n\n".
                "Thanks,\nRentConnect",
                function ($m) use ($email, $rentalAddress) {
                    $m->to($email)->subject("You were added to a group application – {$rentalAddress}");
                }
            );
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

        // Anyone listed can delete the entire group application
        $app->delete();

        return redirect()
            ->route('student.profile.new.applications')
            ->with('success', 'Group application deleted for all tenants.');
    }
}