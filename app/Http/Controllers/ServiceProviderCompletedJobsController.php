<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ServiceProviderPartnership;

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

    $providerRequests = collect();

    return view('serviceprovider.completed', compact('providerRequests'));
}
}