<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Maintenancelog;
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
}