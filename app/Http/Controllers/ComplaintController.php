<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComplaintController extends Controller
{
    private function reporterFromSession()
    {
        if (session('student_id')) return ['role' => 'student', 'id' => session('student_id')];
        if (session('landlord_id')) return ['role' => 'landlord', 'id' => session('landlord_id')];
        if (session('serviceprovider_id')) return ['role' => 'serviceprovider', 'id' => session('serviceprovider_id')];
        return null;
    }

    public function create(Request $request)
    {
        $me = $this->reporterFromSession();
        abort_if(!$me, 403);

        return view('complaint.create', [
            'reported_user_id' => $request->query('reported_user_id'),
            'reported_user_role' => $request->query('reported_user_role'),
        ]);
    }

    public function store(Request $request)
    {
        $me = $this->reporterFromSession();
        abort_if(!$me, 403);

        $request->validate([
            'subject' => 'required|string|max:150',
            'details' => 'required|string',
            'reported_user_id' => 'required|integer',
            'reported_user_role' => 'required|in:student,landlord,serviceprovider',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|max:2048',
        ]);

        // Upload images (optional) and collect paths
        $paths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $paths[] = $img->store('complaints', 'public');
            }
        }

        // Store subject + details + evidence paths inside description
        $description = "SUBJECT: {$request->subject}\n\n";
        $description .= "DETAILS: {$request->details}\n\n";
        if (count($paths)) {
            $description .= "EVIDENCE:\n";
            foreach ($paths as $p) {
                $description .= "- {$p}\n";
            }
        }

        DB::table('complaint')->insert([
            'description' => $description,
            'reporter_id' => $me['id'],
            'reporter_role' => $me['role'],
            'reported_user_id' => $request->reported_user_id,
            'reported_user_role' => $request->reported_user_role,
            'administratorid' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Report submitted successfully.');
    }
}