<x-app-layout>
    <x-slot name="header">
        <div class="border-b border-slate-200 px-6 py-3 bg-white">
            <p class="text-lg font-bold uppercase tracking-[0.12em] text-blue-600">
                Requested Jobs
            </p>
        </div>
    </x-slot>

    <div class="pb-28 lg:pl-70">
        <div class="max-w-5xl mx-auto">

            @if($requestedJobs->isEmpty())
                <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 p-10 text-center">
                    <h3 class="text-2xl font-semibold text-slate-800 mb-2">Requested Jobs</h3>
                    <p class="text-slate-500">No requested jobs available right now.</p>
                </div>
            @else
                <div class="space-y-5">
                    @foreach($requestedJobs as $providerRequest)
                        @php
                            $job = $providerRequest->serviceRequest;
                        @endphp

                        <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 p-6">
                            <div class="flex flex-col md:flex-row gap-6 md:items-start md:justify-between">

                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <h3 class="text-2xl font-semibold text-slate-900">
                                            {{ $job->servicetype }}
                                        </h3>

                                        @if(!empty($job->is_urgent) && $job->is_urgent == 1)
                                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-red-100 text-red-700 border border-red-200">
                                                Urgent · Needed today
                                            </span>
                                        @endif
                                    </div>

                                    <p class="mt-3 text-sm text-slate-500">
                                        {{ $job->address_housenumber ?? '' }}
                                        {{ $job->address_street ?? '' }},
                                        {{ $job->address_county ?? '' }}
                                        {{ $job->address_postcode ?? '' }}
                                    </p>

                                    <p class="mt-1 text-sm text-slate-400">
                                        Posted {{ optional($job->created_at)->format('d M Y H:i') }}
                                    </p>

                                    <div class="mt-4 rounded-xl bg-slate-50 border border-slate-200 p-4">
                                        <p class="text-slate-700 leading-7">
                                            {{ $job->description }}
                                        </p>
                                    </div>

                                    <div class="mt-5">
                                        <a href="{{ route('serviceprovider.messages.show', $providerRequest->id) }}"
                                           class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                                            Message Landlord
                                        </a>
                                    </div>
                                </div>

                                @if(!empty($job->requestimage))
                                    <div class="w-full md:w-44 shrink-0">
                                        <a href="{{ asset('storage/' . $job->requestimage) }}" target="_blank">
                                            <img
                                                src="{{ asset('storage/' . $job->requestimage) }}"
                                                alt="Request image"
                                                class="w-full h-44 object-cover rounded-2xl border border-slate-200 shadow-sm"
                                            >
                                        </a>
                                    </div>
                                @endif

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>