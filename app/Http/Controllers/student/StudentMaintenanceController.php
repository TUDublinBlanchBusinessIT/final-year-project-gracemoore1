<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
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

        return view('student.maintenance-log', [
            'application' => $app,
        ]);
    }
}