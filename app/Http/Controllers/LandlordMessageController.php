<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Landlord;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LandlordMessageController extends Controller
{
    public function index()
    {
        $landlordId = session('landlord_id');

        $applications = Application::with(['student', 'rental'])
            ->whereHas('rental', function ($query) use ($landlordId) {
                $query->where('landlordid', $landlordId);
            })
            ->get()
            ->filter(function ($application) {
                return Message::where('studentid', $application->studentid)
                    ->where('rentalid', $application->rentalid)
                    ->exists();
            })
                ->sortByDesc(function ($application) {
                    return Message::where('studentid', $application->studentid)
                        ->where('rentalid', $application->rentalid)
                        ->max('created_at');
                })
                ->values();

        return view('landlord.messages.index', compact('applications'));
    }


    public function show($applicationId)
    {
        $application = Application::with(['student', 'rental'])->findOrFail($applicationId);

        if ($application->applicationtype === 'group' && $application->group_id) {

            Message::where('group_id', $application->group_id)
                ->where('rentalid', $application->rentalid)
                ->where('sender_type', 'student')
                ->where('is_read_by_landlord', false)
                ->update([
                    'is_read_by_landlord' => true,
                ]);

            $messages = Message::where('group_id', $application->group_id)
                ->where('rentalid', $application->rentalid)
                ->orderBy('created_at', 'asc')
                ->get();

            $groupMembers = \Illuminate\Support\Facades\DB::table('student_groups')
                ->join('student', 'student.id', '=', 'student_groups.student_id')
                ->where('student_groups.group_id', $application->group_id)
                ->select('student.id', 'student.firstname', 'student.surname')
                ->get();

        } else {

            Message::where('studentid', $application->studentid)
                ->where('rentalid', $application->rentalid)
                ->where('sender_type', 'student')
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
}