<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex items-start justify-start">
            <div class="text-left">
                <div class="text-2xl font-extrabold text-blue-600 leading-none">RentConnect</div>
                <div class="mt-1 font-semibold text-gray-800">Profile</div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 py-8">

        {{-- Sub-nav --}}
        <nav class="mt-3 border-b border-slate-200">
            <ul class="flex gap-6 text-sm">
                <li>
                    <a href="{{ route('student.profile.new.applications') }}"
                       class="{{ request()->routeIs('student.profile.new.applications')
                            ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                            : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        Applications
                    </a>
                </li>
                <li>
                    <a href="{{ route('student.profile.new.account') }}"
                       class="{{ request()->routeIs('student.profile.new.account')
                            ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                            : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        Account details
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Flash success --}}
        @if(session('success'))
            <div class="mt-4 mb-4 p-3 bg-green-100 text-green-800 rounded-lg border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        {{-- CONTENT: Applications --}}
        <div class="mt-6 space-y-10">

            {{-- ================= PENDING ================= --}}
            <section class="applications-pending">
                <h2 class="text-lg font-medium text-gray-900">Your Applications</h2>
                <h3 class="mt-4 text-base font-semibold text-blue-600">Pending</h3>

                @if($pending->isEmpty())
                    <p class="text-gray-500 mt-1">No pending applications.</p>
                @else
                    {{-- MOBILE: horizontal scroll --}}
                    <div class="mt-4 flex gap-4 overflow-x-auto pb-2 lg:hidden">
                        @foreach ($pending as $app)
                            @php $r = $app->rental; @endphp
                            @if(!$r) @continue @endif
                            @php
                                $images = json_decode($r->images ?? '[]', true) ?? [];
                                $imgCount = count($images);
                                $labelMap = [
                                    'any' => 'Any',
                                    'single_private' => 'Single room in private home',
                                    'private_shared' => 'Private room in shared house',
                                    'whole_property_group' => 'Whole property (group application only)',
                                ];
                            @endphp

                            <div class="min-w-[390px] bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">
                                {{-- Carousel --}}
                                <div class="relative" data-carousel data-key="app-mobile-{{ $r->id }}" data-count="{{ $imgCount }}">
                                    <div class="overflow-hidden rounded-lg">
                                        <div id="track-app-mobile-{{ $r->id }}" class="flex transition-transform duration-300 ease-out">
                                            @forelse ($images as $img)
                                                <div class="w-full shrink-0">
                                                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-40 object-cover rounded-lg" alt="Listing image" />
                                                </div>
                                            @empty
                                                <div class="w-full h-40 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500">
                                                    No image
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    @if ($imgCount > 1)
                                        <button onclick="prevImage('app-mobile', {{ $r->id }})"
                                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">‹</button>

                                        <button onclick="nextImage('app-mobile', {{ $r->id }})"
                                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">›</button>
                                    @endif
                                </div>

                                {{-- CLICKABLE DETAILS --}}
                                <a href="{{ route('listing.show', $r->id) }}" class="block mt-3">
                                    <div class="font-semibold text-slate-900">
                                        {{ $r->housenumber ? $r->housenumber . ' ' : '' }}
                                        {{ $r->street }}, {{ $r->county }}
                                    </div>

                                    <p class="text-sm text-slate-600">
                                        {{ $labelMap[trim($r->housetype ?? '')] ?? trim($r->housetype ?? '') }}
                                    </p>

                                    @if ($r->nightsperweek)
                                        <div class="text-sm text-slate-700">
                                            {{ $r->nightsperweek }} nights / week
                                        </div>
                                    @endif

                                    <div class="text-sm text-slate-600 mt-1">
                                        Available: {{ $r->availablefrom }} → {{ $r->availableuntil }}
                                    </div>

                                    <div class="text-base text-slate-800 font-bold mt-2">
                                        €{{ number_format((float)$r->rentpermonth, 2) }} / month
                                    </div>
                                </a>

                                {{-- Status badge --}}
                                <div class="mt-3 inline-block px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">
                                    Pending
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- DESKTOP: grid 2 columns (same as dashboard) --}}
                    <div class="hidden lg:grid lg:grid-cols-2 lg:gap-6">
                        @foreach ($pending as $app)
                            @php $r = $app->rental; @endphp
                            @if(!$r) @continue @endif
                            @php
                                $images = json_decode($r->images ?? '[]', true) ?? [];
                                $imgCount = count($images);
                                $labelMap = [
                                    'any' => 'Any',
                                    'single_private' => 'Single room in private home',
                                    'private_shared' => 'Private room in shared house',
                                    'whole_property_group' => 'Whole property (group application only)',
                                ];
                            @endphp

                            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">
                                {{-- Carousel --}}
                                <div class="relative" data-carousel data-key="app-desktop-{{ $r->id }}" data-count="{{ $imgCount }}">
                                    <div class="overflow-hidden rounded-lg">
                                        <div id="track-app-desktop-{{ $r->id }}" class="flex transition-transform duration-300 ease-out">
                                            @forelse ($images as $img)
                                                <div class="w-full shrink-0">
                                                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-48 object-cover rounded-lg" alt="Listing image" />
                                                </div>
                                            @empty
                                                <div class="w-full h-48 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500">
                                                    No image
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    @if ($imgCount > 1)
                                        <button onclick="prevImage('app-desktop', {{ $r->id }})"
                                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">‹</button>

                                        <button onclick="nextImage('app-desktop', {{ $r->id }})"
                                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">›</button>
                                    @endif
                                </div>

                                {{-- CLICKABLE DETAILS --}}
                                <a href="{{ route('listing.show', $r->id) }}" class="block mt-3">
                                    <div class="font-semibold text-slate-900">
                                        {{ $r->housenumber ? $r->housenumber . ' ' : '' }}
                                        {{ $r->street }}, {{ $r->county }}
                                    </div>

                                    <p class="text-sm text-slate-600">
                                        {{ $labelMap[trim($r->housetype ?? '')] ?? trim($r->housetype ?? '') }}
                                    </p>

                                    @if ($r->nightsperweek)
                                        <div class="text-sm text-slate-700">
                                            {{ $r->nightsperweek }} nights / week
                                        </div>
                                    @endif

                                    <div class="text-sm text-slate-600 mt-1">
                                        Available: {{ $r->availablefrom }} → {{ $r->availableuntil }}
                                    </div>

                                    <div class="text-base text-slate-800 font-bold mt-2">
                                        €{{ number_format((float)$r->rentpermonth, 2) }} / month
                                    </div>
                                </a>

                                {{-- Status badge --}}
                                <div class="mt-3 inline-block px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">
                                    Pending
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            {{-- ================= ACCEPTED ================= --}}
            <section class="applications-accepted">
                <h3 class="text-base font-semibold text-green-600">Accepted</h3>

                @if($accepted->isEmpty())
                    <p class="text-gray-500 mt-1">No accepted applications.</p>
                @else
                    {{-- MOBILE --}}
                    <div class="mt-4 flex gap-4 overflow-x-auto pb-2 lg:hidden">
                        @foreach ($accepted as $app)
                            @php $r = $app->rental; @endphp
                            @if(!$r) @continue @endif
                            @php
                                $images = json_decode($r->images ?? '[]', true) ?? [];
                                $imgCount = count($images);
                                $labelMap = [
                                    'any' => 'Any',
                                    'single_private' => 'Single room in private home',
                                    'private_shared' => 'Private room in shared house',
                                    'whole_property_group' => 'Whole property (group application only)',
                                ];
                            @endphp

                            <div class="min-w-[390px] bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">
                                <div class="relative" data-carousel data-key="acc-mobile-{{ $r->id }}" data-count="{{ $imgCount }}">
                                    <div class="overflow-hidden rounded-lg">
                                        <div id="track-acc-mobile-{{ $r->id }}" class="flex transition-transform duration-300 ease-out">
                                            @forelse ($images as $img)
                                                <div class="w-full shrink-0">
                                                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-40 object-cover rounded-lg" alt="Listing image" />
                                                </div>
                                            @empty
                                                <div class="w-full h-40 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500">No image</div>
                                            @endforelse
                                        </div>
                                    </div>

                                    @if ($imgCount > 1)
                                        <button onclick="prevImage('acc-mobile', {{ $r->id }})"
                                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">‹</button>
                                        <button onclick="nextImage('acc-mobile', {{ $r->id }})"
                                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">›</button>
                                    @endif
                                </div>

                                <a href="{{ route('listing.show', $r->id) }}" class="block mt-3">
                                    <div class="font-semibold text-slate-900">
                                        {{ $r->housenumber ? $r->housenumber . ' ' : '' }}
                                        {{ $r->street }}, {{ $r->county }}
                                    </div>
                                    <p class="text-sm text-slate-600">
                                        {{ $labelMap[trim($r->housetype ?? '')] ?? trim($r->housetype ?? '') }}
                                    </p>
                                    @if ($r->nightsperweek)
                                        <div class="text-sm text-slate-700">{{ $r->nightsperweek }} nights / week</div>
                                    @endif
                                    <div class="text-sm text-slate-600 mt-1">Available: {{ $r->availablefrom }} → {{ $r->availableuntil }}</div>
                                    <div class="text-base text-slate-800 font-bold mt-2">€{{ number_format((float)$r->rentpermonth, 2) }} / month</div>
                                </a>

                                <div class="mt-3 inline-block px-2 py-1 rounded text-xs bg-green-100 text-green-800">Accepted</div>
                            </div>
                        @endforeach
                    </div>

                    {{-- DESKTOP --}}
                    <div class="hidden lg:grid lg:grid-cols-2 lg:gap-6">
                        @foreach ($accepted as $app)
                            @php $r = $app->rental; @endphp
                            @if(!$r) @continue @endif
                            @php
                                $images = json_decode($r->images ?? '[]', true) ?? [];
                                $imgCount = count($images);
                                $labelMap = [
                                    'any' => 'Any',
                                    'single_private' => 'Single room in private home',
                                    'private_shared' => 'Private room in shared house',
                                    'whole_property_group' => 'Whole property (group application only)',
                                ];
                            @endphp

                            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">
                                <div class="relative" data-carousel data-key="acc-desktop-{{ $r->id }}" data-count="{{ $imgCount }}">
                                    <div class="overflow-hidden rounded-lg">
                                        <div id="track-acc-desktop-{{ $r->id }}" class="flex transition-transform duration-300 ease-out">
                                            @forelse ($images as $img)
                                                <div class="w-full shrink-0">
                                                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-48 object-cover rounded-lg" alt="Listing image" />
                                                </div>
                                            @empty
                                                <div class="w-full h-48 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500">No image</div>
                                            @endforelse
                                        </div>
                                    </div>

                                    @if ($imgCount > 1)
                                        <button onclick="prevImage('acc-desktop', {{ $r->id }})"
                                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">‹</button>
                                        <button onclick="nextImage('acc-desktop', {{ $r->id }})"
                                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">›</button>
                                    @endif
                                </div>

                                <a href="{{ route('listing.show', $r->id) }}" class="block mt-3">
                                    <div class="font-semibold text-slate-900">
                                        {{ $r->housenumber ? $r->housenumber . ' ' : '' }}
                                        {{ $r->street }}, {{ $r->county }}
                                    </div>
                                    <p class="text-sm text-slate-600">{{ $labelMap[trim($r->housetype ?? '')] ?? trim($r->housetype ?? '') }}</p>
                                    @if ($r->nightsperweek)
                                        <div class="text-sm text-slate-700">{{ $r->nightsperweek }} nights / week</div>
                                    @endif
                                    <div class="text-sm text-slate-600 mt-1">Available: {{ $r->availablefrom }} → {{ $r->availableuntil }}</div>
                                    <div class="text-base text-slate-800 font-bold mt-2">€{{ number_format((float)$r->rentpermonth, 2) }} / month</div>
                                </a>

                                <div class="mt-3 inline-block px-2 py-1 rounded text-xs bg-green-100 text-green-800">Accepted</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            {{-- ================= REJECTED ================= --}}
            <section class="applications-rejected">
                <h3 class="text-base font-semibold text-red-600">Rejected</h3>

                @if($rejected->isEmpty())
                    <p class="text-gray-500 mt-1">No rejected applications.</p>
                @else
                    {{-- MOBILE --}}
                    <div class="mt-4 flex gap-4 overflow-x-auto pb-2 lg:hidden">
                        @foreach ($rejected as $app)
                            @php $r = $app->rental; @endphp
                            @if(!$r) @continue @endif
                            @php
                                $images = json_decode($r->images ?? '[]', true) ?? [];
                                $imgCount = count($images);
                                $labelMap = [
                                    'any' => 'Any',
                                    'single_private' => 'Single room in private home',
                                    'private_shared' => 'Private room in shared house',
                                    'whole_property_group' => 'Whole property (group application only)',
                                ];
                            @endphp

                            <div class="min-w-[390px] bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">
                                <div class="relative" data-carousel data-key="rej-mobile-{{ $r->id }}" data-count="{{ $imgCount }}">
                                    <div class="overflow-hidden rounded-lg">
                                        <div id="track-rej-mobile-{{ $r->id }}" class="flex transition-transform duration-300 ease-out">
                                            @forelse ($images as $img)
                                                <div class="w-full shrink-0">
                                                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-40 object-cover rounded-lg" alt="Listing image" />
                                                </div>
                                            @empty
                                                <div class="w-full h-40 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500">No image</div>
                                            @endforelse
                                        </div>
                                    </div>

                                    @if ($imgCount > 1)
                                        <button onclick="prevImage('rej-mobile', {{ $r->id }})"
                                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">‹</button>
                                        <button onclick="nextImage('rej-mobile', {{ $r->id }})"
                                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">›</button>
                                    @endif
                                </div>

                                <a href="{{ route('listing.show', $r->id) }}" class="block mt-3">
                                    <div class="font-semibold text-slate-900">
                                        {{ $r->housenumber ? $r->housenumber . ' ' : '' }}
                                        {{ $r->street }}, {{ $r->county }}
                                    </div>
                                    <p class="text-sm text-slate-600">
                                        {{ $labelMap[trim($r->housetype ?? '')] ?? trim($r->housetype ?? '') }}
                                    </p>
                                    @if ($r->nightsperweek)
                                        <div class="text-sm text-slate-700">{{ $r->nightsperweek }} nights / week</div>
                                    @endif
                                    <div class="text-sm text-slate-600 mt-1">Available: {{ $r->availablefrom }} → {{ $r->availableuntil }}</div>
                                    <div class="text-base text-slate-800 font-bold mt-2">€{{ number_format((float)$r->rentpermonth, 2) }} / month</div>
                                </a>

                                <div class="mt-3 inline-block px-2 py-1 rounded text-xs bg-red-100 text-red-800">Rejected</div>
                            </div>
                        @endforeach
                    </div>

                    {{-- DESKTOP --}}
                    <div class="hidden lg:grid lg:grid-cols-2 lg:gap-6">
                        @foreach ($rejected as $app)
                            @php $r = $app->rental; @endphp
                            @if(!$r) @continue @endif
                            @php
                                $images = json_decode($r->images ?? '[]', true) ?? [];
                                $imgCount = count($images);
                                $labelMap = [
                                    'any' => 'Any',
                                    'single_private' => 'Single room in private home',
                                    'private_shared' => 'Private room in shared house',
                                    'whole_property_group' => 'Whole property (group application only)',
                                ];
                            @endphp

                            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">
                                <div class="relative" data-carousel data-key="rej-desktop-{{ $r->id }}" data-count="{{ $imgCount }}">
                                    <div class="overflow-hidden rounded-lg">
                                        <div id="track-rej-desktop-{{ $r->id }}" class="flex transition-transform duration-300 ease-out">
                                            @forelse ($images as $img)
                                                <div class="w-full shrink-0">
                                                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-48 object-cover rounded-lg" alt="Listing image" />
                                                </div>
                                            @empty
                                                <div class="w-full h-48 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500">No image</div>
                                            @endforelse
                                        </div>
                                    </div>

                                    @if ($imgCount > 1)
                                        <button onclick="prevImage('rej-desktop', {{ $r->id }})"
                                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">‹</button>
                                        <button onclick="nextImage('rej-desktop', {{ $r->id }})"
                                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">›</button>
                                    @endif
                                </div>

                                <a href="{{ route('listing.show', $r->id) }}" class="block mt-3">
                                    <div class="font-semibold text-slate-900">
                                        {{ $r->housenumber ? $r->housenumber . ' ' : '' }}
                                        {{ $r->street }}, {{ $r->county }}
                                    </div>
                                    <p class="text-sm text-slate-600">{{ $labelMap[trim($r->housetype ?? '')] ?? trim($r->housetype ?? '') }}</p>
                                    @if ($r->nightsperweek)
                                        <div class="text-sm text-slate-700">{{ $r->nightsperweek }} nights / week</div>
                                    @endif
                                    <div class="text-sm text-slate-600 mt-1">Available: {{ $r->availablefrom }} → {{ $r->availableuntil }}</div>
                                    <div class="text-base text-slate-800 font-bold mt-2">€{{ number_format((float)$r->rentpermonth, 2) }} / month</div>
                                </a>

                                <div class="mt-3 inline-block px-2 py-1 rounded text-xs bg-red-100 text-red-800">Rejected</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    </div>

    {{-- ===== Carousel script (same pattern as dashboard) ===== --}}
    <script>
        const carouselState = {};

        function appStateKey(view, id) {
            return `${view}-${id}`;
        }

        function updateAppCarousel(view, id) {
            const key = appStateKey(view, id);
            const track = document.getElementById(`track-${view}-${id}`);
            if (!track) return;

            const state = carouselState[key] || { index: 0, count: track.children.length };
            const translate = -state.index * 100;
            track.style.transform = `translateX(${translate}%)`;

            Array.from(track.children).forEach(child => child.style.width = "100%");
        }

        function nextImage(view, id) {
            const key = appStateKey(view, id);
            const container = document.querySelector(`[data-key="${view}-${id}"]`);
            const count = parseInt(container?.dataset.count || '0', 10);
            if (!carouselState[key]) carouselState[key] = { index: 0, count };
            if (count <= 1) return;
            carouselState[key].index = (carouselState[key].index + 1) % count;
            updateAppCarousel(view, id);
        }

        function prevImage(view, id) {
            const key = appStateKey(view, id);
            const container = document.querySelector(`[data-key="${view}-${id}"]`);
            const count = parseInt(container?.dataset.count || '0', 10);
            if (!carouselState[key]) carouselState[key] = { index: 0, count };
            if (count <= 1) return;
            carouselState[key].index = carouselState[key].index === 0 ? count - 1 : carouselState[key].index - 1;
            updateAppCarousel(view, id);
        }

        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll("[data-carousel]").forEach(carousel => {
                const key = carousel.dataset.key;
                const count = parseInt(carousel.dataset.count || '0', 10);
                carouselState[key] = { index: 0, count };
                const [view, id] = key.split("-").slice(0,2).join("-"); // not used, we call update per id below
            });

            // initialize all tracks currently in DOM
            document.querySelectorAll('[id^="track-"]').forEach(track => {
                const id = track.id.replace('track-','');
                const [view, listingId] = id.split('-').slice(0,2);
                updateAppCarousel(view, listingId);
            });
        });
    </script>
</x-app-layout>