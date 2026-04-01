<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Maintenancelog;
use App\Models\Message;
use Illuminate\Http\Request;

class LandlordMaintenanceController extends Controller
{
    public function page(Request $request, int $application)
    {
        $landlordId = session('landlord_id');
        abort_if(!$landlordId, 401);

        $app = Application::with(['rental', 'student'])->findOrFail($application);

        abort_unless($app->rental && $app->rental->landlordid == $landlordId, 403);
        abort_unless($app->status === 'accepted', 403);

        Maintenancelog::where('applicationid', $app->id)
            ->where('is_seen_by_landlord', false)
            ->update([
                'is_seen_by_landlord' => true,
            ]);

        $logs = Maintenancelog::where('applicationid', $app->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('landlord.maintenance-log', [
            'application' => $app,
            'logs' => $logs,
        ]);
    }

    public function update(Request $request, int $application, int $log)
    {
        $landlordId = session('landlord_id');
        abort_if(!$landlordId, 401);

        $app = Application::with(['rental', 'student'])->findOrFail($application);

        abort_unless($app->rental && $app->rental->landlordid == $landlordId, 403);
        abort_unless($app->status === 'accepted', 403);

        $maintenanceLog = Maintenancelog::where('id', $log)
            ->where('applicationid', $app->id)
            ->firstOrFail();

        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
            'landlord_note' => 'nullable|string|max:1000',
        ]);

        $maintenanceLog->update([
            'status' => $request->status,
            'landlord_note' => $request->landlord_note,
        ]);

        Message::create([
            'content' => '🛠 Maintenance update: ' . ($request->status === 'in_progress' ? 'In Progress' : ucfirst($request->status)) . '. Please check the maintenance tracker.',
            'sender_type' => 'system',
            'timestamp' => now(),
            'studentid' => $app->studentid,
            'group_id' => $app->group_id,
            'landlordid' => $app->rental->landlordid,
            'rentalid' => $app->rentalid,
            'serviceproviderpartnershipid' => null,
            'is_read_by_student' => false,
            'is_read_by_landlord' => true,
        ]);

        return redirect()
            ->route('landlord.maintenance-log', $app->id)
            ->with('success', 'Maintenance issue updated successfully.');
    }
}