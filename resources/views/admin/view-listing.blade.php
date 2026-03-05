<x-admin.accounts>

<div class="p-6 max-w-4xl mx-auto bg-white rounded-xl shadow">

    <h2 class="text-2xl font-bold text-gray-900 mb-4">Listing Details</h2>

    @php
        // images stored as JSON array of relative paths like "rentals/abc.jpg"
        $images   = json_decode($rental->images ?? '[]', true) ?? [];
        $imgCount = count($images);
    @endphp

    {{-- ===================== --}}
    {{-- LARGE CAROUSEL HEADER --}}
    {{-- ===================== --}}
    <div class="relative mb-3" data-carousel data-key="detail-{{ $rental->id }}" data-count="{{ $imgCount }}">
        <div class="overflow-hidden rounded-lg">
            <div id="track-detail-{{ $rental->id }}" class="flex transition-transform duration-300 ease-out">
                @forelse ($images as $img)
                    <div class="w-full shrink-0">
                        <img
                            src="{{ asset('storage/' . ltrim($img, '/')) }}"
                            alt="Listing image"
                            class="w-full h-64 object-cover rounded-lg" />
                    </div>
                @empty
                    <div class="w-full h-64 bg-slate-200 rounded-lg flex items-center justify-center text-slate-500">
                        No Image
                    </div>
                @endforelse
            </div>
        </div>

        @if ($imgCount > 1)
            <button
                onclick="prevImage('detail', {{ $rental->id }})"
                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-3 py-1 rounded-full shadow"
                aria-label="Previous image">‹</button>

            <button
                onclick="nextImage('detail', {{ $rental->id }})"
                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-3 py-1 rounded-full shadow"
                aria-label="Next image">›</button>
        @endif
    </div>

    {{-- LISTING ID pill (styled like a badge) just under the images --}}
    <div class="mb-6">
            <span class="inline-flex items-center gap-1 rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600">
            Listing ID: {{ $rental->id }}
        </span>
    </div>

    {{-- =================== --}}
    {{-- LISTING INFORMATION --}}
    {{-- =================== --}}
    <div class="space-y-3 text-gray-800">

        <p class="text-xl font-semibold">
            {{ $rental->housenumber }} {{ $rental->street }}, {{ $rental->county }}
        </p>

        @if ($rental->housetype)
            <p><strong>House Type:</strong> {{ $rental->housetype }}</p>
        @endif

        @if ($rental->nightsperweek)
            <p><strong>Nights Per Week:</strong> {{ $rental->nightsperweek }}</p>
        @endif

        <p><strong>Rent Per Month:</strong> €{{ number_format($rental->rentpermonth, 2) }}</p>

        <p><strong>Available From:</strong> {{ $rental->availablefrom }}</p>
        <p><strong>Available Until:</strong> {{ $rental->availableuntil }}</p>

        <p><strong>Description:</strong></p>
        <p class="whitespace-pre-line">{{ $rental->description }}</p>

        {{-- Centered, subtle back link UNDER the description --}}
        <div class="pt-4 text-center">
            <a href="{{ route('admin.accounts.landlords') }}" class="text-slate-500 hover:text-slate-700 text-sm">
                &lt; Back to Landlords
            </a>
        </div>
    </div>

</div>

{{-- =================== --}}
{{-- CAROUSEL SCRIPT     --}}
{{-- =================== --}}
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

        carouselState[key].index =
            carouselState[key].index === 0 ? count - 1 : carouselState[key].index - 1;

        updateCarousel(view, id);
    }

    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll("[data-carousel]").forEach(carousel => {
            const key = carousel.dataset.key;
            const [view, id] = key.split("-");
            carouselState[key] = { index: 0, count: carousel.dataset.count ?? 0 };
            updateCarousel(view, id);
        });
    });
</script>

</x-admin.accounts>