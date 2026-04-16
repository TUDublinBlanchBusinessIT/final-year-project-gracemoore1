<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Student;
use App\Models\Landlord;
use App\Models\ServiceProviderPartnership;

class ComplaintController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | RESOLVE REPORTER FROM SESSION
    |--------------------------------------------------------------------------
    */
    private function resolveReporterFromSession(): array
    {
        if (session('student_id')) {
            return ['id' => session('student_id'), 'role' => 'student'];
        } elseif (session('landlord_id')) {
            return ['id' => session('landlord_id'), 'role' => 'landlord'];
        } elseif (session('serviceprovider_id')) {
            return ['id' => session('serviceprovider_id'), 'role' => 'serviceprovider'];
        }
        return ['id' => null, 'role' => null];
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE (form page)
    |--------------------------------------------------------------------------
    */
    public function create(Request $request)
    {
        $reportedId   = $request->reported_user_id;
        $reportedRole = $request->reported_user_role;

        $reporter = $this->resolveReporterFromSession();

        $reporterDisplay = $this->resolveDisplay($reporter['id'], $reporter['role']);
        $reportedDisplay = $this->resolveDisplay($reportedId, $reportedRole);

        return view('complaint.create', [
            'reported_user_id'   => $reportedId,
            'reported_user_role' => $reportedRole,
            'reportedDisplay'    => $reportedDisplay,
            'reporterDisplay'    => $reporterDisplay,
            'user_id'            => $reporter['id'],
            'user_role'          => $reporter['role'],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE (saving complaint)
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $reporterId   = $request->reporter_id;
        $reporterRole = $request->reporter_role;

        if (!$reporterId) {
            $reporter     = $this->resolveReporterFromSession();
            $reporterId   = $reporter['id'];
            $reporterRole = $reporter['role'];
        }

        if (!$reporterId) {
            return back()->with('error', 'Reporter ID missing. Please log in again.');
        }

        // Handle image uploads
        $evidenceLines = '';
        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $image) {
                $paths[] = '- ' . $image->store('complaints', 'public');
            }
            $evidenceLines = "\n\nEVIDENCE:\n" . implode("\n", $paths);
        }

        $description = "SUBJECT: {$request->subject}\n\nDETAILS: {$request->details}{$evidenceLines}";

        Complaint::create([
            'subject'            => $request->subject,
            'description'        => $description,
            'reporter_id'        => $reporterId,
            'reporter_role'      => $reporterRole,
            'reported_user_id'   => $request->reported_user_id,
            'reported_user_role' => $request->reported_user_role,
        ]);

        return back()->with('success', 'Complaint submitted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN VIEW
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $complaints = Complaint::latest()->get();

        foreach ($complaints as $complaint) {
            $complaint->reporter_name = $this->resolveDisplay(
                $complaint->reporter_id,
                $complaint->reporter_role
            );

            $complaint->reported_name = $this->resolveDisplay(
                $complaint->reported_user_id,
                $complaint->reported_user_role
            );
        }

        return view('admin.complaints.index', compact('complaints'));
    }

    /*
    |--------------------------------------------------------------------------
    | UNIVERSAL NAME RESOLVER (DO NOT TOUCH)
    |--------------------------------------------------------------------------
    */
    private function resolveDisplay($id, $role)
    {
        if (!$id || !$role) {
            return 'Unknown user';
        }

        $user = match ($role) {
            'student'                          => Student::find($id),
            'landlord'                         => Landlord::find($id),
            'serviceprovider', 'service_provider' =>
                class_exists(\App\Models\ServiceProviderPartnership::class)
                    ? \App\Models\ServiceProviderPartnership::find($id)
                    : null,
            default => null,
        };

        if (!$user) {
            return 'Unknown user (' . ucfirst($role) . ')';
        }

        return $user->firstname . ' ' . $user->surname . ' (' . ucfirst($role) . ')';
    }
}