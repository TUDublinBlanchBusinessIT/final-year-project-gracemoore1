<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\ServiceRequestProvider;
use Illuminate\Http\Request;

class ServiceProviderUpcomingJobsController extends Controller
{
    public function index()
    {
        $serviceProviderId = session('serviceprovider_id');
        abort_if(!$serviceProviderId, 401);

        $upcomingJobs = ServiceRequestProvider::with('serviceRequest')
            ->where('serviceproviderpartnershipid', $serviceProviderId)
            ->where('status', 'assigned')
            ->latest()
            ->get();

        return view('serviceprovider.upcoming', compact('upcomingJobs'));
    }

    public function completed()
    {
        $serviceProviderId = session('serviceprovider_id');
        abort_if(!$serviceProviderId, 401);

        $completedJobs = ServiceRequestProvider::with('serviceRequest')
            ->where('serviceproviderpartnershipid', $serviceProviderId)
            ->where('status', 'completed')
            ->latest()
            ->get();

        return view('serviceprovider.completed', compact('completedJobs'));
    }    

    public function markCompleted($id)
    {
        $serviceProviderId = session('serviceprovider_id');
        abort_if(!$serviceProviderId, 401);

        $providerRequest = ServiceRequestProvider::with(['serviceRequest', 'provider'])
            ->where('id', $id)
            ->where('serviceproviderpartnershipid', $serviceProviderId)
            ->where('status', 'assigned')
            ->firstOrFail();

        $job = $providerRequest->serviceRequest;

        $providerRequest->update([
            'status' => 'completed',
            'responded_at' => now(),
        ]);

        $providerName = trim(($providerRequest->provider->firstname ?? '') . ' ' . ($providerRequest->provider->surname ?? ''));
        $providerName = $providerName !== '' ? $providerName : 'The service provider';

        Message::create([
            'content' => '✅ ' . $providerName . ' marked this job as completed.',
            'sender_type' => 'system',
            'timestamp' => now(),
            'studentid' => null,
            'group_id' => null,
            'landlordid' => $job->landlordid,
            'rentalid' => $job->rentalid,
            'serviceproviderpartnershipid' => $serviceProviderId,
            'is_read_by_student' => true,
            'is_read_by_landlord' => false,
            'is_read_by_service_provider' => true,
        ]);

        return redirect()
            ->route('serviceprovider.upcoming')
            ->with('success', 'Job marked as completed.');
    }
}