<x-app-layout>

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

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Welcome back, {{ $student->firstname ?? $student->name ?? 'Student' }}!
        </h2>
    </x-slot>

    <div class="pb-28">

        {{-- STUDENT pages are now left-aligned by app.blade.php --}}
        <div class="w-full px-4 sm:px-6 lg:px-8">

            {{-- SEARCH BAR --}}
            <div class="mt-6">
                <div class="flex items-center bg-white border border-slate-300 rounded-xl px-4 py-3 shadow-sm">

                    <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-4.35-4.35M10 4a6 6 0 100 12 6 6 0 000-12z" />
                    </svg>

                    <input type="text" placeholder="Search listings..."
                        class="ml-3 w-full focus:ring-0 border-none focus:outline-none text-slate-800" />

                    <button id="filterToggle" class="ml-3 text-slate-600 hover:text-blue-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 6h18M6 12h12M10 18h4" />
                        </svg>
                    </button>
                </div>
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

            {{-- FILTER DRAWER (RESTORED) --}}
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

            {{-- COUNTY SECTIONS --}}
            @php
                $counties = ['Dublin', 'Galway', 'Limerick', 'Cork', 'Kildare'];
            @endphp

            @foreach ($counties as $county)
                <div class="mt-10 county-section" data-county="{{ $county }}">
                    <h2 class="text-xl font-bold text-slate-900 mb-3">{{ $county }}</h2>

                    {{-- MOBILE SWIPE --}}
                    <div class="flex gap-4 overflow-x-auto pb-2 lg:hidden">
                        <div class="min-w-[260px] bg-white rounded-xl border border-slate-200 shadow-sm p-4">
                            <div class="font-semibold text-slate-700">No listings available yet</div>
                            <div class="text-slate-500 text-sm mt-1">
                                Listings in {{ $county }} will appear here.
                            </div>
                        </div>
                    </div>

                    {{-- DESKTOP: 3 ACROSS --}}
                    <div class="hidden lg:grid lg:grid-cols-3 lg:gap-4">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
                                <div class="font-semibold text-slate-700">No listings available yet</div>
                                <div class="text-slate-500 text-sm mt-1">
                                    Listings in {{ $county }} will appear here.
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <script>
        const filterBtn = document.getElementById('filterToggle');
        const drawer = document.getElementById('filterDrawer');

        if (filterBtn && drawer) {
            filterBtn.addEventListener('click', () => drawer.classList.toggle('hidden'));
        }

        function filterCounty(county) {
            document.querySelectorAll('.county-section').forEach(section => {
                if (section.dataset.county === county) {
                    section.classList.remove('hidden');
                } else {
                    section.classList.add('hidden');
                }
            });

            const input = document.getElementById('countyInput');
            if (input) input.value = county;
        }
    </script>

</x-app-layout>