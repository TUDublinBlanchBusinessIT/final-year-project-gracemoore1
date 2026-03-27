<?php

namespace App\Http\Controllers\Landlord ;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\RentPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LandlordRentTrackerController extends Controller
{
    public function page(Request $request, int $application)
    {
        $landlordId = session('landlord_id');
        abort_if(!$landlordId, 401);

        $app = Application::with(['rental.landlord', 'student', 'group'])->findOrFail($application);
        abort_unless($this->canAccess($landlordId, $app), 403);

        $groupId      = null;
        $groupMembers = collect();

        if (($app->applicationtype) === 'group' && $app->group_id) {
            $groupId = (int)($request->query('group_id') ?: $app->group_id);

            $groupMembers = DB::table('student_groups')
                ->join('student', 'student_groups.student_id', '=', 'student.id')
                ->where('group_id', $app->group_id)
                ->select('student.firstname', 'student.surname', 'student.id')
                ->get();
        }

        return view('landlord.rent-tracker', [
            'application'  => $app,
            'groupId'      => $groupId,
            'groupMembers' => $groupMembers,
        ]);
    }

    public function getHistory(Request $request)
    {
        $landlordId = session('landlord_id');
        abort_if(!$landlordId, 401);

        $request->validate([
            'application_id' => 'required|integer',
            'group_id'       => 'nullable|integer',
        ]);

        $application = Application::with('rental')->findOrFail($request->application_id);
        abort_unless($this->canAccess($landlordId, $application), 403);

        $month = (int)($request->month ?? now()->month);
        $year  = (int)($request->year  ?? now()->year);

        $groupFilter = $this->normalizeGroupId($application, $request->group_id);

        $table   = (new RentPayment)->getTable();
        $selects = ['id', 'amount', 'status', 'timestamp', 'studentid', 'landlordid'];
        if (Schema::hasColumn($table, 'for_date')) $selects[] = 'for_date';
        if (Schema::hasColumn($table, 'paid_by'))  $selects[] = 'paid_by';

        $items = RentPayment::query()
            ->where('application_id', $application->id)
            ->when($groupFilter['type'] === 'value', fn($q) => $q->where('group_id', $groupFilter['value']))
            ->when($groupFilter['type'] === 'null_or_zero', fn($q) => $q->where(fn($w) => $w->whereNull('group_id')->orWhere('group_id', 0)))
            ->orderByDesc('timestamp')
            ->get($selects);

        // Look up student name from studentid if paid_by is not set
        $items = $items->map(function ($item) {
            if (empty($item->paid_by) && !empty($item->studentid)) {
                $student = \App\Models\Student::find($item->studentid);
                if ($student) {
                    $item->paid_by = trim($student->firstname . ' ' . $student->surname);
                }
            }
            return $item;
        });

        [$monthlyDue, $dueDateIso, $remindOnIso, $overdueOnIso] = $this->computeDue($application, $month, $year);

        $paidThisMonth = RentPayment::query()
            ->where('application_id', $application->id)
            ->when($groupFilter['type'] === 'value', fn($q) => $q->where('group_id', $groupFilter['value']))
            ->when($groupFilter['type'] === 'null_or_zero', fn($q) => $q->where(fn($w) => $w->whereNull('group_id')->orWhere('group_id', 0)))
            ->where('status', 'succeeded')
            ->whereMonth('timestamp', $month)
            ->whereYear('timestamp', $year)
            ->sum('amount');

        $outstanding = max(0, $monthlyDue - $paidThisMonth);

        $now     = now();
        $due     = Carbon::parse($dueDateIso);
        $remind  = Carbon::parse($remindOnIso);
        $overdue = Carbon::parse($overdueOnIso);

        // Green reminder
        if ($now->gte($remind)) {
            $items->push((object)[
                'id'         => "remind-$year-$month",
                'amount'     => $monthlyDue,
                'status'     => 'reminder',
                'label'      => 'Rent Due Soon',
                'timestamp'  => $remind->toIso8601String(),
                'for_date'   => $due->toDateString(),
                'paid_by'    => null,
                'studentid'  => null,
                'landlordid' => $application->rental->landlordid ?? null,
            ]);
        }

        // Red overdue
        if ($now->gte($overdue) && $outstanding > 0) {
            $items->push((object)[
                'id'         => "overdue-$year-$month",
                'amount'     => $outstanding,
                'status'     => 'reminder',
                'label'      => 'Overdue',
                'timestamp'  => $overdue->toIso8601String(),
                'for_date'   => $due->toDateString(),
                'paid_by'    => null,
                'studentid'  => null,
                'landlordid' => $application->rental->landlordid ?? null,
            ]);
        }

        return response()->json([
            'month'   => $month,
            'year'    => $year,
            'history' => $items->sortBy('timestamp')->values(),
        ]);
    }

