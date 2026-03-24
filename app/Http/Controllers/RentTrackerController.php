<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\RentPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RentTrackerController extends Controller
{
    /**
     * GET /student/rent-tracker/balance
     */
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

        $month = $request->month ?? now()->month;
        $year  = $request->year ?? now()->year;

        $groupFilter = $this->normalizeGroupId($application, $request->group_id);
        [$monthlyDue, $dueDateIso] = $this->computeDue($application, $month, $year);

        $paid = RentPayment::query()
            ->where('application_id', $application->id)
            ->when($groupFilter['type'] === 'value', fn ($q) => $q->where('group_id', $groupFilter['value']))
            ->when($groupFilter['type'] === 'null_or_zero', fn ($q) => $q->whereNull('group_id')->orWhere('group_id', 0))
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

    /**
     * GET /student/rent-tracker/history
     */
    public function getHistory(Request $request)
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

        $month = $request->month ?? now()->month;
        $year  = $request->year ?? now()->year;

        $groupFilter = $this->normalizeGroupId($application, $request->group_id);

        $items = RentPayment::query()
            ->where('application_id', $application->id)
            ->when($groupFilter['type'] === 'value', fn ($q) => $q->where('group_id', $groupFilter['value']))
            ->when($groupFilter['type'] === 'null_or_zero', fn ($q) => $q->whereNull('group_id')->orWhere('group_id', 0))
            ->whereMonth('timestamp', $month)
            ->whereYear('timestamp', $year)
            ->orderByDesc('timestamp')
            ->get();

        return response()->json([
            'history' => $items,
            'month'   => $month,
            'year'    => $year,
        ]);
    }

    /**
     * POST /student/rent-tracker/payment-intent
     * Creates PaymentIntent only (no webhook).
     * Payment success will be manually confirmed later.
     */
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'application_id' => 'required|integer',
            'group_id'       => 'nullable|integer',
            'amount_eur'     => 'nullable|numeric|min:0',
            'month'          => 'nullable|integer',
            'year'           => 'nullable|integer',
        ]);

        $studentId = session('student_id');
        abort_if(!$studentId, 401);

        $application = Application::with('rental')->findOrFail($request->application_id);
        abort_unless($this->canAccess($studentId, $application), 403);

        $month = $request->month ?? now()->month;
        $year  = $request->year ?? now()->year;

        [$monthlyDue] = $this->computeDue($application, $month, $year);
        $groupFilter  = $this->normalizeGroupId($application, $request->group_id);

        $paid = RentPayment::query()
            ->where('application_id', $application->id)
            ->when($groupFilter['type'] === 'value', fn ($q) => $q->where('group_id', $groupFilter['value']))
            ->when($groupFilter['type'] === 'null_or_zero', fn ($q) => $q->whereNull('group_id')->orWhere('group_id', 0))
            ->where('status', 'succeeded')
            ->whereMonth('timestamp', $month)
            ->whereYear('timestamp', $year)
            ->sum('amount');

        $outstanding = max(0, $monthlyDue - $paid);
        $amount = $request->amount_eur ?? $outstanding;
        abort_if($amount <= 0, 422, 'Nothing due');

        // CREATE STRIPE PAYMENT INTENT
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $pi = \Stripe\PaymentIntent::create([
            'amount'   => (int) round($amount * 100),
            'currency' => 'eur',
            'payment_method_types' => ['link', 'card'],
        ]);

        // STORE pending record (status = requires_payment_method)
        RentPayment::create([
            'amount'           => $amount,
            'status'           => $pi->status,
            'stripe_intent_id' => $pi->id,
            'timestamp'        => now(),
            'rentalid'         => $application->rentalid,
            'studentid'        => $studentId,
            'landlordid'       => $application->rental->landlordid,
            'application_id'   => $application->id,
            'group_id'         => $groupFilter['value'],
        ]);

        return response()->json([
            'client_secret'  => $pi->client_secret,
            'payment_intent' => $pi->id,
        ]);
    }

    /**
     * POST /student/rent-tracker/confirm
     * After Stripe returns the user to your site, call this endpoint
     * to verify the payment status and update rentpayment.
     */
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

        $dueDate = Carbon::create($year, $month, 1)->toIso8601String();

        return [$perPerson, $dueDate];
    }
}