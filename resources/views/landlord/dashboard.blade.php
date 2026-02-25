<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    {{-- IMPORTANT: This wrapper makes the dashboard respect the landlord sidebar (lg) and bottom nav (mobile) --}}
    <div class="pb-28 lg:pl-60">


        <div>

                {{-- Welcome card --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8 text-gray-900">

                        <h1 class="text-3xl font-bold text-blue-600 mb-4">
                            Welcome back, {{ Auth::user()->name }}!
                        </h1>

                        <p class="text-gray-700 text-lg">
                            This is your dashboard.
                            You can manage your account, update your profile, and access new features as they’re added.
                        </p>

                    </div>
                </div>
        </div>

                {{-- YOUR LISTINGS SECTION --}}
                @php
                    $landlordId = \App\Models\Landlord::where('email', Auth::user()->email)->value('id');
                    $rentals = $landlordId
                        ? \App\Models\LandlordRental::where('landlordid', $landlordId)->latest('id')->get()
                        : collect();
                @endphp

                <div class="mt-10">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-slate-900">Your Listings</h2>

                        <a href="{{ route('landlord.rentals.create') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                            + Add Listing
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($rentals as $rental)
                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition">
                                <div class="flex items-start justify-between gap-4">

                                    <div class="min-w-0">
                                        <div class="text-sm text-slate-500">Location</div>

                                        <div class="font-semibold text-slate-900 truncate">
                                            {{ $rental->housenumber ? $rental->housenumber . ' ' : '' }}
                                            {{ $rental->street }}, {{ $rental->county }}
                                        </div>

                                        <div class="mt-2 text-sm text-slate-600">
                                            €{{ number_format($rental->rentpermonth ?? 0, 2) }} / month

                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs border
                                                {{ $rental->status === 'available'
                                                    ? 'bg-green-50 text-green-700 border-green-200'
                                                    : 'bg-slate-100 text-slate-700 border-slate-200' }}">
                                                {{ ucfirst($rental->status ?? 'unknown') }}
                                            </span>
                                        </div>

                                        <div class="mt-2 text-xs text-slate-500">
                                            Available: {{ $rental->availablefrom }} → {{ $rental->availableuntil }}
                                        </div>
                                    </div>

                                    <div class="flex gap-2 shrink-0">
                                        <a href="{{ route('landlord.rentals.edit', $rental) }}"
                                           class="px-3 py-2 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('landlord.rentals.destroy', $rental) }}"
                                              onsubmit="return confirm('Delete this listing?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="px-3 py-2 rounded-xl bg-red-50 text-red-600 font-semibold hover:bg-red-100 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>

                                </div>

                                <p class="mt-3 text-sm text-slate-600 line-clamp-2">
                                    {{ $rental->description }}
                                </p>
                            </div>

                        @empty
                            <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-10 text-center md:col-span-2">
                                <div class="text-slate-700 font-semibold text-lg">No listings yet</div>
                                <div class="text-slate-500 text-sm mt-1">
                                    Add your first listing to get started.
                                </div>

                                <a href="{{ route('landlord.rentals.create') }}"
                                   class="inline-flex items-center justify-center mt-5 w-14 h-14 rounded-full bg-blue-600 text-white text-3xl font-bold hover:bg-blue-700 transition">
                                    +
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>

</x-app-layout>
