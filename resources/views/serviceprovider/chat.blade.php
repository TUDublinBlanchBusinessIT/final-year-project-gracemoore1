<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-base text-gray-800 leading-tight">
            Messages
        </h2>
    </x-slot>

    @php
        $job = $conversation->serviceRequest;
    @endphp

    <div class="pb-28 lg:pl-70">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

                <div class="border-b border-slate-200 px-8 py-5 bg-white">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('serviceprovider.messages') }}"
                           class="text-slate-500 hover:text-slate-700 text-xl">
                            ←
                        </a>

                        <div class="h-14 w-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 text-2xl font-semibold">
                            L
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-slate-900">
                                Landlord Chat
                            </h3>
                            <p class="text-slate-500 text-base">
                                {{ $job->servicetype }} ·
                                {{ $job->address_housenumber }} {{ $job->address_street }},
                                {{ $job->address_county }} {{ $job->address_postcode }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6 bg-slate-50 min-h-[420px]">
                    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5">
                        <h4 class="text-sm font-semibold text-slate-900 mb-2">Job Details</h4>
                        <p class="text-slate-700">{{ $job->description }}</p>

                        @if(!empty($job->requestimage))
                            <div class="mt-4">
                                <a href="{{ asset('storage/' . $job->requestimage) }}" target="_blank">
                                    <img
                                        src="{{ asset('storage/' . $job->requestimage) }}"
                                        alt="Request image"
                                        class="w-40 h-40 object-cover rounded-xl border border-slate-200 shadow-sm cursor-pointer"
                                    >
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-center text-slate-500">
                        Chat messages will appear here next.
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>