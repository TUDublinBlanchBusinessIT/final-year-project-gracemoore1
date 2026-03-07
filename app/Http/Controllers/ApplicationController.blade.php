<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Application;

class ApplicationController extends Controller
{
    /**
     * Show the Single/Group application form
     */
    public function start($listingId, $type)
    {
        $listing = Listing::findOrFail($listingId);

        if (!in_array($type, ['single', 'group'])) {
            abort(404);
        }

        return view('applications.start-' . $type, [
            'listing' => $listing,
            'type' => $type,
        ]);
    }

    /**
     * Store Single Application
     */
    public function submitSingle(Request $request, $listingId)
    {
        $request->validate([
            'age' => 'required|integer|min:16|max:100',
            'gender' => 'required|string',
            'additional_details' => 'nullable|string|max:500',
        ]);

        $listing = Listing::findOrFail($listingId);
        $student = auth()->user();

        Application::create([
            'applicationtype' => 'single',
            'status' => 'pending',
            'dateapplied' => now(),
            'student_id' => $student->id,
            'listing_id' => $listing->id,
            'age' => $request->age,
            'gender' => $request->gender,
            'additional_details' => $request->additional_details,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Your application has been submitted and is now pending.');
    }
}