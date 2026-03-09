
<x-app-layout>

    {{-- Header --}}
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800">
            Listing Details
        </h2>
    </x-slot>

    <div class="mb-4">
        <a href="{{ url()->previous() }}" 
        class="inline-block px-4 py-2 bg-gray-200 text-gray-800 text-sm rounded hover:bg-gray-300">
            ← Back
        </a>
    </div>

    <div class="max-w-5xl mx-auto mt-6 px-4 sm:px-6 lg:px-8">

        @php
            // Images are stored as JSON array like: ["rentals/abc.jpg", "rentals/def.jpg"]
            $images = json_decode($rental->images ?? '[]', true) ?? [];
            $imgCount = count($images);
        @endphp

        {{-- IMAGE GALLERY (LARGE) --}}
        <div class="relative bg-white rounded-xl border border-slate-200 shadow overflow-hidden">
            <div id="detail-track-{{ $rental->id }}" class="flex transition-transform duration-300 ease-out">
                @forelse ($images as $img)
                    <div class="w-full shrink-0">
                        <div class="w-full h-72 sm:h-80 md:h-[28rem] bg-slate-100">
                            <img
                                src="{{ asset('storage/' . $img) }}"
                                alt="Listing photo {{ $loop->iteration }}"
                                class="w-full h-full object-cover" />
                        </div>
                    </div>
                @empty
                    <div class="w-full shrink-0">
                        <div class="w-full h-72 sm:h-80 md:h-[28rem] bg-slate-100 flex items-center justify-center text-slate-500">
                            No images available
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($imgCount > 1)
                {{-- Prev/Next controls --}}
                <button
                    type="button"
                    onclick="detailPrev({{ $rental->id }})"
                    class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-slate-700 px-3 py-2 rounded-full shadow">
                    ‹
                </button>

                <button
                    type="button"
                    onclick="detailNext({{ $rental->id }})"
                    class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-slate-700 px-3 py-2 rounded-full shadow">
                    ›
                </button>
            @endif
        </div>

        {{-- DETAILS CARD --}}
        <div class="bg-white border border-slate-200 rounded-xl p-6 mt-6 shadow space-y-4">

            {{-- Full Address (house number optional) --}}
            <h1 class="text-2xl font-bold text-slate-900">
                {{ $rental->housenumber ? $rental->housenumber . ' ' : '' }}
                {{ $rental->street }}, {{ $rental->county }}
                @if(!empty($rental->postcode))
                    , {{ $rental->postcode }}
                @endif
            </h1>

            {{-- Size & Status --}}
            <div class="flex flex-wrap items-center gap-3 text-slate-700">
                @if(!empty($rental->measurement))
                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-sm">
                        Size: {{ $rental->measurement }}
                    </span>
                @endif

                @if(!empty($rental->status))
                    <span class="inline-flex items-center rounded-full border px-3 py-1 text-sm
                        {{ $rental->status === 'available'
                            ? 'bg-green-50 text-green-700 border-green-200'
                            : 'bg-slate-100 text-slate-700 border-slate-200' }}">
                        {{ ucfirst($rental->status) }}
                    </span>
                @endif
            </div>


                        {{-- Additional Listing Details --}}
            <div class="space-y-2 text-slate-700">

                {{-- House Type --}}
                @if(!empty($rental->housetype))
                    <div>
                        <span class="font-semibold">House Type:</span>
                        {{ $rental->housetype }}
                    </div>
                @endif

                {{-- Accommodation Type --}}
                @if(!empty($rental->accommodation_type))
                    <div>
                        <span class="font-semibold">Accommodation Type:</span>
                        {{ ucfirst($rental->accommodation_type) }}
                    </div>
                @endif

                                {{-- Application Type --}}
                @if(!empty($rental->application_type))
                    <div>
                        <span class="font-semibold">Application Type:</span>
                        {{ ucfirst($rental->application_type) }}
                    </div>
                @endif

                {{-- Nights Per Week --}}
                @if(!empty($rental->nightsperweek))
                    <div>
                        <span class="font-semibold">Nights per Week:</span>
                        {{ $rental->nightsperweek }}
                    </div>
                @endif

                {{-- Measurement (already present but you can move it here if you want) --}}
                @if(!empty($rental->measurement))
                    <div>
                        <span class="font-semibold">Size:</span>
                        {{ $rental->measurement }}
                    </div>
                @endif

            </div>
            {{-- Availability --}}
            <div class="text-slate-700">
                <span class="font-semibold">Availability:</span>
                {{ $rental->availablefrom }} → {{ $rental->availableuntil }}
            </div>

            {{-- Rent --}}
            <div class="text-slate-900 font-bold text-xl">
                €{{ number_format($rental->rentpermonth, 2) }} / month
            </div>

            {{-- Description --}}
            @if(!empty($rental->description))
                <div class="pt-2">
                    <h2 class="text-lg font-semibold text-slate-900 mb-1">Description</h2>
                    <p class="text-slate-700 leading-relaxed">
                        {{ $rental->description }}
                    </p>
                </div>
            @endif



            {{-- Apply button (no action yet) --}}
                <button type="button"
                        onclick="openApplyModal()"
                        class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold">
                    Apply Now
                </button>
        </div>
    </div>

    {{-- GALLERY SCRIPT (per-listing state) --}}
    <script>
        // Maintain per-listing gallery state in a simple map.
        const detailState = {}; // key: rentalId -> { index, count }

        function ensureDetailState(id) {
            if (!detailState[id]) {
                const track = document.getElementById(`detail-track-${id}`);
                const count = track ? track.children.length : 0;
                detailState[id] = { index: 0, count: count };
                // Make each slide fill container width
                if (track) {
                    Array.from(track.children).forEach(child => {
                        child.style.width = '100%';
                    });
                }
            }
            return detailState[id];
        }

        function detailUpdate(id) {
            const track = document.getElementById(`detail-track-${id}`);
            if (!track) return;
            const state = ensureDetailState(id);
            const translate = -state.index * 100;
            track.style.transform = `translateX(${translate}%)`;
        }

        function detailNext(id) {
            const state = ensureDetailState(id);
            if (state.count <= 1) return;
            state.index = (state.index + 1) % state.count;
            detailUpdate(id);
        }

        function detailPrev(id) {
            const state = ensureDetailState(id);
            if (state.count <= 1) return;

            state.index = (state.index - 1 + state.count) % state.count;
            detailUpdate(id);
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', () => {
            const track = document.getElementById('detail-track-{{ $rental->id }}');
            if (track) {
                ensureDetailState({{ $rental->id }});
                detailUpdate({{ $rental->id }});
            }
        });
    </script>
        <!-- Application Modal -->
        <div id="applyModal"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden justify-center items-center p-4">
            <div class="bg-white w-full max-w-md rounded-xl shadow-xl p-6 space-y-4">

                <h2 class="text-xl font-bold text-slate-800 text-center">
                    Choose Application Type
                </h2>

                <div class="space-y-3">
                    <button onclick="selectApplicationType('single')"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold">
                        Single Application
                    </button>

                    <button onclick="selectApplicationType('group')"
                        class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg font-semibold">
                        Group Application
                    </button>
                </div>

                <button onclick="closeApplyModal()"
                    class="w-full mt-4 text-slate-600 hover:text-slate-800 font-medium underline">
                    Cancel
                </button>

            </div>
        </div>
        <script>
            function openApplyModal() {
                document.getElementById('applyModal').classList.remove('hidden');
                document.getElementById('applyModal').classList.add('flex');
            }

            function closeApplyModal() {
                document.getElementById('applyModal').classList.add('hidden');
                document.getElementById('applyModal').classList.remove('flex');
            }

            function selectApplicationType(type) {
                // Redirect to a dedicated route
                window.location.href = "/applications/start/{{ $rental->id }}/" + type;
            }
        </script>
</x-app-layout>