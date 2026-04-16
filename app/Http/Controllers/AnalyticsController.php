<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LandlordRental;
use App\Models\Complaint;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'listings');
        $complaintTab = $request->get('complaint_tab', 'reported');

        // --- Applications per County ---
        $applications = DB::table('application as a')
            ->join('rental as r', 'a.rentalid', '=', 'r.id')
            ->select('r.county')
            ->selectRaw('count(*) as total')
            ->groupBy('r.county')
            ->orderByRaw('count(*) DESC')
            ->pluck('total', 'r.county');

        // --- Listings per County ---
        $listings = LandlordRental::select('county')
            ->selectRaw('count(*) as total')
            ->groupBy('county')
            ->orderByRaw('count(*) DESC')
            ->pluck('total', 'county');

        // --- Complaints ---
        if ($complaintTab === 'reported') {
            $complaints = DB::table('complaint')
                ->select('reported_user_role')
                ->selectRaw('count(*) as total')
                ->groupBy('reported_user_role')
                ->orderByRaw('count(*) DESC')
                ->pluck('total', 'reported_user_role');
        } else {
            $complaints = DB::table('complaint')
                ->select('reporter_role')
                ->selectRaw('count(*) as total')
                ->groupBy('reporter_role')
                ->orderByRaw('count(*) DESC')
                ->pluck('total', 'reporter_role');
        }

        return view('admin.analytics', compact('tab', 'complaintTab', 'applications', 'listings', 'complaints'));
    }
}