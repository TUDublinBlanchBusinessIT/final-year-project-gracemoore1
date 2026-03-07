@php
    if (!$r) return;

    $images = json_decode($r->images ?? '[]', true) ?? [];
    $imgCount = count($images);

    $labelMap = [
        'any' => 'Any',
        'single_private' => 'Single room in private home',
        'private_shared' => 'Private room in shared house',
        'whole_property_group' => 'Whole property (group application only)',
    ];
@endphp

<div class="min-w-[390px] lg:min-w-0 bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">

    {{-- Carousel --}}
    <div class="relative" data-carousel data-key="{{ $badge }}-{{ $r->id }}-{{ uniqid() }}"
         data-count="{{ $imgCount }}">
        <div class="overflow-hidden rounded-lg">
            <div id="track-{{ $badge }}-{{ $r->id }}" class="flex transition-transform duration-300 ease-out">
                @forelse ($images as $img)
                    <div class="w-full shrink-0">
                        {{ asset('storage/' . $img) }}
                    </div>
                @empty
                    <div class="w-full h-40 lg:h-48 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500">
                        No image
                    </div>
                @endforelse
            </div>
        </div>

        @if ($imgCount > 1)
            <button onclick="prevImage('{{ $badge }}', {{ $r->id }})"
                    class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">
                ‹
            </button>

            <button onclick="nextImage('{{ $badge }}', {{ $r->id }})"
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">
                ›
            </button>
        @endif
    </div>

    {{-- CLICKABLE DETAILS --}}
    {{ route('listing.show', $r->id) }}" class="block mt-3">
        <div class="font-semibold text-slate-900">
            {{ $r->housenumber ? $r->housenumber . ' ' : '' }}
            {{ $r->street }}, {{ $r->county }}
        </div>

        <p class="text-sm text-slate-600">
            {{ $labelMap[$r->housetype] ?? $r->housetype }}
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

    {{-- STATUS BADGE --}}
    <div class="mt-3 inline-block px-2 py-1 rounded text-xs bg-{{ $color }}-100 text-{{ $color }}-800">
        {{ $badge }}
    </div>
</div>