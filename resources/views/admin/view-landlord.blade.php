<x-admin.accounts>

<div class="p-6 bg-white shadow rounded-lg max-w-3xl mx-auto">

    <h2 class="text-xl font-bold text-gray-900 mb-4">Landlord Profile</h2>

    <div class="space-y-2 text-gray-800">
        <p><strong>Firstname:</strong> {{ $landlord->firstname }}</p>
        <p><strong>Surname:</strong> {{ $landlord->surname }}</p>
        <p><strong>Email:</strong> {{ $landlord->email }}</p>
        <p><strong>Account Created:</strong> {{ $landlord->created_at ?? 'Unknown' }}</p>
    </div>

    <hr class="my-4">

    <h3 class="font-semibold text-gray-900">Current Listings</h3>

    @if($currentListings->count() == 0)
        <p class="text-gray-500">No current listings.</p>
    @else
        <ul class="list-disc pl-5 text-gray-700">
            @foreach($currentListings as $listing)
                <li>{{ $listing->title ?? 'Listing' }} (ID: {{ $listing->id }})</li>
            @endforeach
        </ul>
    @endif

    <h3 class="mt-4 font-semibold text-gray-900">Previous Listings</h3>
    <p class="text-gray-500 text-sm">Not implemented yet</p>

    <div class="mt-6 flex gap-4">
        <button class="px-4 py-2 bg-red-600 text-white rounded-md">Suspend Account</button>
        <button class="px-4 py-2 bg-green-600 text-white rounded-md">Reactivate Account</button>
    </div>

</div>

</x-admin.accounts>