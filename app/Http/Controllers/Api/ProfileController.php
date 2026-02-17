<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Landlord;
use App\Models\Student;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        // Try landlord by email
        $landlord = Landlord::where('email', $user->email)->first();

        if ($landlord) {
            return response()->json([
                'role' => 'landlord',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'ocr_verified' => (int) $user->ocr_verified,
                    'email_verified_at' => $user->email_verified_at,
                ],
                'landlord' => [
                    'id' => $landlord->id,
                    'firstname' => $landlord->firstname,
                    'surname' => $landlord->surname,
                    'email' => $landlord->email,
                    'phone' => $landlord->phone,
                    'verified' => (int) $landlord->verified,
                ],
            ]);
        }

        // Try student by email (Grace’s table)
        // This won't break anything if Student exists as a model and table.
        // If Student model/table isn't ready yet, comment this section out.
        $student = class_exists(Student::class)
            ? Student::where('email', $user->email)->first()
            : null;

        if ($student) {
            return response()->json([
                'role' => 'student',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'ocr_verified' => (int) $user->ocr_verified,
                    'email_verified_at' => $user->email_verified_at,
                ],
                'student' => $student,
            ]);
        }

        // Neither found
        return response()->json([
            'role' => 'unknown',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'ocr_verified' => (int) $user->ocr_verified,
                'email_verified_at' => $user->email_verified_at,
            ],
            'message' => 'No landlord/student profile found for this user email.',
        ], 404);
    }
}
