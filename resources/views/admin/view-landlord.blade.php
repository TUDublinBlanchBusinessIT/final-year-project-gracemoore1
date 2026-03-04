<x-admin.accounts>

<div class="p-6 bg-white shadow rounded-lg max-w-4xl mx-auto">

    <h2 class="text-xl font-bold text-gray-900 mb-4">Landlord Profile</h2>

    <div class="space-y-2 text-gray-800">
        <p><strong>Firstname:</strong> {{ $landlord->firstname }}</p>
        <p><strong>Surname:</strong> {{ $landlord->surname }}</p>
        <p><strong>Email:</strong> {{ $landlord->email }}</p>
        <p><strong>Phone:</strong> {{ $landlord->phone ?? 'N/A' }}</p>
        <p><strong>Verified:</strong>
            {{ $landlord->verified ? 'Yes' : 'No' }}
        </p>
    </div>

    <hr class="my-6">

    <h3 class="text-lg font-semibold text-gray-900 mb-2">Current Listings</h3>

    @if($currentListings->count() == 0)
        <p class="text-gray-500">No current listings.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($currentListings as $listing)
                <div class="p-4 border rounded-lg shadow-sm bg-white">
                    <h4 class="font-bold text-gray-900">
                        {{ $listing->housenumber }} {{ $listing->street }}
                    </h4>
                    <p class="text-gray-700">{{ $listing->county }}</p>
                    <p class="text-blue-700 font-semibold mt-1">€{{ $listing->rentpermonth }} / month</p>

                    @php
                        $images = explode(',', $listing->images);
                        $firstImage = $images[0] ?? null;
                    @endphp

                    @if($firstImage)
                        <img src="{{ asset('storage/' . $firstImage) }}"
                             class="w-full h-40 object-cover mt-2 rounded-lg">
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-8 flex gap-4">
        <button class="px-4 py-2 bg-red-600 text-white rounded-lg">Suspend Account</button>
        <button class="px-4 py-2 bg-green-600 text-white rounded-lg">Reactivate Account</button>
    </div>

</div>

</x-admin.accounts>