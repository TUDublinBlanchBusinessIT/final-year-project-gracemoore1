<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentMessageController extends Controller
{
    public function index()
    {
        $studentId = session('student_id');
        $filter = request('filter', 'all');

        $applications = Application::with(['rental.landlord', 'student', 'group'])
            ->where(function ($query) use ($studentId) {
                $query->where('studentid', $studentId)
                    ->orWhereIn('group_id', function ($subQuery) use ($studentId) {
                        $subQuery->select('group_id')
                            ->from('student_groups')
                            ->where('student_id', $studentId);
                    });
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
            ->filter(function ($application) use ($filter, $studentId) {
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
                            ->where('is_read_by_student', false)
                            ->where(function ($query) use ($studentId) {
                                $query->where('sender_type', 'landlord')
                                    ->orWhere('sender_type', 'system')
                                    ->orWhere(function ($subQuery) use ($studentId) {
                                        $subQuery->where('sender_type', 'student')
                                            ->where('studentid', '!=', $studentId);
                                    });
                            })
                            ->exists();
                    }

                    return Message::where('studentid', $application->studentid)
                        ->where('rentalid', $application->rentalid)
                        ->where('sender_type', '!=', 'student')
                        ->where('is_read_by_student', false)
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



        return view('student.messages.index', compact('applications'));
    }

    public function show($applicationId)
    {
        $studentId = session('student_id');

        $application = Application::with(['rental.landlord', 'student', 'group'])
            ->where('id', $applicationId)
            ->where(function ($query) use ($studentId) {
                $query->where('studentid', $studentId)
                    ->orWhereIn('group_id', function ($subQuery) use ($studentId) {
                        $subQuery->select('group_id')
                            ->from('student_groups')
                            ->where('student_id', $studentId);
                    });
            })
            ->firstOrFail();
        
        
        $isOtherAccountBanned =
                ($application->rental->landlord->status ?? null) === 'suspended';

        $otherAccountRole = 'landlord';



        if ($application->applicationtype === 'group' && $application->group_id) {
            Message::where('group_id', $application->group_id)
                ->where('rentalid', $application->rentalid)
                ->where('is_read_by_student', false)
                ->where(function ($query) use ($studentId) {
                    $query->where('sender_type', 'landlord')
                        ->orWhere('sender_type', 'system')
                        ->orWhere(function ($subQuery) use ($studentId) {
                            $subQuery->where('sender_type', 'student')
                                ->where('studentid', '!=', $studentId);
                        });
                })
                ->update([
                    'is_read_by_student' => true,
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
                ->where('sender_type', '!=', 'student')
                ->where('is_read_by_student', false)
                ->update([
                    'is_read_by_student' => true,
                ]);

            $messages = Message::where('studentid', $application->studentid)
                ->where('rentalid', $application->rentalid)
                ->orderBy('created_at', 'asc')
                ->get();

            $groupMembers = collect();
        }

    
    return view(
            'student.messages.chat',
            compact(
                'application',
                'messages',
                'groupMembers',
                'isOtherAccountBanned',
                'otherAccountRole'
            )
        );
    }


       
    public function store(Request $request, $applicationId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $studentId = session('student_id');

        $application = Application::with(['rental.landlord', 'student', 'group'])
            ->where('id', $applicationId)
            ->where(function ($query) use ($studentId) {
                $query->where('studentid', $studentId)
                    ->orWhereIn('group_id', function ($subQuery) use ($studentId) {
                        $subQuery->select('group_id')
                            ->from('student_groups')
                            ->where('student_id', $studentId);
                    });
            })
            ->firstOrFail();

        Message::create([
            'content' => $request->message,
            'sender_type' => 'student',
            'timestamp' => now(),
            'studentid' => $studentId,
            'group_id' => $application->group_id,
            'landlordid' => $application->rental->landlordid,
            'rentalid' => $application->rentalid,
            'serviceproviderpartnershipid' => null,
            'is_read_by_student' => true,
            'is_read_by_landlord' => false,
        ]);

        return redirect()->route('student.messages.show', $application->id);
    }
}