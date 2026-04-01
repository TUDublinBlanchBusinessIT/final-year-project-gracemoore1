<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\ServiceRequestProvider;
use Illuminate\Support\Facades\DB;

class ServiceProviderRequestedJobsController extends Controller
{
    public function index()
    {
        $serviceProviderId = session('serviceprovider_id');

        $requestedJobs = ServiceRequestProvider::with('serviceRequest')
            ->where('serviceproviderpartnershipid', $serviceProviderId)
            ->whereIn('status', ['pending', 'accepted'])
            ->latest()
            ->get();

        return view('serviceprovider.requested', compact('requestedJobs'));
    }

    public function accept($id)
    {
        $serviceProviderId = session('serviceprovider_id');

        DB::beginTransaction();

        try {
            $providerRequest = ServiceRequestProvider::where('id', $id)
                ->where('serviceproviderpartnershipid', $serviceProviderId)
                ->lockForUpdate()
                ->firstOrFail();

            $serviceRequest = ServiceRequest::where('id', $providerRequest->servicerequestid)
                ->lockForUpdate()
                ->firstOrFail();

            if ($providerRequest->status !== 'pending' || $serviceRequest->status !== 'pending') {
                DB::rollBack();
                return back()->with('error', 'This job is no longer available.');
            }

            $providerRequest->update([
                'status' => 'accepted',
                'responded_at' => now(),
            ]);

            $serviceRequest->update([
                'status' => 'accepted',
                'serviceproviderpartnershipid' => $serviceProviderId,
            ]);

            ServiceRequestProvider::where('servicerequestid', $serviceRequest->id)
                ->where('id', '!=', $providerRequest->id)
                ->where('status', 'pending')
                ->update([
                    'status' => 'closed',
                    'responded_at' => now(),
                ]);

            DB::commit();

            return back()->with('success', 'Job accepted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Could not accept this job.');
        }
    }

    public function decline($id)
    {
        $serviceProviderId = session('serviceprovider_id');

        $providerRequest = ServiceRequestProvider::where('id', $id)
            ->where('serviceproviderpartnershipid', $serviceProviderId)
            ->firstOrFail();

        if ($providerRequest->status !== 'pending') {
            return back()->with('error', 'This job can no longer be declined.');
        }

        $providerRequest->update([
            'status' => 'declined',
            'responded_at' => now(),
        ]);

        return back()->with('success', 'Job declined.');
    }
}