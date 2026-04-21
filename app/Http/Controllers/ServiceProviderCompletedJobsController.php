<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ServiceProviderPartnership;
use App\Models\ServiceRequest;

class ServiceProviderCompletedJobsController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return view('serviceprovider.completed', [
                'providerRequests' => collect(),
            ]);
        }

        $serviceProvider = ServiceProviderPartnership::where('email', Auth::user()->email)->first();

        if (!$serviceProvider) {
            return view('serviceprovider.completed', [
                'providerRequests' => collect(),
            ]);
        }

        $providerRequests = ServiceRequest::where('serviceproviderpartnershipid', $serviceProvider->id)
            ->where('status', 'completed')
            ->latest()
            ->get();

        return view('serviceprovider.completed', compact('providerRequests'));
    }
}