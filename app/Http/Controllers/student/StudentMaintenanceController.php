<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Maintenancelog;
use Illuminate\Http\Request;
use App\Models\Message;

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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/maintenance-images'), $filename);
            $imagePath = 'maintenance-images/' . $filename;
        }

        Maintenancelog::create([
            'description'   => $request->description,
            'images'        => $imagePath,
            'status'        => 'pending',
            'landlord_note' => null,
            'priority'      => $request->priority,
            'timestamp'     => now(),
            'studentid'     => $studentId,
            'rentalid'      => $app->rentalid,
            'applicationid' => $app->id,
            'landlordid'    => $app->rental->landlordid ?? null,
            'is_seen_by_landlord' => false,

        ]);

        Message::create([
            'content' => '🛠 ' . ($app->student->firstname ?? 'Student') . ' opened the maintenance log. Please review it now.',
            'sender_type' => 'system',
            'timestamp' => now(),
            'studentid' => $studentId,
            'group_id' => $app->group_id,
            'landlordid' => $app->rental->landlordid,
            'rentalid' => $app->rentalid,
            'serviceproviderpartnershipid' => null,
            'is_read_by_student' => true,
            'is_read_by_landlord' => false,
        ]);

        return redirect()
            ->route('student.maintenance-log', $app->id)
            ->with('success', 'Maintenance issue logged successfully.');
    }
}