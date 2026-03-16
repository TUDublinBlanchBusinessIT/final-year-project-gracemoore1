<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Message;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentMessageController extends Controller
{
    public function index()
    {
        $studentId = session('student_id');

        $applications = Application::with(['rental.landlord', 'student'])
            ->where('studentid', $studentId)
            ->get()
            ->filter(function ($application) {
                return Message::where('studentid', $application->studentid)
                    ->where('rentalid', $application->rentalid)
                    ->exists();
            });

        return view('student.messages.index', compact('applications'));
    }

    public function show($applicationId)
    {
        $studentId = session('student_id');

        $application = Application::with(['rental.landlord', 'student'])
            ->where('id', $applicationId)
            ->where('studentid', $studentId)
            ->firstOrFail();

        Message::where('studentid', $application->studentid)
            ->where('rentalid', $application->rentalid)
            ->where('sender_type', 'landlord')
            ->where('is_read_by_student', false)
            ->update([
                'is_read_by_student' => true,
            ]);

        $messages = Message::where('studentid', $application->studentid)
            ->where('rentalid', $application->rentalid)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('student.messages.chat', compact('application', 'messages'));
    }

    public function store(Request $request, $applicationId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $studentId = session('student_id');

        $application = Application::with(['rental.landlord', 'student'])
            ->where('id', $applicationId)
            ->where('studentid', $studentId)
            ->firstOrFail();

        Message::create([
            'content' => $request->message,
            'sender_type' => 'student',
            'timestamp' => now(),
            'studentid' => $application->studentid,
            'landlordid' => $application->rental->landlordid,
            'rentalid' => $application->rentalid,
            'serviceproviderpartnershipid' => null,
            'is_read_by_student' => true,
            'is_read_by_landlord' => false,
        ]);

        return redirect()->route('student.messages.show', $application->id);
    }
}