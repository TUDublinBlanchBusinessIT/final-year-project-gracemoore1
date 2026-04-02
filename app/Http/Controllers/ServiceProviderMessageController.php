<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequestProvider;
use Illuminate\Http\Request;

class ServiceProviderMessageController extends Controller
{
    public function index()
    {
        $serviceProviderId = session('serviceprovider_id');
        abort_if(!$serviceProviderId, 401);

        $conversations = ServiceRequestProvider::with(['serviceRequest'])
            ->where('serviceproviderpartnershipid', $serviceProviderId)
            ->whereIn('status', ['pending', 'messaged', 'assigned'])
            ->latest()
            ->get();

        return view('serviceprovider.messages', compact('conversations'));
    }

        public function show($id)
    {
        $serviceProviderId = session('serviceprovider_id');
        abort_if(!$serviceProviderId, 401);

        $conversation = \App\Models\ServiceRequestProvider::with(['serviceRequest', 'provider'])
            ->where('id', $id)
            ->where('serviceproviderpartnershipid', $serviceProviderId)
            ->firstOrFail();

        return view('serviceprovider.chat', compact('conversation'));
    }
}