<x-admin.accounts>

<div class="p-6 bg-white shadow rounded-lg max-w-5xl mx-auto">

    <h2 class="text-2xl font-bold text-gray-900 mb-6">Landlord Profile</h2>

    {{-- BASIC DETAILS --}}
    <div class="space-y-2 text-gray-800">
        <p><strong>Firstname:</strong> {{ $landlord->firstname }}</p>
        <p><strong>Surname:</strong> {{ $landlord->surname }}</p>
        <p><strong>Email:</strong> {{ $landlord->email }}</p>
        <p><strong>Phone:</strong> {{ $landlord->phone ?? 'N/A' }}</p>
        <p><strong>Verified:</strong> {{ $landlord->verified == 1 ? 'Yes' : 'No' }}</p>
    </div>

    <hr class="my-6">

    {{-- ========================= --}}
    {{-- CURRENT LISTINGS (Student-style cards) --}}
    {{-- ========================= --}}
    <h3 class="text-xl font-semibold text-slate-900 mb-4">Current Listings</h3>

    @php
        $currentListings = \App\Models\LandlordRental::where('landlordid', $landlord->id)->get();
    @endphp

    @if ($currentListings->count() == 0)
        <p class="text-gray-500">No current listings.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($currentListings as $rental)

                @php
                    $images = json_decode($rental->images ?? '[]', true) ?? [];
                    $imgCount = count($images);
                @endphp

                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">

                    {{-- CAROUSEL --}}
                    <div class="relative" data-carousel data-key="landlord-{{ $rental->id }}" data-count="{{ $imgCount }}">
                        <div class="overflow-hidden rounded-lg">
                            <div id="track-landlord-{{ $rental->id }}" class="flex transition-transform duration-300 ease-out">
                                @forelse ($images as $img)
                                    <div class="w-full shrink-0">
                                        <img src="{{ asset('storage/' . $img) }}" class="w-full h-48 object-cover rounded-lg" />
                                    </div>
                                @empty
                                    <div class="w-full h-48 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500">
                                        No image
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        @if ($imgCount > 1)
                            <button onclick="prevImage('landlord', {{ $rental->id }})"
                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/90 text-slate-700 px-2 py-1 rounded-full shadow">
                                ‹
                            </button>

                            <button onclick="nextImage('landlord', {{ $rental->id }})"
                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/90 text-slate-700 px-2 py-1 rounded-full shadow">
                                ›
                            </button>
                        @endif
                    </div>

                    {{-- LISTING DETAILS --}}
                    <div class="mt-3">
                        <div class="font-semibold text-slate-900">
                            {{ $rental->housenumber ? $rental->housenumber . ' ' : '' }}
                            {{ $rental->street }}, {{ $rental->county }}
                        </div>

                        @if ($rental->housetype)
                            <div class="text-sm text-slate-700 mt-1">
                                {{ $rental->housetype }}
                            </div>
                        @endif

                        @if ($rental->nightsperweek)
                            <div class="text-sm text-slate-700">
                                {{ $rental->nightsperweek }} nights / week
                            </div>
                        @endif

                        <div class="text-sm text-slate-600 mt-1">
                            Available: {{ $rental->availablefrom }} → {{ $rental->availableuntil }}
                        </div>

                        <div class="text-base text-slate-800 font-bold mt-2">
                            €{{ number_format($rental->rentpermonth, 2) }} / month
                        </div>
                    </div>

                    {{-- VIEW FULL DETAILS (ADMIN VERSION) --}}
                    {{ route('admin.listing.view', $rental->id) }}
                        <button class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                            View Details
                        </button>
                    </a>

                </div>
            @endforeach
        </div>
    @endif


    {{-- BUTTONS --}}
    <div class="mt-8 flex gap-4">
        <button class="px-4 py-2 bg-red-600 text-white rounded-lg">Suspend Account</button>
        <button class="px-4 py-2 bg-green-600 text-white rounded-lg">Reactivate Account</button>
    </div>

</div>

{{-- CAROUSEL SCRIPT (copied from student dashboard) --}}
<script>
    const carouselState = {};

    function updateCarousel(view, id) {
        const key = `${view}-${id}`;
        const track = document.getElementById(`track-${view}-${id}`);
        if (!track) return;
        const state = carouselState[key] || { index: 0, count: track.children.length };
        track.style.transform = `translateX(-${state.index * 100}%)`;
    }

    function nextImage(view, id) {
        const key = `${view}-${id}`;
        const track = document.getElementById(`track-${view}-${id}`);
        if (!track) return;
        const count = track.children.length;
        if (!carouselState[key]) carouselState[key] = { index: 0, count };
        carouselState[key].index = (carouselState[key].index + 1) % count;
        updateCarousel(view, id);
    }

    function prevImage(view, id) {
        const key = `${view}-${id}`;
        const track = document.getElementById(`track-${view}-${id}`);
        if (!track) return;
        const count = track.children.length;
        if (!carouselState[key]) carouselState[key] = { index: 0, count };
        carouselState[key].index = carouselState[key].index === 0 ? count - 1 : carouselState[key].index - 1;
        updateCarousel(view, id);
    }

    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll("[data-carousel]").forEach(carousel => {
            const key = carousel.dataset.key;
            const [view, id] = key.split("-");
            carouselState[key] = { index: 0, count: carousel.dataset.count };
            updateCarousel(view, id);
        });
    });
</script>

</x-admin.accounts>