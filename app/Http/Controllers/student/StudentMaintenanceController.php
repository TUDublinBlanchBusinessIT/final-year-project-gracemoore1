<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Maintenancelog;
use Illuminate\Http\Request;

class StudentMaintenanceController extends Controller
{
    public function page(Request $request, int $application)
    {
        $studentId = session('student_id');
        abort_if(!$studentId, 401);

        $app = Application::with('rental')->findOrFail($application);
        abort_unless($app->studentid == $studentId, 403);
        abort_unless($app->status === 'accepted', 403);

        $logs = Maintenancelog::where('applicationid', $app->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('student.maintenance-log', [
            'application' => $app,
            'logs' => $logs,
        ]);
    }

    public function store(Request $request, int $application)
    {
        $studentId = session('student_id');
        abort_if(!$studentId, 401);

        $app = Application::with('rental')->findOrFail($application);
        abort_unless($app->studentid == $studentId, 403);
        abort_unless($app->status === 'accepted', 403);

        $request->validate([
            'description' => 'required|string|max:1000',
            'priority' => 'required|in:high,medium,low',
        ]);

        Maintenancelog::create([
            'description'   => $request->description,
            'images'        => null,
            'status'        => 'open',
            'priority'      => $request->priority,
            'timestamp'     => now(),
            'studentid'     => $studentId,
            'rentalid'      => $app->rentalid,
            'applicationid' => $app->id,
            'landlordid'    => $app->rental->landlordid ?? null,
        ]);

        return redirect()
            ->route('student.maintenance-log', $app->id)
            ->with('success', 'Maintenance issue logged successfully.');
    }
}