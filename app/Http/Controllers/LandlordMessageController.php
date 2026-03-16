<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Message;
use Illuminate\Http\Request;

class LandlordMessageController extends Controller
{
    public function show($applicationId)
    {
        $application = Application::with(['student', 'rental'])->findOrFail($applicationId);

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
            'timestamp' => now(),
            'studentid' => $application->studentid,
            'landlordid' => $application->rental->landlordid,
            'rentalid' => $application->rentalid,
            'serviceproviderpartnershipid' => null,
        ]);

        return redirect()->route('landlord.messages.show', $application->id)
            ->with('success', 'Message sent successfully.');
    }
}