<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\LandlordRental;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Landlord;
use Illuminate\Support\Facades\DB;

class LandlordRentalController extends Controller
{
    public function index()
    {
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

            'housetype'           => ['required','in:any,single_private,private_shared,whole_property_group'],
            'accommodation_type'  => ['required','in:house,apartment'],
            'application_type'    => ['required','in:single,group'],
            'nightsperweek'       => ['nullable','integer','min:0','max:7'],

            'rentpermonth'        => ['required','numeric','min:0'],
            'status'              => ['required','in:available,occupied'],
            'availablefrom'       => ['required','date'],
            'availableuntil'      => ['required','date','after_or_equal:availablefrom'],
        ]);

        $rental->update([
            'housenumber'        => $data['housenumber'] ?? null,
            'street'             => $data['street'],
            'county'             => $data['county'],
            'postcode'           => $data['postcode'],
            'description'        => $data['description'],
            'measurement'        => $data['measurement'] ?? null,

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
        $id = Landlord::where('email', auth()->user()->email)->value('id');
        if (!$id) abort(403, 'Landlord record not found for this user.');
        return (int) $id;
    }

    /** ----------------------------------------------------
     *   LANDLORD VIEW APPLICATIONS (Pending Only)
     *  ---------------------------------------------------- */
    public function applications($rentalId)
    {
        $landlordId = $this->getCurrentLandlordId();

        $rental = LandlordRental::where('id', $rentalId)
            ->where('landlordid', $landlordId)
            ->firstOrFail();

        // Load only pending applications (accepted/rejected disappear)
        $applications = Application::with('student')
            ->where('rentalid', $rentalId)
            ->where('status', 'pending')
            ->orderBy('dateapplied', 'desc')
            ->get();

        return view('landlord.rentals.applications', compact('rental', 'applications'));
    }

    /** ----------------------------------------------------
     *   ACCEPT APPLICATION
     *  ---------------------------------------------------- */
    public function acceptApplication($applicationId)
    {
        $app = Application::findOrFail($applicationId);
        $rental = LandlordRental::findOrFail($app->rentalid);

        // Only the owner of the listing can accept
        if ($rental->landlordid != session('landlord_id')) {
            abort(403);
        }

        DB::transaction(function () use ($app, $rental) {
            $alreadyAccepted = Application::where('rentalid', $app->rentalid)
                ->where('status', 'accepted')
                ->where('id', '!=', $app->id)
                ->exists();

            if ($alreadyAccepted) {
                abort(400, 'A student has already been accepted for this property.');
            }

            $app->update(['status' => 'accepted']);

            Application::where('rentalid', $app->rentalid)
                ->where('id', '!=', $app->id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);

            $rental->update(['status' => 'let_agreed']);
        });

        return back()->with('success', 'Application accepted. All other applications were rejected and the property is now let agreed.');
    }

    /** ----------------------------------------------------
     *   REJECT APPLICATION
     *  ---------------------------------------------------- */
    public function rejectApplication($applicationId)
    {
        $landlordId = $this->getCurrentLandlordId();

        $app = Application::with('rental')->findOrFail($applicationId);

        // Only the owner can reject
        if (!$app->rental || (int)$app->rental->landlordid !== (int)$landlordId) {
            abort(403);
        }

        $app->update(['status' => 'rejected']);

        return back()->with('success', 'Application rejected.');
    }
}

