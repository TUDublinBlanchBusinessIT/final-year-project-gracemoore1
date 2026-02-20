<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Landlord;
use Illuminate\Http\Request;

class LandlordController extends Controller
{
    public function show($id)
    {
        $landlord = Landlord::find($id);

        if (!$landlord) {
            return response()->json([
                'message' => 'Landlord not found'
            ], 404);
        }

        return response()->json([
            'id' => $landlord->id,
            'firstname' => $landlord->firstname,
            'surname' => $landlord->surname,
            'email' => $landlord->email,
            'phone' => $landlord->phone,
            'verified' => $landlord->verified
        ]);
    }
}
