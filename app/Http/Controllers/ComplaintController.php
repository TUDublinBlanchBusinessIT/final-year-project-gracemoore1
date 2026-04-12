<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Student;
use App\Models\Landlord;

class ComplaintController extends Controller
{
    public function create(Request $request)
    {
        $reportedId = $request->reported_user_id;
        $reportedRole = $request->reported_user_role;

        $reporter = auth()->user();

        $reporterDisplay = $reporter
            ? $reporter->firstname . ' ' . $reporter->surname . ' (' . ucfirst($reporter->role) . ')'
            : 'Unknown reporter';

        // SIMPLE FIX: ONLY HANDLE WHAT EXISTS IN YOUR SYSTEM
        $reportedUser = $this->resolveReportedUser($reportedId, $reportedRole);

        $reportedDisplay = $reportedUser
            ? $reportedUser->firstname . ' ' . $reportedUser->surname . ' (' . ucfirst($reportedRole) . ')'
            : 'Unknown user (' . ucfirst($reportedRole) . ')';

        return view('complaint.create', [
            'reported_user_id' => $reportedId,
            'reported_user_role' => $reportedRole,
            'reportedDisplay' => $reportedDisplay,
            'reporterDisplay' => $reporterDisplay,
        ]);
    }

    private function resolveReportedUser($id, $role)
    {
        return match ($role) {
            'student' => Student::find($id),
            'landlord' => Landlord::find($id),
            default => null,
        };
    }

    public function store(Request $request)
    {
        Complaint::create([
            'subject' => $request->subject,
            'description' => $request->description,
            'reporter_id' => auth()->id(),
            'reporter_role' => auth()->user()->role,
            'reported_user_id' => $request->reported_user_id,
            'reported_user_role' => $request->reported_user_role,
        ]);

        return back()->with('success', 'Complaint submitted successfully.');
    }
}