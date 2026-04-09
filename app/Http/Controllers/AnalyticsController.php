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
        $complaintTab = $request->get('complaint_tab', 'subject');

        // --- Applications per County ---
        $applications = DB::table('application as a')
            ->join('rental as r', 'a.rentalid', '=', 'r.id')
            ->select('r.county')
            ->selectRaw('count(*) as total')
            ->groupBy('r.county')
            ->pluck('total', 'r.county');

        // --- Listings per County ---
        $listings = LandlordRental::select('county')
            ->selectRaw('count(*) as total')
            ->groupBy('county')
            ->pluck('total', 'county');

        // --- Complaints ---
        if ($complaintTab === 'subject') {
            // Extract SUBJECT from description and count
            $complaints = Complaint::all()->map(function($c) {
                preg_match('/SUBJECT:\s*(.*?)\s*DETAILS:/i', $c->description, $matches);
                return $matches[1] ?? 'Unknown';
            })->countBy(); // returns Collection with subject => count
        } else {
            // Complaints by county (reported landlords’ rentals)
            $complaints = DB::table('complaint as c')
                ->leftJoin('rental as r', 'c.reported_user_id', '=', 'r.landlordid')
                ->select('r.county')
                ->selectRaw('count(*) as total')
                ->groupBy('r.county')
                ->pluck('total', 'r.county')
                ->mapWithKeys(fn($value, $key) => [$key ?? 'Unknown' => $value]);
        }

        return view('admin.analytics', compact('tab', 'complaintTab', 'applications', 'listings', 'complaints'));
    }
}