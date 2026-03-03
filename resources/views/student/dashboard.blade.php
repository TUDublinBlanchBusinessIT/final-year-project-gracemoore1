<x-app-layout>

    {{-- Header --}}
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

        {{-- Welcome --}}
        <h1 class="text-2xl font-bold text-slate-900 mb-4">
            Welcome back, {{ $student->firstname ?? $student->name ?? 'Student' }}!
        </h1>

        {{-- SEARCH BAR --}}
        <div class="flex items-center bg-white border border-slate-300 rounded-xl px-4 py-3 shadow-sm">
            <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 21l-4.35-4.35M10 4a6 6 0 100 12 6 6 0 000-12z" />
            </svg>

            <input type="text" placeholder="Search listings..."
                   class="ml-3 w-full focus:ring-0 border-none focus:outline-none text-slate-800" />

            <button id="filterToggle" class="ml-3 text-slate-600 hover:text-blue-600" title="Filters" aria-label="Filters">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 6h18M6 12h12M10 18h8" />
                </svg>
            </button>
        </div>

        {{-- COLLEGE CHIPS --}}
        <div class="mt-4 flex gap-2 overflow-x-auto pb-2">
            @foreach ($collegeToCounty as $college => $county)
                <button
                    onclick="filterCounty('{{ $county }}')"
                    class="shrink-0 px-3 py-2 rounded-full border border-blue-500 text-blue-600 bg-white text-sm font-semibold hover:bg-blue-50">
                    {{ $college }}
                </button>
            @endforeach
        </div>

        {{-- FILTER DRAWER --}}
        <div id="filterDrawer"
             class="hidden bg-white border border-slate-300 rounded-xl shadow-sm px-6 py-6 mt-4">
            <form class="space-y-4">

                <div>
                    <label class="font-semibold text-slate-700">Location</label>
                    <input id="countyInput" type="text"
                           class="w-full mt-1 rounded-lg border-slate-300"
                           placeholder="Dublin" />
                </div>

                <div>
                    <label class="font-semibold text-slate-700">House Type</label>
                    <select class="w-full mt-1 rounded-lg border-slate-300">
                        <option>Any</option>
                        <option>Single Room in Private Home</option>
                        <option>Shared Student House</option>
                    </select>
                </div>

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

        {{-- ******************************************************************************** --}}
        {{-- FINAL WORKING LISTINGS SECTION WITH IMAGES ON TOP --}}
        {{-- ******************************************************************************** --}}
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

                    {{-- MOBILE --}}
                    <div class="flex gap-4 overflow-x-auto pb-2 lg:hidden">
                        @foreach ($countyListings as $rental)

                            @php
                                $imgs = json_decode($rental->images, true);
                                $img = $imgs[0] ?? null;
                            @endphp

                            <div class="min-w-[260px] bg-white rounded-xl border border-slate-200 shadow-sm p-4">

                                {{-- IMAGE --}}
                                @if ($img)
                                    <img src="{{ asset('storage/' . $img) }}"
                                         class="w-full h-40 object-cover rounded-xl mb-3" />
                                @endif

                                {{-- FULL ADDRESS --}}
                                <div class="font-semibold text-slate-900">
                                    {{ $rental->housenumber ? $rental->housenumber . ' ' : '' }}
                                    {{ $rental->street }}, {{ $rental->county }}
                                </div>

                                {{-- AVAILABILITY --}}
                                <div class="text-sm text-slate-600 mt-1">
                                    Available: {{ $rental->availablefrom }} → {{ $rental->availableuntil }}
                                </div>

                                {{-- RENT --}}
                                <div class="text-base text-slate-800 font-bold mt-2">
                                    €{{ number_format($rental->rentpermonth, 2) }} / month
                                </div>

                            </div>

                        @endforeach
                    </div>

                    {{-- DESKTOP --}}
                    <div class="hidden lg:grid lg:grid-cols-3 lg:gap-4">
                        @foreach ($countyListings as $rental)

                            @php
                                $imgs = json_decode($rental->images, true);
                                $img = $imgs[0] ?? null;
                            @endphp

                            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">

                                {{-- IMAGE --}}
                                @if ($img)
                                    <img src="{{ asset('storage/' . $img) }}"
                                         class="w-full h-40 object-cover rounded-xl mb-3" />
                                @endif

                                {{-- FULL ADDRESS --}}
                                <div class="font-semibold text-slate-900">
                                    {{ $rental->housenumber ? $rental->housenumber . ' ' : '' }}
                                    {{ $rental->street }}, {{ $rental->county }}
                                </div>

                                {{-- AVAILABILITY --}}
                                <div class="text-sm text-slate-600 mt-1">
                                    Available: {{ $rental->availablefrom }} → {{ $rental->availableuntil }}
                                </div>

                                {{-- RENT --}}
                                <div class="text-base text-slate-800 font-bold mt-2">
                                    €{{ number_format($rental->rentpermonth, 2) }} / month
                                </div>

                            </div>

                        @endforeach
                    </div>

                @else

                    {{-- MOBILE NO-LISTINGS --}}
                    <div class="flex gap-4 overflow-x-auto pb-2 lg:hidden">
                        <div class="min-w-[260px] bg-white rounded-xl border border-slate-200 shadow-sm p-4">
                            <div class="font-semibold text-slate-700">No listings available yet</div>
                            <div class="text-slate-500 text-sm mt-1">
                                Listings in {{ $county }} will appear here.
                            </div>
                        </div>
                    </div>

                    {{-- DESKTOP NO-LISTINGS --}}
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
    </script>

</x-app-layout>