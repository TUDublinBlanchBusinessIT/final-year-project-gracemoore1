<?php

namespace App\Http\Controllers;

use App\Models\Landlord;
use App\Models\Message;
use App\Models\ServiceRequestProvider;
use Illuminate\Http\Request;

class ServiceProviderMessageController extends Controller
{
    public function index()
    {
        $providerId = session('serviceprovider_id');

        $conversations = \App\Models\Message::where('serviceproviderpartnershipid', $providerId)
            ->whereNull('studentid')
            ->whereNull('group_id')
            ->get()
            ->groupBy(function ($message) {
                return $message->landlordid . '_' . $message->rentalid;
            });

        return view('serviceprovider.messages', compact('conversations'));
    }

    public function show($id)
    {
        $serviceProviderId = session('serviceprovider_id');
        abort_if(!$serviceProviderId, 401);

        $conversation = ServiceRequestProvider::with(['serviceRequest', 'provider'])
            ->where('id', $id)
            ->where('serviceproviderpartnershipid', $serviceProviderId)
            ->firstOrFail();

        $job = $conversation->serviceRequest;

        Message::where('serviceproviderpartnershipid', $serviceProviderId)
            ->where('landlordid', $job->landlordid)
            ->where('rentalid', $job->rentalid)
            ->where('sender_type', '!=', 'service_provider')
            ->where('is_read_by_service_provider', false)
            ->update([
                'is_read_by_service_provider' => true,
            ]);

        $landlord = Landlord::find($job->landlordid);

        // ✅ Banner flag: landlord banned?
        $isOtherAccountBanned = false;
        $otherAccountRole = 'landlord';

        if ($landlord) {
            $isOtherAccountBanned = (($landlord->status ?? null) === 'suspended');
        }

        $messages = Message::where('landlordid', $job->landlordid)
            ->where('serviceproviderpartnershipid', $serviceProviderId)
            ->where('rentalid', $job->rentalid)
            ->whereNull('studentid')
            ->whereNull('group_id')
            ->orderBy('timestamp', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('serviceprovider.chat', compact('conversation', 'landlord', 'messages','isOtherAccountBanned','otherAccountRole'));
    }

    public function store(Request $request, $id)
    {
        $serviceProviderId = session('serviceprovider_id');
        abort_if(!$serviceProviderId, 401);

        $conversation = ServiceRequestProvider::with('serviceRequest')
            ->where('id', $id)
            ->where('serviceproviderpartnershipid', $serviceProviderId)
            ->firstOrFail();

        $job = $conversation->serviceRequest;

        if ($request->has('invoice_items')) {
        $items = collect($request->invoice_items)
            ->filter(fn($item) => !empty($item['detail']) && isset($item['amount']) && $item['amount'] > 0)
            ->values()
            ->toArray();

        $total = collect($items)->sum('amount');

        Message::create([
            'content'                      => null,
            'sender_type'                  => 'invoice',
            'invoice_data'                 => json_encode($items),
            'invoice_amount'               => $total,
            'invoice_paid'                 => 0,
            'timestamp'                    => now(),
            'studentid'                    => null,
            'group_id'                     => null,
            'landlordid'                   => $job->landlordid,
            'rentalid'                     => $job->rentalid,
            'serviceproviderpartnershipid' => $serviceProviderId,
            'is_read_by_student'           => true,
            'is_read_by_landlord'          => false,
            'is_read_by_service_provider'  => true,
        ]);

        if ($conversation->status === 'pending') {
            $conversation->update(['status' => 'messaged', 'responded_at' => now()]);
        }

        return redirect()->route('serviceprovider.messages.show', $conversation->id);
    }

        $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        Message::create([
            'content' => $request->content,
            'sender_type' => 'service_provider',
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

        if ($conversation->status === 'pending') {
            $conversation->update([
                'status' => 'messaged',
                'responded_at' => now(),
            ]);
        }

        return redirect()
            ->route('serviceprovider.messages.show', $conversation->id);
    }
}