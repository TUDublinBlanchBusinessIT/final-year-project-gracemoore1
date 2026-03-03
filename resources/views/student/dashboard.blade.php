<x-app-layout>

    {{-- Header: titles on the left, no duplicate hamburger (UNCHANGED) --}}
    <x-slot name="header">
        <div class="flex items-start justify-start">
            <div class="text-left">
                <div class="text-2xl font-extrabold text-blue-600 leading-none">RentConnect</div>
                <div class="mt-1 font-semibold text-gray-800">Dashboard</div>
            </div>
        </div>
    </x-slot>

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

        {{-- Welcome (UNCHANGED) --}}
        <h1 class="text-2xl font-bold text-slate-900 mb-4">
            Welcome back, {{ $student->firstname ?? $student->name ?? 'Student' }}!
        </h1>

        {{-- SEARCH BAR (UNCHANGED) --}}
        <div class="flex items-center bg-white border border-slate-300 rounded-xl px-4 py-3 shadow-sm">
            <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 21l-4.35-4.35M10 4a6 6 0 1 0 0 12 6 6 0 0 0 0-12z" />
            </svg>

            <input type="text" placeholder="Search listings..."
                   class="ml-3 w-full focus:ring-0 border-none focus:outline-none text-slate-800" />

            {{-- Filter toggle (SVG icon, no emoji) --}}
            <button id="filterToggle" class="ml-3 text-slate-600 hover:text-blue-600" title="Filters" aria-label="Filters">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 6h18M6 12h12M10 18h8" />
                </svg>
            </button>
        </div>

        {{-- COLLEGE CHIPS (UNCHANGED) --}}
        <div class="mt-4 flex gap-2 overflow-x-auto pb-2">
            @foreach ($collegeToCounty as $college => $county)
                <button
                    onclick="filterCounty('{{ $county }}')"
                    class="shrink-0 px-3 py-2 rounded-full border border-blue-500 text-blue-600 bg-white text-sm font-semibold hover:bg-blue-50">
                    {{ $college }}
                </button>
            @endforeach
        </div>

        {{-- FILTER DRAWER (UNCHANGED) --}}
        <div id="filterDrawer"
             class="hidden bg-white border border-slate-300 rounded-xl shadow-sm px-6 py-6 mt-4">
            <form class="space-y-4">

                {{-- Location --}}
                <div>
                    <label class="font-semibold text-slate-700">Location</label>
                    <input id="countyInput" type="text"
                           class="w-full mt-1 rounded-lg border-slate-300"
                           placeholder="Dublin" />
                </div>

                {{-- House Type --}}
                <div>
                    <label class="font-semibold text-slate-700">House Type</label>
                    <select class="w-full mt-1 rounded-lg border-slate-300">
                        <option>Any</option>
                        <option>Single Room in Private Home</option>
                        <option>Shared Student House</option>
                    </select>
                </div>

                {{-- Available Dates --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-slate-700">Available From</label>
                        <input type="date" class="w-full mt-1 rounded-lg border-slate-300" />
                    </div>
                    <div>
                        <label class="font-semibold text-slate-700">Until</label>
                        <input type="date" class="w-full mt-1 rounded-lg border-slate-300" />
                    </div>
                </div>

                {{-- Rent Range --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-slate-700">Min Rent (€)</label>
                        <input type="number" class="w-full mt-1 rounded-lg border-slate-300" />
                    </div>
                    <div>
                        <label class="font-semibold text-slate-700">Max Rent (€)</label>
                        <input type="number" class="w-full mt-1 rounded-lg border-slate-300" />
                    </div>
                </div>

                {{-- Nights per Week --}}
                <div>
                    <label class="font-semibold text-slate-700">Nights per Week</label>
                    <select class="w-full mt-1 rounded-lg border-slate-300">
                        <option>Any</option>
                        <option>1–3 nights</option>
                        <option>4–5 nights</option>
                        <option>Full week</option>
                    </select>
                </div>

                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold">
                    Apply Filters
                </button>
            </form>
        </div>

        {{-- ========================= --}}
        {{-- COUNTY SECTIONS (CHANGED) --}}
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

                    {{-- NEW: MOBILE cards with image carousel and click-through --}}
                    <div class="flex gap-4 overflow-x-auto pb-2 lg:hidden">
                        @foreach ($countyListings as $rental)
                            @php
                                $images = json_decode($rental->images ?? '[]', true) ?? [];
                                $imgCount = count($images);
                            @endphp

                            <a href="{{ route('listing.show', $rental->id) }}"
                               class="min-w-[260px] bg-white rounded-xl border border-slate-200 shadow-sm p-4 block hover:shadow-md transition">

                                {{-- NEW: Carousel (mobile) --}}
                                <div class="relative" data-carousel data-key="mobile-{{ $rental->id }}" data-count="{{ $imgCount }}">
                                    <div id="track-mobile-{{ $rental->id }}" class="flex transition-transform duration-300 ease-out">
                                        @forelse ($images as $img)
                                            <div class="w-full shrink-0">
                                                <img src="{{ asset('storage/' . $img) }}"
                                                     alt="Listing image"
                                                     class="w-full h-40 object-cover rounded-lg">
                                            </div>
                                        @empty
                                            <div class="w-full h-40 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 text-sm">
                                                No image
                                            </div>
                                        @endforelse
                                    </div>

                                    @if ($imgCount > 1)
                                        <button type="button"
                                                onclick="prevImage('mobile', {{ $rental->id }})"
                                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-slate-700 px-2 py-1 rounded-full shadow">
                                            ‹
                                        </button>
                                        <button type="button"
                                                onclick="nextImage('mobile', {{ $rental->id }})"
                                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-slate-700 px-2 py-1 rounded-full shadow">
                                            ›
                                        </button>
                                    @endif
                                </div>

                                {{-- NEW: Full address (house number optional) --}}
                                <div class="font-semibold text-slate-900 mt-3">
                                    {{ $rental->housenumber ? $rental->housenumber . ' ' : '' }}
                                    {{ $rental->street }}, {{ $rental->county }}
                                </div>

                                {{-- NEW: Availability --}}
                                <div class="text-sm text-slate-600 mt-1">
                                    Available: {{ $rental->availablefrom }} → {{ $rental->availableuntil }}
                                </div>

                                {{-- NEW: Rent --}}
                                <div class="text-base text-slate-800 font-bold mt-2">
                                    €{{ number_format($rental->rentpermonth, 2) }} / month
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- NEW: DESKTOP 3-column cards with image carousel and click-through --}}
                    <div class="hidden lg:grid lg:grid-cols-3 lg:gap-4">
                        @foreach ($countyListings as $rental)
                            @php
                                $images = json_decode($rental->images ?? '[]', true) ?? [];
                                $imgCount = count($images);
                            @endphp

                            <a href="{{ route('listing.show', $rental->id) }}"
                               class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 block hover:shadow-md transition">

                                {{-- NEW: Carousel (desktop) --}}
                                <div class="relative" data-carousel data-key="desktop-{{ $rental->id }}" data-count="{{ $imgCount }}">
                                    <div id="track-desktop-{{ $rental->id }}" class="flex transition-transform duration-300 ease-out">
                                        @forelse ($images as $img)
                                            <div class="w-full shrink-0">
                                                <img src="{{ asset('storage/' . $img) }}"
                                                     alt="Listing image"
                                                     class="w-full h-48 object-cover rounded-lg">
                                            </div>
                                        @empty
                                            <div class="w-full h-48 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 text-sm">
                                                No image
                                            </div>
                                        @endforelse
                                    </div>

                                    @if ($imgCount > 1)
                                        <button type="button"
                                                onclick="prevImage('desktop', {{ $rental->id }})"
                                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-slate-700 px-2 py-1 rounded-full shadow">
                                            ‹
                                        </button>
                                        <button type="button"
                                                onclick="nextImage('desktop', {{ $rental->id }})"
                                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-slate-700 px-2 py-1 rounded-full shadow">
                                            ›
                                        </button>
                                    @endif
                                </div>

                                {{-- NEW: Full address (house number optional) --}}
                                <div class="font-semibold text-slate-900 mt-3">
                                    {{ $rental->housenumber ? $rental->housenumber . ' ' : '' }}
                                    {{ $rental->street }}, {{ $rental->county }}
                                </div>

                                {{-- NEW: Availability --}}
                                <div class="text-sm text-slate-600 mt-1">
                                    Available: {{ $rental->availablefrom }} → {{ $rental->availableuntil }}
                                </div>

                                {{-- NEW: Rent --}}
                                <div class="text-base text-slate-800 font-bold mt-2">
                                    €{{ number_format($rental->rentpermonth, 2) }} / month
                                </div>
                            </a>
                        @endforeach
                    </div>

                @else
                    {{-- Fallback when no listings for this county (UNCHANGED) --}}
                    <div class="flex gap-4 overflow-x-auto pb-2 lg:hidden">
                        <div class="min-w-[260px] bg-white rounded-xl border border-slate-200 shadow-sm p-4">
                            <div class="font-semibold text-slate-700">No listings available yet</div>
                            <div class="text-slate-500 text-sm mt-1">
                                Listings in {{ $county }} will appear here.
                            </div>
                        </div>
                    </div>

                    <div class="hidden lg:grid lg:grid-cols-3 lg:gap-4">
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

    <script>
        // Filter drawer toggle (UNCHANGED)
        const filterBtn = document.getElementById('filterToggle');
        const drawer = document.getElementById('filterDrawer');
        if (filterBtn && drawer) {
            filterBtn.addEventListener('click', () => drawer.classList.toggle('hidden'));
        }

        function filterCounty(county) {
            document.querySelectorAll('.county-section').forEach(section => {
                section.classList.toggle('hidden', section.dataset.county !== county);
            });
            const input = document.getElementById('countyInput');
            if (input) input.value = county;
        }

        // NEW: Simple per-card carousel state and controls
        const carouselState = {}; // key -> { index, count }

        function keyFor(view, id) { return `${view}-${id}`; }

        function updateCarousel(view, id) {
            const key = keyFor(view, id);
            const track = document.getElementById(`track-${view}-${id}`);
            if (!track) return;
            const state = carouselState[key] || { index: 0, count: track.children.length };
            const translate = -state.index * 100;
            track.style.transform = `translateX(${translate}%)`;

            // Ensure each slide fills the container width
            Array.from(track.children).forEach(child => {
                child.style.width = '100%';
            });
        }

        function nextImage(view, id) {
            const key = keyFor(view, id);
            const container = document.querySelector(`[data-key="${view}-${id}"]`);
            const count = parseInt(container?.dataset.count || '0', 10) || 0;
            if (!carouselState[key]) carouselState[key] = { index: 0, count };
            carouselState[key].index = (carouselState[key].index + 1) % Math.max(count, 1);
            updateCarousel(view, id);
        }

        function prevImage(view, id) {
            const key = keyFor(view, id);
            const container = document.querySelector(`[data-key="${view}-${id}"]`);
            const count = parseInt(container?.dataset.count || '0', 10) || 0;
            if (!carouselState[key]) carouselState[key] = { index: 0, count };
            carouselState[key].index = (carouselState[key].index - 1 + Math.max(count, 1)) % Math.max(count, 1);
            updateCarousel(view, id);
        }

        // Initialize all carousels on load
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-carousel]').forEach(container => {
                const key = container.getAttribute('data-key') || '';
                const [view, id] = key.split('-');
                const count = parseInt(container.getAttribute('data-count') || '0', 10) || 0;
                carouselState[key] = { index: 0, count };
                updateCarousel(view, id);
            });
        });
    </script>

</x-app-layout>

