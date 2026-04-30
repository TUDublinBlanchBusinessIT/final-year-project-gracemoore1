<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\RentPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RentTrackerController extends Controller
{
    public function getBalance(Request $request)
    {
        $request->validate([
            'application_id' => 'required|integer',
            'group_id'       => 'nullable|integer',
            'month'          => 'nullable|integer|min:1|max:12',
            'year'           => 'nullable|integer|min:2000|max:2100',
        ]);

        $studentId  = session('student_id');
        $landlordId = session('landlord_id');
        abort_if(!$studentId && !$landlordId, 401);

        $application = Application::with('rental')->findOrFail($request->application_id);

        if ($studentId) {
            abort_unless($this->canAccess($studentId, $application), 403);
        }

        if ($landlordId) {
            abort_unless((int) $application->rental->landlordid === (int) $landlordId, 403);
        }
        //$studentId = session('student_id') ?? session('landlord_id');
        //abort_if(!$studentId, 401);

        //$application = Application::with('rental')->findOrFail($request->application_id);
        //abort_unless($this->canAccess($studentId, $application), 403);

        $month = (int)($request->month ?? now()->month);
        $year  = (int)($request->year  ?? now()->year);

        $groupFilter = $this->normalizeGroupId($application, $request->group_id);
        [$monthlyDue, $dueDateIso, $remindOnIso, $overdueOnIso] = $this->computeDue($application, $month, $year);

        $paid = RentPayment::query()
            ->where('application_id', $application->id)
            ->when($groupFilter['type'] === 'value', fn ($q) => $q->where('group_id', $groupFilter['value']))
            ->when($groupFilter['type'] === 'null_or_zero', function ($q) {
                $q->where(fn($w) => $w->whereNull('group_id')->orWhere('group_id', 0));
            })
            ->where('status', 'succeeded')
            ->whereMonth('timestamp', $month)
            ->whereYear('timestamp', $year)
            ->sum('amount');

        return response()->json([
            'monthly_due'    => number_format($monthlyDue, 2),
            'paid'           => number_format($paid, 2),
            'outstanding'    => number_format(max(0, $monthlyDue - $paid), 2),
            'due_date_iso'   => $dueDateIso,
            'remind_on_iso'  => $remindOnIso,
            'overdue_on_iso' => $overdueOnIso,
            'month'          => $month,
            'year'           => $year,        

        
        ]);
        
    }

    public function getHistory(Request $request)
    {
        $request->validate([
            'application_id' => 'required|integer',
            'group_id'       => 'nullable|integer',
            'month'          => 'nullable|integer|min:1|max:12',
            'year'           => 'nullable|integer|min:2000|max:2100',
            'all'            => 'nullable|boolean',
        ]);

        $studentId = session('student_id') ?? session('landlord_id');
        abort_if(!$studentId, 401);

        $application = Application::with('rental')->findOrFail($request->application_id);
        abort_unless($this->canAccess($studentId, $application), 403);

        $all   = filter_var($request->query('all'), FILTER_VALIDATE_BOOLEAN);
        $month = (int)($request->month ?? now()->month);
        $year  = (int)($request->year  ?? now()->year);

        $groupFilter = $this->normalizeGroupId($application, $request->group_id);

        $query = RentPayment::query()
            ->where('application_id', $application->id)
            ->when($groupFilter['type'] === 'value', fn($q) => $q->where('group_id', $groupFilter['value']))
            ->when($groupFilter['type'] === 'null_or_zero', fn($q) => $q->where(fn($w) => $w->whereNull('group_id')->orWhere('group_id', 0)));

        if (!$all) {
            $query->whereMonth('timestamp', $month)->whereYear('timestamp', $year);
        }

        $table   = (new RentPayment)->getTable();
        $selects = ['id', 'amount', 'status', 'timestamp', 'stripe_intent_id', 'studentid', 'landlordid'];
        if (Schema::hasColumn($table, 'for_date')) $selects[] = 'for_date';
        if (Schema::hasColumn($table, 'paid_by'))  $selects[] = 'paid_by';

        $items = $query->orderByDesc('timestamp')->get($selects);

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

        // Load all stored reminders for this application (all months)
        $storedReminders = \App\Models\RentReminder::where('application_id', $application->id)
            ->when($groupFilter['type'] === 'value', fn($q) => $q->where('group_id', $groupFilter['value']))
            ->when($groupFilter['type'] === 'null_or_zero', fn($q) => $q->whereNull('group_id'))
            ->orderBy('triggered_at', 'asc')
            ->get();

        foreach ($storedReminders as $sr) {
            $items->push((object)[
                'id'         => "{$sr->type}-{$sr->year}-{$sr->month}",
                'amount'     => $sr->amount,
                'status'     => 'reminder',
                'label'      => $sr->type === 'overdue' ? 'Overdue' : 'Rent Due Soon',
                'timestamp'  => $sr->triggered_at,
                'for_date'   => $sr->for_date,
                'paid_by'    => null,
                'studentid'  => null,
                'landlordid' => $application->rental->landlordid ?? null,
            ]);
        }

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
        $dueMonth   = $due->month;
        $dueYear    = $due->year;
        $dueForDate = $due->toDateString();

        // Green reminder — store permanently if not already stored
        if ($now->gte($remind)) {
            $existingRemind = \App\Models\RentReminder::where('application_id', $application->id)
                ->when($groupFilter['type'] === 'value', fn($q) => $q->where('group_id', $groupFilter['value']))
                ->when($groupFilter['type'] === 'null_or_zero', fn($q) => $q->whereNull('group_id'))
                ->where('type', 'reminder')
                ->where('for_date', $dueForDate)
                ->first();

            if (!$existingRemind) {
                $existingRemind = \App\Models\RentReminder::create([
                    'application_id' => $application->id,
                    'group_id'       => $groupFilter['type'] === 'value' ? $groupFilter['value'] : null,
                    'month'          => $dueMonth,
                    'year'           => $dueYear,
                    'type'           => 'reminder',
                    'amount'         => $monthlyDue,
                    'for_date'       => $dueForDate,
                    'triggered_at'   => $remind->toDateTimeString(),
                ]);
            }

            $items->push((object)[
                'id'         => "remind-{$dueForDate}",
                'amount'     => $existingRemind->amount,
                'status'     => 'reminder',
                'label'      => 'Rent Due Soon',
                'timestamp'  => $existingRemind->triggered_at,
                'for_date'   => $existingRemind->for_date,
                'paid_by'    => null,
                'studentid'  => null,
                'landlordid' => $application->rental->landlordid ?? null,
            ]);
        }

        // Red overdue — store permanently if not already stored
        if ($now->gte($overdue) && $outstanding > 0) {
            $existingOverdue = \App\Models\RentReminder::where('application_id', $application->id)
                ->when($groupFilter['type'] === 'value', fn($q) => $q->where('group_id', $groupFilter['value']))
                ->when($groupFilter['type'] === 'null_or_zero', fn($q) => $q->whereNull('group_id'))
                ->where('type', 'overdue')
                ->where('for_date', $dueForDate)
                ->first();
            if (!$existingOverdue) {
                $existingOverdue = \App\Models\RentReminder::create([
                    'application_id' => $application->id,
                    'group_id'       => $groupFilter['type'] === 'value' ? $groupFilter['value'] : null,
                    'month'          => $dueMonth,
                    'year'           => $dueYear,
                    'type'           => 'overdue',
                    'amount'         => $outstanding,
                    'for_date'       => $dueForDate,
                    'triggered_at'   => $overdue->toDateTimeString(),
                ]);
            }

            $items->push((object)[
                'id'         => "overdue-{$dueForDate}",
                'amount'     => $existingOverdue->amount,
                'status'     => 'reminder',
                'label'      => 'Overdue',
                'timestamp'  => $existingOverdue->triggered_at,
                'for_date'   => $existingOverdue->for_date,
                'paid_by'    => null,
                'studentid'  => null,
                'landlordid' => $application->rental->landlordid ?? null,
            ]);
        }

        $items = $items->unique('id');

        return response()->json([
            'month'   => $month,
            'year'    => $year,
            'history' => $items->sortBy('timestamp')->values(),
        ]);
    }

    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'application_id' => 'required|integer',
            'group_id'       => 'nullable|integer',
            'amount_eur'     => 'nullable|numeric|min:0',
            'for_date'       => 'nullable|date',
            'month'          => 'nullable|integer',
            'year'           => 'nullable|integer',
        ]);

        $studentId = session('student_id')?? session('landlord_id');
        abort_if(!$studentId, 401);

        $application = Application::with('rental')->findOrFail($request->application_id);
        abort_unless($this->canAccess($studentId, $application), 403);

        $month = (int)($request->month ?? now()->month);
        $year  = (int)($request->year  ?? now()->year);

        [$monthlyDue] = $this->computeDue($application, $month, $year);
        $groupFilter  = $this->normalizeGroupId($application, $request->group_id);
        $groupId      = $groupFilter['type'] === 'value' ? $groupFilter['value'] : null;

        $paid = RentPayment::query()
            ->where('application_id', $application->id)
            ->when($groupFilter['type'] === 'value', fn($q) => $q->where('group_id', $groupId))
            ->when($groupFilter['type'] === 'null_or_zero', fn($q) => $q->where(fn($w) => $w->whereNull('group_id')->orWhere('group_id', 0)))
            ->where('status', 'succeeded')
            ->whereMonth('timestamp', $month)
            ->whereYear('timestamp', $year)
            ->sum('amount');

        $outstanding = max(0, $monthlyDue - $paid);
        $amount      = $request->amount_eur ? (float)$request->amount_eur : $outstanding;
        abort_if($amount <= 0, 422, 'Nothing due');

        $landlordId = (int)$application->rental->landlordid;
        $rentalId   = (int)$application->rentalid;
        $forDate    = $request->for_date ? Carbon::parse($request->for_date)->toDateString() : null;

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $pi = \Stripe\PaymentIntent::create([
            'amount'                    => (int)round($amount * 100),
            'currency'                  => 'eur',
            'automatic_payment_methods' => ['enabled' => true],
            'description'               => 'Rent payment',
            'metadata'                  => [
                'type'           => 'rent',
                'studentid'      => $studentId,
                'landlordid'     => $landlordId,
                'rentalid'       => $rentalId,
                'application_id' => $application->id,
                'group_id'       => $groupId ?? '',
                'month'          => $month,
                'year'           => $year,
                'for_date'       => $forDate ?? '',
            ],
        ]);

        $payment = RentPayment::create([
            'amount'           => $amount,
            'status'           => $pi->status,
            'stripe_intent_id' => $pi->id,
            'timestamp'        => now(),
            'rentalid'         => $rentalId,
            'studentid'        => $studentId,
            'landlordid'       => $landlordId,
            'group_id'         => $groupId,
            'application_id'   => $application->id,
        ]);

        if (Schema::hasColumn('rentpayment', 'for_date')) {
            $payment->for_date = $forDate;
        }
        if (Schema::hasColumn('rentpayment', 'paid_by')) {
            $student          = \App\Models\Student::find($studentId);
            $payment->paid_by = $student ? trim(($student->firstname) . ' ' . ($student->surname)) : null;
        }
        $payment->save();

        return response()->json([
            'client_secret'  => $pi->client_secret,
            'payment_intent' => $pi->id,
        ], 201);
    }

    public function confirmPayment(Request $request)
    {
        $request->validate(['payment_intent' => 'required|string']);
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $pi = \Stripe\PaymentIntent::retrieve($request->payment_intent);

        if ($pi->status === 'succeeded') {
            $payment = RentPayment::where('stripe_intent_id', $pi->id)->first();
            if ($payment && $payment->status !== 'succeeded') {
                $payment->update(['status' => 'succeeded', 'timestamp' => now()]);
            }
            return response()->json(['ok' => true]);
        }

        return response()->json(['ok' => false, 'status' => $pi->status]);
    }

    public function page(Request $request, int $application)
    {
        $studentId = session('student_id') ?? session('landlord_id');
        abort_if(!$studentId, 401);

        $app = Application::with(['rental.landlord', 'student', 'group'])->findOrFail($application);
        abort_unless($this->canAccess($studentId, $app), 403);

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

        return view('student.rent-tracker', [
            'application'  => $app,
            'groupId'      => $groupId,
            'viewerId'     => $studentId,
            'groupMembers' => $groupMembers,
        ]);
    }

    private function canAccess(int $studentId, Application $app): bool
    {
        if ($app->status !== 'accepted') return false;

        if ($app->applicationtype === 'group' && $app->group_id) {
            $inGroup = DB::table('student_groups')
                ->where('group_id', $app->group_id)
                ->where('student_id', $studentId)
                ->exists();

            return $inGroup || $app->studentid == $studentId;
        }

        return $app->studentid == $studentId;
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

        $dueDay = $app->rent_due_day
            ?? ($availableFrom ? (int)$availableFrom->format('d') : 1);

        $eom           = Carbon::create($year, $month, 1, 0, 0, 0, $tz)->endOfMonth()->day;
        $dueDayClamped = max(1, min($dueDay, $eom));

        $dueDate = Carbon::create($year, $month, $dueDayClamped, 0, 0, 0, $tz)->startOfDay();

        // ✅ roll forward to next month if this month’s due date already passed
        if ($dueDate->lt(Carbon::now($tz)->startOfDay())) {
            $dueDate->addMonthNoOverflow();
        }

        $remindOn  = (clone $dueDate)->subDays(2);
        $overdueOn = (clone $dueDate)->addDays(1);

        return [
            $perPerson,
            $dueDate->toIso8601String(),
            $remindOn->toIso8601String(),
            $overdueOn->toIso8601String()
        ];
    }
}