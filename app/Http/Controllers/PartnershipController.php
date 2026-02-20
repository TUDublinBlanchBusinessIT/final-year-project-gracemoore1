<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceProviderPartnership;
use Illuminate\Support\Facades\Mail;
use App\Mail\ServiceProviderWelcome;

class PartnershipController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'servicetype' => 'required',
            'firstname' => 'required',
            'surname' => 'required',
            'companyname' => 'required',
            'email' => 'required|email|unique:serviceproviderpartnership,email',
            'phone' => 'required',
            'county' => 'required',
            'password' => 'required|confirmed|min:8',
            'fee_type' => 'required|in:commission,monthly_fee',
            'commission' => 'required_if:fee_type,commission|nullable|numeric|min:0|max:100',
            'monthly_fee' => 'required_if:fee_type,monthly_fee|nullable|numeric|min:0',
            'verification' => 'accepted',
        ]);

        $partnership = new ServiceProviderPartnership();
        $partnership->servicetype = $request->servicetype;
        $partnership->firstname = $request->firstname;
        $partnership->surname = $request->surname;
        $partnership->companyname = $request->companyname;
        $partnership->email = $request->email;
        $partnership->phone = $request->phone;
        $partnership->county = $request->county;
        $partnership->password = bcrypt($request->password);
        $partnership->commissionperjob = ($request->fee_type === 'commission') ? $request->commission : null;
        $partnership->feepermonth = ($request->fee_type === 'monthly_fee') ? $request->monthly_fee : null;
        $partnership->administratorid = auth()->user()->id ?? 1; // Set admin ID as needed
        $partnership->save();

        // Send email with login details
        Mail::to($partnership->email)->send(new ServiceProviderWelcome($partnership, $request->password));

        return redirect()->back()->with('success', 'Account created and login details sent to the service provider.');
    }
}
