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
            'housenumber'         => ['nullable','string','max:20'],
            'street'              => ['required','string','max:255'],
            'county'              => ['required','string','max:255'],
            'postcode'            => ['required','string','max:20'],
            'description'         => ['required','string','max:2000'],
            'measurement'         => ['nullable','string','max:50'],
            'housetype'           => ['nullable','string','max:50'],
            'accommodation_type'  => ['nullable', 'in:house,apartment'],
            'nightsperweek'       => ['nullable','string','max:50'],
            'rentpermonth'        => ['required','numeric','min:0'],
            'status'              => ['required','in:available,occupied'],
            'availablefrom'       => ['required','date'],
            'availableuntil'      => ['required','date','after_or_equal:availablefrom'],
            'images.*'            => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'application_type'    => ['required', 'in:single,group'],
        ]);

        $landlordId = $this->getCurrentLandlordId();

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $imagePaths[] = $img->store('rentals', 'public');
            }
        }

        LandlordRental::create([
            'landlordid'         => $landlordId,
            'housenumber'        => $request->housenumber,
            'street'             => $request->street,
            'county'             => $request->county,
            'postcode'           => $request->postcode,
            'description'        => $request->description,
            'measurement'        => $request->measurement,
            'housetype'          => $request->housetype,
            'accommodation_type' => $request->accommodation_type,
            'nightsperweek'      => $request->nightsperweek,
            'rentpermonth'       => $request->rentpermonth,
            'images'             => json_encode($imagePaths),
            'status'             => $request->status,
            'availablefrom'      => $request->availablefrom,
            'availableuntil'     => $request->availableuntil,
            'application_type'   => $request->string('application_type'),
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
            'housenumber'         => ['nullable','string','max:20'],
            'street'              => ['required','string','max:255'],
            'county'              => ['required','string','max:255'],
            'postcode'            => ['required','string','max:20'],
            'description'         => ['required','string','max:2000'],
            'measurement'         => ['nullable','string','max:50'],

            // ✅ Added fields for edit
            'housetype'           => ['required','in:any,single_private,private_shared,whole_property_group'],
            'accommodation_type'  => ['required','in:house,apartment'],
            'application_type'    => ['required','in:single,group'],
            'nightsperweek'       => ['nullable','integer','min:0','max:7'],

            'rentpermonth'        => ['required','numeric','min:0'],
            'status'              => ['required','in:available,occupied'],
            'availablefrom'       => ['required','date'],
            'availableuntil'      => ['required','date','after_or_equal:availablefrom'],
            // ❌ No images in edit as requested
        ]);

        $rental->update([
            'housenumber'        => $data['housenumber'] ?? null,
            'street'             => $data['street'],
            'county'             => $data['county'],
            'postcode'           => $data['postcode'],
            'description'        => $data['description'],
            'measurement'        => $data['measurement'] ?? null,

            // ✅ Newly added editable fields
            'housetype'          => $data['housetype'],
            'accommodation_type' => $data['accommodation_type'],
            'application_type'   => $data['application_type'],
            'nightsperweek'      => $data['nightsperweek'] ?? null,

            'rentpermonth'       => $data['rentpermonth'],
            'status'             => $data['status'],
            'availablefrom'      => $data['availablefrom'],
            'availableuntil'     => $data['availableuntil'],
        ]);

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
        // For now, make this explicit so you don't accidentally save wrong:
        $id = \App\Models\Landlord::where('email', auth()->user()->email)->value('id');
        if (!$id) abort(403, 'Landlord record not found for this user.');
        return (int) $id;
    }

    public function applications($rental)
    {
        $rental = \App\Models\LandlordRental::findOrFail($rental);

        return view('landlord.rentals.applications', compact('rental'));
    }
}

