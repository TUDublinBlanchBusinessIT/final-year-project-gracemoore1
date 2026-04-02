<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequestProvider;

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
}