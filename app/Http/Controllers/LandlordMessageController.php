<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Landlord;
use App\Models\Message;
use Illuminate\Http\Request;

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
            });

        return view('landlord.messages.index', compact('applications'));
    }

    public function show($applicationId)
    {
        $application = Application::with(['student', 'rental'])->findOrFail($applicationId);

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

        return view('landlord.rentals.message-student', compact('application', 'messages'));
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