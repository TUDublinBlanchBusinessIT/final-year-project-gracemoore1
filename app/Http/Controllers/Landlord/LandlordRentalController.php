<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\LandlordRental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Landlord;



class LandlordRentalController extends Controller
{
    public function index()
    {
        // If you have landlord linked to the user, we’ll filter properly in step 3.
        $rentals = LandlordRental::where('landlordid', $this->getCurrentLandlordId())
            ->orderByDesc('id')
            ->get();


        return view('landlord.rentals.index', compact('rentals'));
    }

    public function create()
    {
        return view('landlord.rentals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'housenumber'    => ['nullable','string','max:20'],
            'street'         => ['required','string','max:255'],
            'county'         => ['required','string','max:255'],
            'postcode'       => ['required','string','max:20'],
            'description'    => ['required','string','max:2000'],
            'measurement'    => ['nullable','string','max:50'],
            'rentpermonth'   => ['required','numeric','min:0'],
            'status'         => ['required','in:available,occupied'],
            'availablefrom'  => ['required','date'],
            'availableuntil' => ['required','date','after_or_equal:availablefrom'],
            'images.*'       => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
        ]);

        $landlordId = $this->getCurrentLandlordId();

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $imagePaths[] = $img->store('rentals', 'public');
            }
        }

        LandlordRental::create([
            'landlordid'    => $landlordId,
            'housenumber'   => $request->housenumber,
            'street'        => $request->street,
            'county'        => $request->county,
            'postcode'      => $request->postcode,
            'description'   => $request->description,
            'measurement'   => $request->measurement,
            'rentpermonth'  => $request->rentpermonth,
            'images'        => json_encode($imagePaths),
            'status'        => $request->status,
            'availablefrom' => $request->availablefrom,
            'availableuntil'=> $request->availableuntil,
        ]);

        return redirect()->route('dashboard')->with('status', 'Listing created!');
        }


    public function edit(LandlordRental $rental)
    {
        $this->authorizeRental($rental);

        return view('landlord.rentals.edit', compact('rental'));
    }

    public function update(Request $request, LandlordRental $rental)
    {
        $this->authorizeRental($rental);

        $data = $request->validate([
            'housenumber'    => ['nullable','string','max:20'],
            'street'         => ['required','string','max:255'],
            'county'         => ['required','string','max:255'],
            'postcode'       => ['required','string','max:20'],
            'description'    => ['required','string','max:2000'],
            'measurement'    => ['nullable','string','max:50'],
            'rentpermonth'   => ['required','numeric','min:0'],
            'images'         => ['nullable','string','max:255'],
            'status'         => ['required','in:available,occupied'],
            'availablefrom'  => ['required','date'],
            'availableuntil' => ['required','date','after_or_equal:availablefrom'],
        ]);

        $rental->update($data);

        return redirect()->route('dashboard')->with('status', 'Listing updated!');
    }

    public function destroy(LandlordRental $rental)
    {
        $this->authorizeRental($rental);

        $rental->delete();

        return back()->with('status', 'Listing deleted!');
    }

    private function authorizeRental(LandlordRental $rental): void
    {
        if ($rental->landlordid !== $this->getCurrentLandlordId()) {
            abort(403);
        }
    }

    private function getCurrentLandlordId(): int
    {
        // ✅ BEST CASE:
        // if your landlords table has user_id and your logged in user is a landlord
        // return \App\Models\Landlord::where('user_id', auth()->id())->value('id');

        // TEMP SAFE FALLBACK (until we connect landlord properly):
        // If your user email matches landlord email, you can map it here.
        // return \App\Models\Landlord::where('email', auth()->user()->email)->value('id');

        // For now, make this explicit so you don't accidentally save wrong:
        $id = \App\Models\Landlord::where('email', auth()->user()->email)->value('id');
        if (!$id) abort(403, 'Landlord record not found for this user.');
        return (int) $id;
    }

}
