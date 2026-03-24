<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\RentPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
        [$monthlyDue, $dueDateIso] = $this->computeDue($application, $month, $year);

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
            'monthly_due'  => number_format($monthlyDue, 2),
            'paid'         => number_format($paid, 2),
            'outstanding'  => number_format(max(0, $monthlyDue - $paid), 2),
            'due_date_iso' => $dueDateIso,
            'month'        => $month,
            'year'         => $year,
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

        $items = $query->orderByDesc('timestamp')
            ->get([
                'id',
                'amount',
                'status',
                'timestamp',
                'stripe_intent_id',
                'studentid',   // for left/right alignment
                'landlordid',
            ]);

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
            'for_date'       => 'nullable|date', // calendar date
            'month'          => 'nullable|integer',
            'year'           => 'nullable|integer',
        ]);

        $studentId = session('student_id');
        abort_if(!$studentId, 401);

        $application = Application::with('rental')->findOrFail($request->application_id);
        abort_unless($this->canAccess($studentId, $application), 403);

        // compute against current month (or provided) for outstanding
        $month = (int)($request->month ?? now()->month);
        $year  = (int)($request->year  ?? now()->year);

        [$monthlyDue] = $this->computeDue($application, $month, $year);
        $groupFilter  = $this->normalizeGroupId($application, $request->group_id);
        $groupId      = $groupFilter['type'] === 'value' ? $groupFilter['value'] : null;

        $paid = RentPayment::query()
            ->where('application_id', $application->id)
            ->when($groupFilter['type'] === 'value', fn ($q) => $q->where('group_id', $groupId))
            ->when($groupFilter['type'] === 'null_or_zero', function ($q) {
                $q->where(function ($qq) {
                    $qq->whereNull('group_id')->orWhere('group_id', 0);
                });
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
            'payment_method_types'      => ['link', 'card'],
            'automatic_payment_methods' => ['enabled' => true],
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
                'for_date'       => (string) ($forDate ?? ''), // calendar date
            ],
        ]);

        RentPayment::create([
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
        if (($app->applicationtype ?? '') === 'group' && $app->group_id) {
            $groupId = (int) ($request->query('group_id') ?: $app->group_id);
        }

        return view('student.rent-tracker', [
            'application' => $app,
            'groupId'     => $groupId,
            'viewerId'    => $studentId,
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

        // due date (first of month at 09:00 in app TZ)
        $dueDate = Carbon::create($year, $month, 1, 9, 0, 0, config('app.timezone'))->toIso8601String();

        return [$perPerson, $dueDate];
    }
}