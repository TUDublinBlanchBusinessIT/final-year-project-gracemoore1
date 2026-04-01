<?php

namespace App\Http\Controllers;

use App\Models\Maintenancelog;
use App\Models\LandlordRental;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestProvider;
use App\Models\ServiceProviderPartnership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandlordServiceRequestController extends Controller
{
    public function create($id)
    {
        $log = Maintenancelog::findOrFail($id);
        $rental = LandlordRental::findOrFail($log->rentalid);

        return view('landlord.maintenance.book-service-provider', compact('log', 'rental'));
    }

    public function store(Request $request, $id)
    {
        $log = Maintenancelog::findOrFail($id);
        $rental = LandlordRental::findOrFail($log->rentalid);

        $validated = $request->validate([
            'servicetype' => 'required|in:Plumbing,Electrician,Cleaning,Estate Agent,Other',
            'housenumber' => 'nullable|string|max:50',
            'street' => 'required|string|max:255',
            'county' => 'required|string|max:100',
            'postcode' => 'nullable|string|max:50',
            'description' => 'required|string',
            'image' => 'nullable|image|max:4096',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('service-requests', 'public');
        }

        DB::beginTransaction();

        try {
            $serviceRequest = ServiceRequest::create([
                'servicetype' => $validated['servicetype'],
                'description' => $validated['description'],
                'requesteddatetime' => now(),
                'status' => 'pending',
                'jobcost' => null,
                'completionimage' => null,
                'completiontimestamp' => null,
                'paymentstatus' => null,
                'paymenttimestamp' => null,
                'propertyid' => $log->propertyid ?? null,
                'landlordid' => session('landlord_id'),
                'rentalid' => $log->rentalid,
                'serviceproviderpartnershipid' => null,
                'address_housenumber' => $validated['housenumber'] ?? null,
                'address_street' => $validated['street'],
                'address_county' => $validated['county'],
                'address_postcode' => $validated['postcode'] ?? null,
                'requestimage' => $imagePath,
            ]);

            $matchingProviders = ServiceProviderPartnership::where('county', $validated['county'])
                ->where('servicetype', $validated['servicetype'])
                ->get();

            foreach ($matchingProviders as $provider) {
                ServiceRequestProvider::create([
                    'servicerequestid' => $serviceRequest->id,
                    'serviceproviderpartnershipid' => $provider->id,
                    'status' => 'pending',
                ]);
            }

            DB::commit();

            return redirect()->back()->with(
                'success',
                $matchingProviders->isEmpty()
                    ? 'Request created, but no matching service providers were found in that county.'
                    : 'Service request created and matching providers have been notified.'
            );
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                //->with('error', 'Error: ' . $e->getMessage());
                ->with('error', 'Something went wrong while creating the service request.');
        }
    }
}