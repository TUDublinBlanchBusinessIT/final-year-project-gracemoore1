<?php

namespace App\Http\Controllers;

use App\Models\LandlordRental;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'applications');
        $complaintTab = $request->get('complaint_tab', 'subject');

        // --- Applications per County ---
        $applications = DB::table('application as a')
            ->join('rental as r', 'a.rentalid', '=', 'r.id') // correct column names
            ->select('r.county')
            ->selectRaw('count(*) as total')
            ->groupBy('r.county')
            ->pluck('total', 'r.county');

        // --- Listings per County ---
        $listings = DB::table('rental')
            ->select('county')
            ->selectRaw('count(*) as total')
            ->groupBy('county')
            ->pluck('total', 'county');

        // --- Complaints ---
        if ($complaintTab === 'subject') {
            $complaints = Complaint::select('subject')
                ->selectRaw('count(*) as total')
                ->groupBy('subject')
                ->pluck('total', 'subject');
        } else {
            // Complaints by reported user's county
            // We'll try to find their rental if the reported_user is a landlord with rentals
            $complaints = DB::table('complaint as c')
                ->leftJoin('rental as r', 'c.reported_user_id', '=', 'r.landlordid')
                ->select('r.county')
                ->selectRaw('count(*) as total')
                ->groupBy('r.county')
                ->pluck('total', 'r.county');
        }

        return view('admin.analytics', compact('tab', 'applications', 'listings', 'complaints', 'complaintTab'));
    }
}