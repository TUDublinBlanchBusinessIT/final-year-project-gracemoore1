<x-app-layout>

    <x-slot name="header">
        <div class="border-b border-slate-200 px-6 py-3 bg-white">
            <p class="text-m font-semibold uppercase tracking-[0.12em] text-blue-600">
                Home
            </p>
        </div>
    </x-slot>

    <div class="pb-28">

    

        {{-- YOUR LISTINGS SECTION --}}
        @php
            $landlordId = \App\Models\Landlord::where('email', Auth::user()->email)->value('id');
            $rentals = $landlordId
                ? \App\Models\LandlordRental::where('landlordid', $landlordId)->latest('id')->get()
                : collect();
        @endphp

        <div class="mt-10">

            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-slate-900">Your Listings</h2>

                    <button
                        type="button"
                        onclick="toggleHelpBox()"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold hover:bg-blue-200 transition"
                    >
                        ?
                    </button>
                </div>

                <a href="{{ route('landlord.rentals.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                    + Add Listing
                </a>
            </div>

            <div
                id="helpBox"
                class="hidden mb-6 bg-blue-50 border border-blue-200 rounded-2xl p-5 shadow-sm"
            >
                <div class="flex justify-between items-start gap-4">
                    <div>
                        <h3 class="text-base font-semibold text-slate-900 mb-2">
                            Need help with your listings?
                        </h3>

                        <p class="text-sm text-slate-600 leading-relaxed">
                            This is your home page where you can create, update, and delete your listings.
                            These listings will be visible to students searching for accommodation.
                            Try to include as much accurate information as possible about your available property,
                            including photos, location, and key details, so the right students can apply.
                        </p>
                    </div>

                    <button
                        type="button"
                        onclick="toggleHelpBox()"
                        class="text-slate-400 hover:text-slate-700 text-xl leading-none"
                    >
                        ×
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($rentals as $rental)

                    @php
                        $imageList = is_array($rental->images) ? $rental->images : json_decode($rental->images, true);
                        $firstImage = $imageList[0] ?? null;
                    @endphp

                    @php
                        $acceptedApplication = \App\Models\Application::with('student')
                            ->where('rentalid', $rental->id)
                            ->where('status', 'accepted')
                            ->first();
                    @endphp

                    @php
                        $endDate = $rental->availableuntil ? \Carbon\Carbon::parse($rental->availableuntil) : null;
                        $daysUntilEnd = $endDate ? now()->diffInDays($endDate, false) : null;
                    @endphp                    

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition">

                        {{-- Image preview --}}
                        <div class="w-full h-56 bg-slate-100">
                            @if($firstImage)
                                <img src="{{ asset('storage/' . $firstImage) }}"
                                     alt="Rental image"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 text-sm">
                                    No image uploaded
                                </div>
                            @endif
                        </div>

                        {{-- Card content --}}
                        <div class="p-5">
                            <div class="font-semibold text-slate-900 text-lg">
                                {{ $rental->housenumber ? $rental->housenumber . ' ' : '' }}
                                {{ $rental->street }}, {{ $rental->county }}
                            </div>

                            <div class="mt-2 text-sm text-slate-600">
                                €{{ number_format($rental->rentpermonth ?? 0, 2) }} / month
                            </div>

                            <div class="mt-1 text-xs text-slate-500">
                                Available: {{ $rental->availablefrom }} → {{ $rental->availableuntil }}
                            </div>

                            <div class="mt-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs border
                                    {{ $rental->status === 'available'
                                        ? 'bg-green-50 text-green-700 border-green-200'
                                        : ($rental->status === 'let_agreed'
                                            ? 'bg-blue-50 text-blue-700 border-blue-200'
                                            : 'bg-slate-100 text-slate-700 border-slate-200') }}">
                                    {{ $rental->status === 'let_agreed' ? 'Let Agreed' : ucfirst($rental->status ?? 'unknown') }}
                                </span>
                            </div>

                            @if($rental->status === 'let_agreed' && $acceptedApplication && $acceptedApplication->student)
                                <div class="mt-2 text-sm text-slate-700">
                                    <span class="font-medium">Accepted Student:</span>
                                    {{ $acceptedApplication->student->firstname }} {{ $acceptedApplication->student->surname }}
                                </div>
                            @endif

                            @if($rental->status === 'let_agreed' && $endDate)
                                @if($daysUntilEnd < 0)
                                    <div class="mt-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                        This agreement has ended. Please update the dates or make the listing available for new tenants.
                                    </div>
                                @elseif($daysUntilEnd <= 14)
                                    <div class="mt-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                                        This listing is ending soon. Please update the current agreement or add new dates for new tenants.
                                    </div>
                                @endif
                            @endif                            

                            <p class="mt-3 text-sm text-slate-600 line-clamp-2">
                                {{ \Illuminate\Support\Str::limit($rental->description, 120) }}
                            </p>

                            <div class="mt-4 flex flex-wrap gap-2">
                                <a href="{{ route('landlord.rentals.edit', $rental) }}"
                                   class="px-4 py-2 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('landlord.rentals.destroy', $rental) }}"
                                      onsubmit="return confirm('Delete this listing?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="px-4 py-2 rounded-xl bg-red-50 text-red-600 font-semibold hover:bg-red-100 transition">
                                        Delete
                                    </button>
                                </form>

                                <a href="{{ route('landlord.applications.index', $rental->id) }}"
                                   class="px-4 py-2 rounded-xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition">
                                    View Applications
                                </a>
                            </div>
                        </div>
                    </div>

                @empty

                    <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-10 text-center md:col-span-2">
                        <div class="text-slate-700 font-semibold text-lg">
                            No listings yet
                        </div>

                        <div class="text-slate-500 text-sm mt-1">
                            Add your first listing to get started.
                        </div>

                        <a href="{{ route('landlord.rentals.create') }}"
                           class="inline-flex items-center justify-center mt-5 w-14 h-14 rounded-full bg-blue-600 text-white text-3xl font-bold hover:bg-blue-700 transition">
                            +
                        </a>
                    </div>

                @endforelse
            </div>
        </div>

    </div>

    <script>
        function toggleHelpBox() {
            const box = document.getElementById('helpBox');
            box.classList.toggle('hidden');
        }
    </script>    

</x-app-layout>