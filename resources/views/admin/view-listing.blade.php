<x-admin.accounts>

<div class="p-6 max-w-4xl mx-auto bg-white rounded-xl shadow">

    <h2 class="text-2xl font-bold text-gray-900 mb-4">Listing Details</h2>

    @php
        $images = json_decode($rental->images ?? '[]', true);
        $firstImage = $images[0] ?? null;
    @endphp

    {{-- BIG IMAGE --}}
    @if($firstImage)
        {{ asset('storage/' . $firstImage) }}
    @else
        <div class="w-full h-64 bg-slate-200 rounded-lg mb-4 flex items-center justify-center text-slate-500">
            No Image
        </div>
    @endif

    <div class="space-y-3 text-gray-800 mt-4">

        <p class="text-xl font-semibold">
            {{ $rental->housenumber }} {{ $rental->street }}, {{ $rental->county }}
        </p>

        <p><strong>House Type:</strong> {{ $rental->housetype }}</p>

        <p><strong>Nights Per Week:</strong> {{ $rental->nightsperweek }}</p>

        <p><strong>Rent Per Month:</strong>
            €{{ number_format($rental->rentpermonth, 2) }}
        </p>

        <p><strong>Available From:</strong> {{ $rental->availablefrom }}</p>
        <p><strong>Available Until:</strong> {{ $rental->availableuntil }}</p>

        <p><strong>Description:</strong></p>
        <p class="whitespace-pre-line">{{ $rental->description }}</p>

        <hr class="my-6">

        <h3 class="text-xl font-bold text-slate-900 mb-2">Landlord Information</h3>

        <p><strong>Name:</strong> {{ $landlord->firstname }} {{ $landlord->surname }}</p>
        <p><strong>Email:</strong> {{ $landlord->email }}</p>
        <p><strong>Phone:</strong> {{ $landlord->phone ?? 'N/A' }}</p>

    </div>

</div>

</x-admin.accounts>