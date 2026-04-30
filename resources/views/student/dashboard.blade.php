<x-app-layout>

    {{-- Header --}}
    <x-slot name="header">
        <div class="border-b border-slate-200 px-6 py-3 bg-white">
            <p class="text-lg font-extrabold uppercase tracking-[0.16em] text-blue-600">
                Home
            </p>
        </div>
    </x-slot>

    @php
        // Premium listings only
        $premiumListings = collect($listings)
            ->where('is_premium', 1)
            ->values();

        // All listings (premium + non‑premium)
        $allListings = collect($listings)->values();
    @endphp


    @php
        $student = \App\Models\Student::find(session('student_id'));

        $collegeToCounty = [
            'TCD' => 'Dublin',
            'UCD' => 'Dublin',
            'UL'  => 'Limerick',
            'NUIG'=> 'Galway',
            'TUD' => 'Dublin',
            'UCC' => 'Cork',
            'Maynooth' => 'Kildare',
            'CIT' => 'Cork',
            'RCSI' => 'Dublin',
        ];
    @endphp

    <div>

                {{-- Welcome --}}
        <h1 class="text-2xl font-bold text-slate-900 mb-8">
            Welcome back, {{ $student->firstname ?? $student->name ?? 'Student' }}!
        </h1>

        {{-- SEARCH BAR --}}
        <form method="GET" action="{{ route('student.dashboard') }}" id="searchForm">
            <div class="flex items-center bg-white border border-slate-300 rounded-xl px-4 py-3 shadow-sm">
                <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M10 4a6 6 0 1 0 0 12 6 6 0 0 0 0-12z" />
                </svg>
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Search listings..."
                    class="ml-3 w-full focus:ring-0 border-none focus:outline-none text-slate-800" />
                <button id="filterToggle" type="button" class="ml-3 text-slate-600 hover:text-blue-600" title="Filters">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M6 12h12M10 18h8" />
                    </svg>
                </button>
            </div>
        </form>

        {{-- COLLEGE CHIPS --}}
        <div class="mt-4 flex gap-2 overflow-x-auto pb-2">
            @foreach ($collegeToCounty as $college => $county)
                <a href="{{ route('student.dashboard', ['county' => $county]) }}"
                class="shrink-0 px-3 py-2 rounded-full border text-sm font-semibold hover:bg-blue-50
                        {{ request('county') === $county ? 'bg-blue-600 text-white border-blue-600' : 'border-blue-500 text-blue-600 bg-white' }}">
                    {{ $college }}
                </a>
            @endforeach
        </div>
        @if(request()->anyFilled(['q', 'county', 'housetype', 'from', 'until', 'min_rent', 'max_rent', 'nights_bucket']))
            <div class="mt-2">
                <a href="{{ route('student.dashboard') }}"
                class="inline-flex items-center gap-1 px-3 py-2 rounded-full border border-red-300 text-red-600 bg-white text-sm font-semibold hover:bg-red-50">
                    ✕ Clear filters
                </a>
            </div>
        @endif

        {{-- FILTER DRAWER --}}
        <div id="filterDrawer" class="hidden bg-white border border-slate-300 rounded-xl shadow-sm px-6 py-6 mt-4">
            <form method="GET" action="{{ route('student.dashboard') }}" class="space-y-4">

                <div>
                    <label class="font-semibold text-slate-700">Location</label>
                    <input type="text" name="county" value="{{ request('county') }}"
                        class="w-full mt-1 rounded-lg border-slate-300" placeholder="Dublin" />
                </div>

                <div>
                    <label class="font-semibold text-slate-700">House Type</label>
                    <select name="housetype" class="w-full mt-1 rounded-lg border-slate-300">
                        <option value="">Any</option>
                        <option value="single_private" {{ request('housetype') === 'single_private' ? 'selected' : '' }}>Single room in private home</option>
                        <option value="private_shared" {{ request('private_shared') === 'private_shared' ? 'selected' : '' }}>Private room in shared house</option>
                        <option value="whole_property_group" {{ request('housetype') === 'whole_property_group' ? 'selected' : '' }}>Whole property (group only)</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-slate-700">Available From</label>
                        <input type="date" name="from" value="{{ request('from') }}"
                            class="w-full mt-1 rounded-lg border-slate-300" />
                    </div>
                    <div>
                        <label class="font-semibold text-slate-700">Until</label>
                        <input type="date" name="until" value="{{ request('until') }}"
                            class="w-full mt-1 rounded-lg border-slate-300" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-slate-700">Min Rent (€)</label>
                        <input type="number" name="min_rent" value="{{ request('min_rent') }}"
                            class="w-full mt-1 rounded-lg border-slate-300" />
                    </div>
                    <div>
                        <label class="font-semibold text-slate-700">Max Rent (€)</label>
                        <input type="number" name="max_rent" value="{{ request('max_rent') }}"
                            class="w-full mt-1 rounded-lg border-slate-300" />
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-slate-700">Nights per Week</label>
                    <select name="nights_bucket" class="w-full mt-1 rounded-lg border-slate-300">
                        <option value="">Any</option>
                        <option value="1-3" {{ request('nights_bucket') === '1-3' ? 'selected' : '' }}>1–3 nights</option>
                        <option value="4-5" {{ request('nights_bucket') === '4-5' ? 'selected' : '' }}>4–5 nights</option>
                        <option value="6-7" {{ request('nights_bucket') === '6-7' ? 'selected' : '' }}>6–7 nights</option>
                    </select>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold">
                    Apply Filters
                </button>
            </form>
        </div>

        <div class="mt-10">
            <h2 class="text-xl font-bold text-slate-900 mb-3">Premium listings</h2>

            @if ($premiumListings->count())
                <div class="relative">
                    <button onclick="scrollRow('premium', -1)"
                        class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white border rounded-full w-10 h-10 shadow">
                        ‹
                    </button>

                    <button onclick="scrollRow('premium', 1)"
                        class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white border rounded-full w-10 h-10 shadow">
                        ›
                    </button>

                    <div class="overflow-hidden px-12">
                        <div id="premium-track"
                            class="flex gap-6 transition-transform duration-300 ease-out">
                            @foreach ($premiumListings as $rental)
                                @include('partials.listing-card', [
                                    'rental' => $rental,
                                    'trackPrefix' => 'premium'
                                ])
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <p class="text-sm text-slate-500">
                    No premium listings available at the moment.
                </p>
            @endif
        </div>


        @if ($allListings->count())
        <div class="mt-10">
            <h2 class="text-xl font-bold text-slate-900 mb-3">All listings</h2>

            <div class="relative">
                <button onclick="scrollRow('all', -1)"
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white border rounded-full w-10 h-10 shadow">
                    ‹
                </button>

                <button onclick="scrollRow('all', 1)"
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white border rounded-full w-10 h-10 shadow">
                    ›
                </button>

                <div class="overflow-hidden px-12">
                    <div id="all-track" class="flex gap-6 transition-transform duration-300 ease-out">
                        @foreach ($allListings as $rental)
                            @include('partials.listing-card', [
                                'rental' => $rental,
                                'trackPrefix' => 'all'
                            ])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif


        {{-- ========================= --}}
        {{-- COUNTY SECTIONS --}}
        {{-- ========================= --}}
        @php
            $counties = ['Dublin', 'Galway', 'Limerick', 'Cork', 'Kildare'];
        @endphp

        @foreach ($counties as $county)
            @php
                $countyListings = collect($listings)->where('county', $county);
            @endphp

            <div class="mt-10 county-section" data-county="{{ $county }}">
                <h2 class="text-xl font-bold text-slate-900 mb-3">{{ $county }}</h2>

                @if ($countyListings->count() > 0)

                    {{-- ============= --}}
                    {{-- MOBILE CARDS --}}
                    {{-- ============= --}}
                    <div class="flex gap-4 overflow-x-auto pb-2 lg:hidden">
                        @foreach ($countyListings as $rental)
                    
                            <!--@php
                                $images = json_decode($rental->images ?? '[]', true) ?? [];
                                $imgCount = count($images);
                            @endphp -->

                            {{-- 50% WIDER: min-w-[390px] --}}
                            <div class="min-w-[390px] bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">

                                {{-- Carousel --}}
                                <div class="relative" data-carousel data-key="mobile-{{ $rental->id }}" data-count="{{ $imgCount }}">
                                    <div class="overflow-hidden rounded-lg">
                                        <div id="track-mobile-{{ $rental->id }}" class="flex transition-transform duration-300 ease-out">
                                            @forelse ($images as $img)

                                                <div class="w-full shrink-0">
                                                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-40 object-cover rounded-lg" />
                                                </div>
                                            @empty
                                                <div class="w-full h-40 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500">
                                                    No image
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    @if ($imgCount > 1)
                                        <button onclick="prevImage('mobile', {{ $rental->id }})"
                                            class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">‹</button>

                                        <button onclick="nextImage('mobile', {{ $rental->id }})"
                                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">›</button>
                                    @endif
                                </div>

                                {{-- CLICKABLE DETAILS --}}
                                <a href="{{ route('listing.show', $rental->id) }}" class="block mt-3">

                                    {{-- Address --}}
                                    <div class="font-semibold text-slate-900">
                                        {{ $rental->housenumber ? $rental->housenumber . ' ' : '' }}
                                        {{ $rental->street }}, {{ $rental->county }}
                                    </div>

                                    {{-- House Type --}}
                                     <p class="text-sm text-slate-600">
                                        {{ [
                                            'any' => 'Any',
                                            'single_private' => 'Single room in private home',
                                            'private_shared' => 'Private room in shared house',
                                            'whole_property_group' => 'Whole property (group application only)',
                                        ][trim($rental->housetype ?? '')] ?? trim($rental->housetype ?? '') }}
                                    </p>   

                                    
                                    <!-- @if ($rental->housetype)
                                        <div class="text-sm text-slate-700 mt-1">
                                            {{ $rental->housetype }}
                                        </div>
                                    @endif -->

                                    {{-- Nights per Week --}}
                                    @if ($rental->nightsperweek)
                                        <div class="text-sm text-slate-700">
                                            {{ $rental->nightsperweek }} nights / week
                                        </div>
                                    @endif

                                    {{-- Availability --}}
                                    <div class="text-sm text-slate-600 mt-1">
                                        Available: {{ $rental->availablefrom }} → {{ $rental->availableuntil }}
                                    </div>

                                    {{-- Price --}}
                                    <div class="text-base text-slate-800 font-bold mt-2">
                                        €{{ number_format($rental->rentpermonth, 2) }} / month
                                    </div>

                                </a>
                            </div>
                        @endforeach
                    </div>


                    {{-- ============== --}}
                    {{-- DESKTOP CARDS --}}
                    {{-- ============== --}}
                    {{-- 50% WIDER: 2 columns --}}
                    <div class="hidden lg:grid lg:grid-cols-2 lg:gap-6">
                        @foreach ($countyListings as $rental)

                            @php
                                $images = json_decode($rental->images ?? '[]', true) ?? [];
                                $imgCount = count($images);
                            @endphp

                            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">

                                {{-- Carousel --}}
                                <div class="relative" data-carousel data-key="desktop-{{ $rental->id }}" data-count="{{ $imgCount }}">
                                    <div class="overflow-hidden rounded-lg">
                                        <div id="track-desktop-{{ $rental->id }}" class="flex transition-transform duration-300 ease-out">
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
                                        <button onclick="prevImage('desktop', {{ $rental->id }})"
                                            class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">‹</button>

                                        <button onclick="nextImage('desktop', {{ $rental->id }})"
                                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">›</button>
                                    @endif
                                </div>

                                {{-- CLICKABLE DETAILS --}}
                                <a href="{{ route('listing.show', $rental->id) }}" class="block mt-3">

                                    {{-- Address --}}
                                    <div class="font-semibold text-slate-900">
                                        {{ $rental->housenumber ? $rental->housenumber . ' ' : '' }}
                                        {{ $rental->street }}, {{ $rental->county }}
                                    </div>

                                    {{-- House Type --}}
                                    <!--@if ($rental->housetype)
                                        <div class="text-sm text-slate-700 mt-1">
                                            {{ $rental->housetype }}
                                        </div>
                                    @endif -->
                                     <p class="text-sm text-slate-600">
                                        {{ [
                                            'any' => 'Any',
                                            'single_private' => 'Single room in private home',
                                            'private_shared' => 'Private room in shared house',
                                            'whole_property_group' => 'Whole property (group application only)',
                                        ][trim($rental->housetype ?? '')] ?? trim($rental->housetype ?? '') }}
                                    </p>                                       

                                    {{-- Nights per Week --}}
                                    @if ($rental->nightsperweek)
                                        <div class="text-sm text-slate-700">
                                            {{ $rental->nightsperweek }} nights / week
                                        </div>
                                    @endif

                                    {{-- Availability --}}
                                    <div class="text-sm text-slate-600 mt-1">
                                        Available: {{ $rental->availablefrom }} → {{ $rental->availableuntil }}
                                    </div>

                                    {{-- Price --}}
                                    <div class="text-base text-slate-800 font-bold mt-2">
                                        €{{ number_format($rental->rentpermonth, 2) }} / month
                                    </div>

                                </a>

                            </div>
                        @endforeach
                    </div>


                @else
                    {{-- NO LISTINGS UI --}}
                    <div class="flex gap-4 overflow-x-auto pb-2 lg:hidden">
                        <div class="min-w-[390px] bg-white rounded-xl border border-slate-200 shadow-sm p-4">
                            <div class="font-semibold text-slate-700">No listings available yet</div>
                            <div class="text-slate-500 text-sm mt-1">
                                Listings in {{ $county }} will appear here.
                            </div>
                        </div>
                    </div>

                    <div class="hidden lg:grid lg:grid-cols-2 lg:gap-6">
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
                            <div class="font-semibold text-slate-700">No listings available yet</div>
                            <div class="text-slate-500 text-sm mt-1">
                                Listings in {{ $county }} will appear here.
                            </div>
                        </div>
                    </div>

                @endif
            </div>
        @endforeach
    </div>

    {{-- CAROUSEL SCRIPT --}}
    <script>
    // Filter drawer toggle
    const filterBtn = document.getElementById('filterToggle');
    const drawer = document.getElementById('filterDrawer');
    if (filterBtn && drawer) {
        filterBtn.addEventListener('click', () => drawer.classList.toggle('hidden'));
    }

    // Auto-submit search on Enter
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.querySelector('input[name="q"]').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') searchForm.submit();
        });
    }

    // Carousel state
    const carouselState = {};

    function stateKey(view, id) { return `${view}-${id}`; }

    function updateCarousel(view, id) {
        const key = stateKey(view, id);
        const track = document.getElementById(`track-${view}-${id}`);
        if (!track) return;
        const state = carouselState[key] || { index: 0, count: track.children.length };
        track.style.transform = `translateX(-${state.index * 100}%)`;
        Array.from(track.children).forEach(child => child.style.width = "100%");
    }

    function nextImage(view, id) {
        const key = stateKey(view, id);
        const container = document.querySelector(`[data-key="${view}-${id}"]`);
        const count = parseInt(container?.dataset.count || '0', 10);
        if (!carouselState[key]) carouselState[key] = { index: 0, count };
        if (count <= 1) return;
        carouselState[key].index = (carouselState[key].index + 1) % count;
        updateCarousel(view, id);
    }

    function prevImage(view, id) {
        const key = stateKey(view, id);
        const container = document.querySelector(`[data-key="${view}-${id}"]`);
        const count = parseInt(container?.dataset.count || '0', 10);
        if (!carouselState[key]) carouselState[key] = { index: 0, count };
        if (count <= 1) return;
        carouselState[key].index = carouselState[key].index === 0 ? count - 1 : carouselState[key].index - 1;
        updateCarousel(view, id);
    }

    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll("[data-carousel]").forEach(carousel => {
            const key = carousel.dataset.key;
            const [view, id] = key.split("-");
            const count = parseInt(carousel.dataset.count || '0', 10);
            carouselState[key] = { index: 0, count };
            updateCarousel(view, id);
        });
    });

    // Premium/All row scrolling
    const rowIndex = { premium: 0, all: 0 };

    function scrollRow(type, direction) {
        const track = document.getElementById(`${type}-track`);
        if (!track) return;
        const cardWidth = track.children[0]?.offsetWidth || 420;
        const gap = 24;
        const visible = track.parentElement.offsetWidth;
        const max = Math.ceil((track.scrollWidth - visible) / (cardWidth + gap));
        rowIndex[type] = Math.max(0, Math.min(rowIndex[type] + direction, max));
        track.style.transform = `translateX(-${rowIndex[type] * (cardWidth + gap)}px)`;
    }
</script>


</x-app-layout>
