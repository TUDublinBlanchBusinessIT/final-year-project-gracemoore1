@php
    $images = json_decode($rental->images ?? '[]', true) ?? [];
    $imgCount = count($images);
@endphp

<div class="min-w-[420px] bg-white rounded-xl border
    {{ $rental->is_premium ? 'border-yellow-400 ring-1 ring-yellow-300' : 'border-slate-200' }}
    shadow-sm p-4 hover:shadow-md transition">

    @if ($rental->is_premium)
        <div class="mb-2 text-xs font-bold text-yellow-700 uppercase tracking-wide">
            Premium
        </div>
    @endif

    {{-- IMAGE CAROUSEL --}}
    <div class="relative" data-carousel
         data-key="{{ $trackPrefix }}-{{ $rental->id }}"
         data-count="{{ $imgCount }}">

        <div class="overflow-hidden rounded-lg">
            <div id="track-{{ $trackPrefix }}-{{ $rental->id }}"
                 class="flex transition-transform duration-300 ease-out">
                @forelse ($images as $img)
                    <div class="w-full shrink-0">
                        <img src="{{ asset('storage/' . $img) }}"
                             class="w-full h-48 object-cover rounded-lg" />
                    </div>
                @empty
                    <div class="w-full h-48 bg-slate-100 flex items-center justify-center text-slate-500">
                        No image
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- DETAILS --}}
    <a href="{{ route('listing.show', $rental->id) }}" class="block mt-3">
        <div class="font-semibold text-slate-900">
            {{ $rental->housenumber ? $rental->housenumber . ' ' : '' }}
            {{ $rental->street }}, {{ $rental->county }}
        </div>

        <p class="text-sm text-slate-600">
            {{ [
                'any' => 'Any',
                'single_private' => 'Single room in private home',
                'private_shared' => 'Private room in shared house',
                'whole_property_group' => 'Whole property (group application only)',
            ][trim($rental->housetype ?? '')] ?? trim($rental->housetype ?? '') }}
        </p>

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
    </a>
</div>