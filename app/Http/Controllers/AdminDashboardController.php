<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function storePartnership(Request $request)
    {
        // Temporary placeholder so the form submits without breaking anything
        // Grace your logic will be here later 
        return back()->with('success', 'Partnership submitted.');
    }
}