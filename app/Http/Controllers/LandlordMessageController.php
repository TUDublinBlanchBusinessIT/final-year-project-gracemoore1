<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceRequestProvider;
use App\Models\LandlordRental;
use App\Models\ServiceProviderPartnership;

class LandlordMessageController extends Controller
{
    public function index()
    {
        $landlordId = session('landlord_id');
        $filter = request('filter', 'all');

        $applications = Application::with(['student', 'rental', 'group'])
            ->whereHas('rental', function ($query) use ($landlordId) {
                $query->where('landlordid', $landlordId);
            })
            ->get()
            ->filter(function ($application) {
                if ($application->applicationtype === 'group' && $application->group_id) {
                    return Message::where('group_id', $application->group_id)
                        ->where('rentalid', $application->rentalid)
                        ->exists();
                }

                return Message::where('studentid', $application->studentid)
                    ->where('rentalid', $application->rentalid)
                    ->exists();
            })
            ->filter(function ($application) use ($filter) {
                if ($filter === 'group') {
                    return $application->applicationtype === 'group';
                }

                if ($filter === 'individual') {
                    return $application->applicationtype !== 'group';
                }

                if ($filter === 'unread') {
                    if ($application->applicationtype === 'group' && $application->group_id) {
                        return Message::where('group_id', $application->group_id)
                            ->where('rentalid', $application->rentalid)
                            ->where('sender_type', '!=', 'landlord')
                            ->where('is_read_by_landlord', false)
                            ->exists();
                    }

                    return Message::where('studentid', $application->studentid)
                        ->where('rentalid', $application->rentalid)
                        ->where('sender_type', '!=', 'landlord')
                        ->where('is_read_by_landlord', false)
                        ->exists();
                }

                return true;
            })
            ->sortByDesc(function ($application) {
                if ($application->applicationtype === 'group' && $application->group_id) {
                    return Message::where('group_id', $application->group_id)
                        ->where('rentalid', $application->rentalid)
                        ->max('created_at');
                }

                return Message::where('studentid', $application->studentid)
                    ->where('rentalid', $application->rentalid)
                    ->max('created_at');
            })
            ->values();

        $serviceProviderConversations = Message::where('landlordid', $landlordId)
            ->whereNotNull('serviceproviderpartnershipid')
            ->whereNull('studentid')
            ->whereNull('group_id')
            ->get()
            ->groupBy(function ($message) {
                return $message->serviceproviderpartnershipid . '_' . $message->rentalid;
            });

        return view('landlord.messages.index', compact('applications', 'serviceProviderConversations'));
    }

    public function show($applicationId)
    {
        $application = Application::with(['student', 'rental'])->findOrFail($applicationId);

        if ($application->applicationtype === 'group' && $application->group_id) {
            Message::where('group_id', $application->group_id)
                ->where('rentalid', $application->rentalid)
                ->where('sender_type', '!=', 'landlord')
                ->where('is_read_by_landlord', false)
                ->update([
                    'is_read_by_landlord' => true,
                ]);

            $messages = Message::where('group_id', $application->group_id)
                ->where('rentalid', $application->rentalid)
                ->orderBy('created_at', 'asc')
                ->get();

            $groupMembers = DB::table('student_groups')
                ->join('student', 'student.id', '=', 'student_groups.student_id')
                ->where('student_groups.group_id', $application->group_id)
                ->select('student.id', 'student.firstname', 'student.surname')
                ->get();
        } else {
            Message::where('studentid', $application->studentid)
                ->where('rentalid', $application->rentalid)
                ->where('sender_type', '!=', 'landlord')
                ->where('is_read_by_landlord', false)
                ->update([
                    'is_read_by_landlord' => true,
                ]);

            $messages = Message::where('studentid', $application->studentid)
                ->where('rentalid', $application->rentalid)
                ->orderBy('created_at', 'asc')
                ->get();

            $groupMembers = collect();
        }

        return view('landlord.rentals.message-student', compact('application', 'messages', 'groupMembers'));
    }

    public function store(Request $request, $applicationId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $application = Application::with(['rental'])->findOrFail($applicationId);

        Message::create([
            'content' => $request->message,
            'sender_type' => 'landlord',
            'timestamp' => now(),
            'studentid' => $application->studentid,
            'group_id' => $application->group_id,
            'landlordid' => $application->rental->landlordid,
            'rentalid' => $application->rentalid,
            'serviceproviderpartnershipid' => null,
            'is_read_by_student' => false,
            'is_read_by_landlord' => true,
        ]);

        return redirect()->route('landlord.messages.show', $application->id)
            ->with('success', 'Message sent successfully.');
    }

    public function showServiceProvider($providerRequestId)
    {
        $landlordId = session('landlord_id');
        abort_if(!$landlordId, 401);

        $providerRequest = ServiceRequestProvider::with(['serviceRequest', 'provider'])
            ->findOrFail($providerRequestId);

        $job = $providerRequest->serviceRequest;

        abort_unless($job && $job->landlordid == $landlordId, 403);

        Message::where('landlordid', $landlordId)
            ->where('serviceproviderpartnershipid', $providerRequest->serviceproviderpartnershipid)
            ->where('rentalid', $job->rentalid)
            ->whereNull('studentid')
            ->whereNull('group_id')
            ->where('sender_type', '!=', 'landlord')
            ->where('is_read_by_landlord', false)
            ->update([
                'is_read_by_landlord' => true,
            ]);

        $messages = Message::where('landlordid', $landlordId)
            ->where('serviceproviderpartnershipid', $providerRequest->serviceproviderpartnershipid)
            ->where('rentalid', $job->rentalid)
            ->whereNull('studentid')
            ->whereNull('group_id')
            ->orderBy('created_at', 'asc')
            ->get();

        $provider = ServiceProviderPartnership::find($providerRequest->serviceproviderpartnershipid);
        $rental = LandlordRental::find($job->rentalid);

        return view('landlord.messages.service-provider-chat', compact('providerRequest', 'job', 'messages', 'provider', 'rental'));
    }

    public function storeServiceProvider(Request $request, $providerRequestId)
    {
        $landlordId = session('landlord_id');
        abort_if(!$landlordId, 401);

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $providerRequest = ServiceRequestProvider::with('serviceRequest')
            ->findOrFail($providerRequestId);

        $job = $providerRequest->serviceRequest;

        abort_unless($job && $job->landlordid == $landlordId, 403);

        Message::create([
            'content' => $request->message,
            'sender_type' => 'landlord',
            'timestamp' => now(),
            'studentid' => null,
            'group_id' => null,
            'landlordid' => $landlordId,
            'rentalid' => $job->rentalid,
            'serviceproviderpartnershipid' => $providerRequest->serviceproviderpartnershipid,
            'is_read_by_student' => true,
            'is_read_by_landlord' => true,
            'is_read_by_service_provider' => false,
        ]);

        return redirect()
            ->route('landlord.service-provider.messages.show', $providerRequest->id);
            
    }
}