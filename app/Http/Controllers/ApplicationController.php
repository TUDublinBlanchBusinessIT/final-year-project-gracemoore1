<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandlordRental;
use App\Models\Application;
use App\Models\Student;

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

        Application::create([
            'applicationtype'    => 'group',
            'status'             => 'pending',
            'dateapplied'        => now(),
            'studentid'          => $student->id,
            'rentalid'           => $listing->id,
            'additional_details' => $request->additional_details,
            'group_members'      => json_encode($request->tenants),
        ]);

        return redirect()
            ->route('student.profile.new.applications')
            ->with('success', 'Application created successfully');
    }
}