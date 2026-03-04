<x-admin.accounts>

<div class="p-6 bg-white shadow rounded-lg max-w-4xl mx-auto">

    <h2 class="text-xl font-bold text-gray-900 mb-4">Student Profile</h2>

    {{-- Basic Details --}}
    <div class="space-y-2 text-gray-800">
        <p><strong>Firstname:</strong> {{ $student->firstname }}</p>
        <p><strong>Surname:</strong> {{ $student->surname }}</p>
        <p><strong>Date of Birth:</strong> {{ $student->dateofbirth }}</p>
        <p><strong>Phone Number:</strong> {{ $student->phonenumber }}</p>
        <p><strong>Email:</strong> {{ $student->email }}</p>
        <p><strong>Email Verified:</strong>
            {{ $student->email_verified == 1 ? 'Yes' : 'No' }}
        </p>
        <p><strong>ID Verified:</strong>
            {{ $student->id_verified ? 'Yes' : 'No' }}
        </p>
        <p><strong>Account Created:</strong>
            {{ $student->created_at ? $student->created_at->format('d/m/Y') : 'Unknown' }}
        </p>
    </div>

    <hr class="my-6">

    {{-- Current Listings --}}
    <h3 class="text-lg font-semibold text-gray-900 mb-2">Current Listings</h3>

    @php
        $currentListings = \App\Models\LandlordRental::where('studentid', $student->id)
                            ->where('status', 'current')
                            ->get();
    @endphp

    @if($currentListings->count() == 0)
        <p class="text-gray-500">No current listings.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($currentListings as $listing)
                <div class="p-4 border rounded-lg shadow-sm bg-white">
                    <h4 class="font-bold text-gray-900">{{ $listing->housenumber }} {{ $listing->street }}</h4>
                    <p class="text-gray-700">{{ $listing->county }}</p>
                    <p class="text-blue-700 font-semibold mt-1">€{{ $listing->rentpermonth }} / month</p>

                    @php
                        $images = explode(',', $listing->images);
                        $firstImage = $images[0] ?? null;
                    @endphp

                    @if($firstImage)
                        <img src="{{ asset('storage/' . $firstImage) }}" class="w-full h-40 object-cover mt-2 rounded-lg">
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- Previous Listings --}}
    <h3 class="text-lg font-semibold text-gray-900 mt-6 mb-2">Previous Listings</h3>

    @php
        $previousListings = \App\Models\LandlordRental::where('studentid', $student->id)
                                ->where('status', 'previous')
                                ->get();
    @endphp

    @if($previousListings->count() == 0)
        <p class="text-gray-500">No previous listings.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($previousListings as $listing)
                <div class="p-4 border rounded-lg shadow-sm bg-white">
                    <h4 class="font-bold text-gray-900">{{ $listing->housenumber }} {{ $listing->street }}</h4>
                    <p class="text-gray-700">{{ $listing->county }}</p>
                    <p class="text-blue-700 font-semibold mt-1">€{{ $listing->rentpermonth }} / month</p>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Buttons --}}
    <div class="mt-8 flex gap-4">
        <button class="px-4 py-2 bg-red-600 text-white rounded-lg">Suspend Account</button>
        <button class="px-4 py-2 bg-green-600 text-white rounded-lg">Reactivate Account</button>
    </div>

</div>

</x-admin.accounts>