    public function getBalance(Request $request)
    {
        $landlordId = session('landlord_id');
        abort_if(!$landlordId, 401);

        $request->validate([
            'application_id' => 'required|integer',
            'group_id'       => 'nullable|integer',
        ]);

        $application = Application::with('rental')->findOrFail($request->application_id);
        abort_unless($this->canAccess($landlordId, $application), 403);

        $month = (int)($request->month ?? now()->month);
        $year  = (int)($request->year  ?? now()->year);

        $groupFilter = $this->normalizeGroupId($application, $request->group_id);
        [$monthlyDue, $dueDateIso, $remindOnIso, $overdueOnIso] = $this->computeDue($application, $month, $year);

        $paid = RentPayment::query()
            ->where('application_id', $application->id)
            ->when($groupFilter['type'] === 'value', fn($q) => $q->where('group_id', $groupFilter['value']))
            ->when($groupFilter['type'] === 'null_or_zero', fn($q) => $q->where(fn($w) => $w->whereNull('group_id')->orWhere('group_id', 0)))
            ->where('status', 'succeeded')
            ->whereMonth('timestamp', $month)
            ->whereYear('timestamp', $year)
            ->sum('amount');

        return response()->json([
            'monthly_due'  => number_format($monthlyDue, 2),
            'paid'         => number_format($paid, 2),
            'outstanding'  => number_format(max(0, $monthlyDue - $paid), 2),
            'due_date_iso' => $dueDateIso,
            'month'        => $month,
            'year'         => $year,
        ]);
    }

    private function canAccess(int $landlordId, Application $app): bool
    {
        if ($app->status !== 'accepted') return false;
        return $app->rental->landlordid == $landlordId;
    }

    private function normalizeGroupId(Application $app, $gid)
    {
        if ($app->applicationtype === 'group' && $app->group_id) {
            return ['type' => 'value', 'value' => $gid ?? $app->group_id];
        }
        return ['type' => 'null_or_zero', 'value' => null];
    }

    private function computeDue($app, int $month, int $year)
    {
        $rent         = $app->rental->rentpermonth ?? 0;
        $groupMembers = 1;

        if ($app->group_id) {
            $groupMembers = DB::table('student_groups')
                ->where('group_id', $app->group_id)
                ->count();
            $groupMembers = max(1, $groupMembers);
        }

        $perPerson = round($rent / $groupMembers, 2);
        $tz        = config('app.timezone');

        $availableFrom = $app->rental->availablefrom
            ? Carbon::parse($app->rental->availablefrom)
            : null;

        $dueDay        = $availableFrom ? (int)$availableFrom->format('d') : 1;
        $eom           = Carbon::create($year, $month, 1, 0, 0, 0, $tz)->endOfMonth()->day;
        $dueDayClamped = max(1, min($dueDay, $eom));

        $dueDate   = Carbon::create($year, $month, $dueDayClamped, 9, 0, 0, $tz);
        $remindOn  = (clone $dueDate)->subDays(2);
        $overdueOn = (clone $dueDate)->addDays(1);

        return [$perPerson, $dueDate->toIso8601String(), $remindOn->toIso8601String(), $overdueOn->toIso8601String()];
    }
}