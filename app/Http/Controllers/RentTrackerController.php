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
    /** GET /student/rent-tracker/balance */
    public function getBalance(Request $request)
    {
        $request->validate([
            'application_id' => 'required|integer',
            'group_id'       => 'nullable|integer',
            'month'          => 'nullable|integer|min:1|max:12',
            'year'           => 'nullable|integer|min:2000|max:2100',
        ]);

        $studentId = session('student_id');
        abort_if(!$studentId, 401);

        $application = Application::with('rental')->findOrFail($request->application_id);
        abort_unless($this->canAccess($studentId, $application), 403);

        $month = (int)($request->month ?? now()->month);
        $year  = (int)($request->year  ?? now()->year);

        $groupFilter = $this->normalizeGroupId($application, $request->group_id);
        [$monthlyDue, $dueDateIso, $remindOnIso] = $this->computeDue($application, $month, $year);

        $paid = RentPayment::query()
            ->where('application_id', $application->id)
            ->when($groupFilter['type'] === 'value', fn ($q) => $q->where('group_id', $groupFilter['value']))
            ->when($groupFilter['type'] === 'null_or_zero', function ($q) {
                $q->where(function ($qq) {
                    $qq->whereNull('group_id')->orWhere('group_id', 0);
                });
            })
            ->where('status', 'succeeded')
            ->whereMonth('timestamp', $month)
            ->whereYear('timestamp', $year)
            ->sum('amount');

        return response()->json([
            'monthly_due'   => number_format($monthlyDue, 2),
            'paid'          => number_format($paid, 2),
            'outstanding'   => number_format(max(0, $monthlyDue - $paid), 2),
            'due_date_iso'  => $dueDateIso,
            'remind_on_iso' => $remindOnIso,
            'month'         => $month,
            'year'          => $year,
        ]);
    }

    /** GET /student/rent-tracker/history */
    public function getHistory(Request $request)
    {
        $request->validate([
            'application_id' => 'required|integer',
            'group_id'       => 'nullable|integer',
            'month'          => 'nullable|integer|min:1|max:12',
            'year'           => 'nullable|integer|min:2000|max:2100',
            'all'            => 'nullable|boolean',
        ]);

        $studentId = session('student_id');
        abort_if(!$studentId, 401, 'Login required.');

        $application = Application::with('rental')->findOrFail($request->application_id);
        abort_unless($this->canAccess((int)$studentId, $application), 403);

        $all   = filter_var($request->query('all'), FILTER_VALIDATE_BOOLEAN);
        $month = (int)($request->month ?? now()->month);
        $year  = (int)($request->year  ?? now()->year);

        $groupFilter = $this->normalizeGroupId($application, $request->group_id);

        $query = RentPayment::query()
            ->where('application_id', $application->id)
            ->when($groupFilter['type'] === 'value', fn($q) => $q->where('group_id', $groupFilter['value']))
            ->when($groupFilter['type'] === 'null_or_zero', function ($q) {
                $q->where(function ($qq) {
                    $qq->whereNull('group_id')->orWhere('group_id', 0);
                });
            });

        if (!$all) {
            $query->whereMonth('timestamp', $month)
                  ->whereYear('timestamp', $year);
        }

        // Build select list dynamically to avoid errors if columns don't exist
        $table   = (new RentPayment)->getTable();
        $selects = ['id','amount','status','timestamp','stripe_intent_id','studentid','landlordid'];

        if (Schema::hasColumn($table, 'for_date')) $selects[] = 'for_date';
        if (Schema::hasColumn($table, 'paid_by'))  $selects[] = 'paid_by';

        $items = $query->orderByDesc('timestamp')->get($selects);

        // --------- Inject a virtual "reminder" bubble in the feed (left, blue) ----------
        [$monthlyDue, $dueDateIso, $remindOnIso] = $this->computeDue($application, $month, $year);

        // How much has been paid in the requested month/year (respecting group)
        $paidThisMonth = RentPayment::query()
            ->where('application_id', $application->id)
            ->when($groupFilter['type'] === 'value', fn($q) => $q->where('group_id', $groupFilter['value']))
            ->when($groupFilter['type'] === 'null_or_zero', function ($q) {
                $q->where(function ($qq) {
                    $qq->whereNull('group_id')->orWhere('group_id', 0);
                });
            })
            ->where('status', 'succeeded')
            ->whereMonth('timestamp', $month)
            ->whereYear('timestamp', $year)
            ->sum('amount');

        $outstanding = max(0, $monthlyDue - $paidThisMonth);
        $now = now();

        if ($outstanding > 0) {
            $due = Carbon::parse($dueDateIso);
            $remindOn = Carbon::parse($remindOnIso);

            // Show the reminder bubble when today is between remind_on and due_date (inclusive)
            $isCurrentMonth = ($month === (int)$now->month && $year === (int)$now->year);
            if (($isCurrentMonth || $request->boolean('all'))
                && $now->greaterThanOrEqualTo($remindOn)
                && $now->lessThanOrEqualTo($due)) {

                $items->push((object)[
                    'id'        => 'reminder-'.$year.'-'.$month,
                    'amount'    => $outstanding,
                    'status'    => 'reminder', // <-- frontend styles this left + blue
                    'timestamp' => $remindOn->toIso8601String(),
                    'for_date'  => $due->toDateString(),
                    'paid_by'   => null,
                    'studentid' => null,
                    'landlordid'=> $application->rental->landlordid ?? null,
                ]);
            }
        }

        // Re-sort with injected item included (newest first for API payload)
        $items = $items->sortByDesc('timestamp')->values();

        return response()->json([
            'month'   => $month,
            'year'    => $year,
            'history' => $items,
        ]);
    }

    /** POST /student/rent-tracker/payment-intent */
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'application_id' => 'required|integer',
            'group_id'       => 'nullable|integer',
            'amount_eur'     => 'nullable|numeric|min:0',
            'for_date'       => 'nullable|date',  // calendar date
            'month'          => 'nullable|integer',
            'year'           => 'nullable|integer',
        ]);

        $studentId = session('student_id');
        abort_if(!$studentId, 401);

        $application = Application::with('rental')->findOrFail($request->application_id);
        abort_unless($this->canAccess($studentId, $application), 403);

        // compute against current month/year for outstanding
        $month = (int)($request->month ?? now()->month);
        $year  = (int)($request->year  ?? now()->year);

        [$monthlyDue] = $this->computeDue($application, $month, $year);

        $groupFilter  = $this->normalizeGroupId($application, $request->group_id);
        $groupId      = $groupFilter['type'] === 'value' ? $groupFilter['value'] : null;

        $paid = RentPayment::query()
            ->where('application_id', $application->id)
            ->when($groupFilter['type'] === 'value', fn ($q) => $q->where('group_id', $groupId))
            ->when($groupFilter['type'] === 'null_or_zero', function ($q) {
                $q->where(function ($qq) { $qq->whereNull('group_id')->orWhere('group_id', 0); });
            })
            ->where('status', 'succeeded')
            ->whereMonth('timestamp', $month)
            ->whereYear('timestamp', $year)
            ->sum('amount');

        $outstanding = max(0, $monthlyDue - $paid);
        $amount = $request->filled('amount_eur') ? (float)$request->amount_eur : $outstanding;
        abort_if($amount <= 0, 422, 'Nothing due');

        $landlordId = (int)($application->rental->landlordid ?? 0);
        $rentalId   = (int)$application->rentalid;
        $forDate    = $request->for_date ? Carbon::parse($request->for_date)->toDateString() : null;

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $pi = \Stripe\PaymentIntent::create([
            'amount'                    => (int) round($amount * 100),
            'currency'                  => 'eur',
            'automatic_payment_methods' => ['enabled' => true], // card, Link, wallets
            'description'               => 'Rent payment',
            'metadata'                  => [
                'type'           => 'rent',
                'studentid'      => (string) $studentId,
                'landlordid'     => (string) $landlordId,
                'rentalid'       => (string) $rentalId,
                'application_id' => (string) $application->id,
                'group_id'       => (string) ($groupId ?? ''),
                'month'          => (string) $month,
                'year'           => (string) $year,
                'for_date'       => (string) ($forDate ?? ''),
            ],
        ]);

        // Create pending payment row
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

        // Optional persistence of "for_date" + "paid_by" (only if columns exist)
        $table = $payment->getTable();
        $dirty = false;
        if (Schema::hasColumn($table, 'for_date')) {
            $payment->for_date = $forDate;
            $dirty = true;
        }
        if (Schema::hasColumn($table, 'paid_by')) {
            $student = \App\Models\Student::find($studentId);
            $payment->paid_by = $student ? trim(($student->firstname ?? '').' '.($student->surname ?? '')) : null;
            $dirty = true;
        }
        if ($dirty) $payment->save();

        return response()->json([
            'client_secret'  => $pi->client_secret,
            'payment_intent' => $pi->id,
        ], 201);
    }

    /** POST /student/rent-tracker/confirm-payment */
    public function confirmPayment(Request $request)
    {
        $request->validate([
            'payment_intent' => 'required|string',
        ]);

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $pi = \Stripe\PaymentIntent::retrieve($request->payment_intent);

        if ($pi->status === 'succeeded') {
            $payment = RentPayment::where('stripe_intent_id', $pi->id)->first();
            if ($payment && $payment->status !== 'succeeded') {
                $payment->update([
                    'status'    => 'succeeded',
                    'timestamp' => now(),
                ]);
            }
            return response()->json(['ok' => true]);
        }

        return response()->json(['ok' => false, 'status' => $pi->status]);
    }

    /** Full-page view */
    public function page(Request $request, int $application)
    {
        $studentId = (int) session('student_id');
        abort_if(!$studentId, 401);

        $app = Application::with(['rental.landlord', 'student', 'group'])->findOrFail($application);
        abort_unless($this->canAccess($studentId, $app), 403);

        $groupId = null;
        $groupMembers = collect();

        if (($app->applicationtype ?? '') === 'group' && $app->group_id) {
            $groupId = (int) ($request->query('group_id') ?: $app->group_id);

            // IMPORTANT: singular table names ("student"), not "students"
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

    /* ---------------- HELPERS ---------------- */

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

    /**
     * Compute per-person monthly due and dates.
     * Returns: [ float $perPerson, string $dueDateIso, string $remindOnIso ]
     */
    private function computeDue($app, int $month, int $year)
    {
        $rent = $app->rental->rentpermonth ?? 0;
        $groupMembers = 1;

        if ($app->group_id) {
            $groupMembers = DB::table('student_groups')
                ->where('group_id', $app->group_id)
                ->count();
            $groupMembers = max(1, $groupMembers);
        }

        $perPerson = round($rent / $groupMembers, 2);

        // Use rental-configured due_day if present; otherwise default to 1
        $dueDay = (int)($app->rental->due_day ?? 1);
        $tz = config('app.timezone');

        $eom = Carbon::create($year, $month, 1, 0, 0, 0, $tz)->endOfMonth()->day;
        $dueDayClamped = max(1, min($dueDay, $eom));

        // Due at 09:00 local time
        $dueDate   = Carbon::create($year, $month, $dueDayClamped, 9, 0, 0, $tz);
        $remindOn  = (clone $dueDate)->subDays(2); // e.g., 27th due -> 25th reminder

        return [$perPerson, $dueDate->toIso8601String(), $remindOn->toIso8601String()];
    }
}