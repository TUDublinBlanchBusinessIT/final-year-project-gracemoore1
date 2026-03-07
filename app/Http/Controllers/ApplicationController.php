<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandlordRental;
use App\Models\Application;

class ApplicationController extends Controller
{
    /**
     * Show the application selection form (Single or Group)
     */
    public function start($listingId, $type)
    {
        $student = \App\Models\Student::find(session('student_id'));
        if (!session('student_id')) {
            return redirect('/student/login');
        }
        // Load the correct rental model
        $listing = LandlordRental::findOrFail($listingId);

        if (!in_array($type, ['single', 'group'])) {
            abort(404);
        }

        return view('applications.start-' . $type, [
            'listing' => $listing,
            'type' => $type,
            'student' => $student
        ]);
    }

    /**
     * Store Single Application
     */
    public function submitSingle(Request $request, $listingId)
    {
        $student = \App\Models\Student::find(session('student_id'));
        if (!session('student_id')) {
            return redirect('/student/login');
        }
        $request->validate([
            'age' => 'required|integer|min:16|max:100',
            'gender' => 'required|string',
            'additional_details' => 'nullable|string|max:500',
        ]);

        $listing = LandlordRental::findOrFail($listingId);
        $student = auth()->user();

        Application::create([
            'applicationtype' => 'single',
            'status' => 'pending',
            'dateapplied' => now(),
            'student_id' => $student->id,
            'listing_id' => $listing->id,
            'age' => $request->age,
            'gender' => $request->gender,
            'additional_details' => $request->additional_details,
            'group_members' => null, // Only used for group applications
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Your application has been submitted and is now pending.');
    }

    /**
     * Store Group Application (up to 6 tenants)
     */
    public function submitGroup(Request $request, $listingId)
    {
        $student = \App\Models\Student::find(session('student_id'));
        if (!session('student_id')) {
            return redirect('/student/login');
        }
        $listing = LandlordRental::findOrFail($listingId);
        $submittedBy = auth()->user();

        $request->validate([
            'tenants' => 'required|array|min:1|max:6',
            'tenants.*.full_name' => 'required|string|max:100',
            'tenants.*.email' => 'required|email',
            'tenants.*.age' => 'required|integer|min:16|max:100',
            'tenants.*.gender' => 'required|string',
            'additional_details' => 'nullable|string|max:500',
        ]);

        // Create application
        $application = Application::create([
            'applicationtype' => 'group',
            'status' => 'pending',
            'dateapplied' => now(),
            'student_id' => $submittedBy->id,
            'listing_id' => $listing->id,
            'additional_details' => $request->additional_details,
            'group_members' => json_encode($request->tenants),
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Group application submitted and is now pending.');
    }
}