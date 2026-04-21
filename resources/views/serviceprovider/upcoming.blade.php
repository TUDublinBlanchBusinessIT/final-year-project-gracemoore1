<x-app-layout>
    <x-slot name="header">
        <div class="border-b border-slate-200 px-6 py-3 bg-white">
            <p class="text-lg font-bold uppercase tracking-[0.12em] text-blue-600">
                Upcoming Jobs
            </p>
        </div>
    </x-slot>

    <div class="pb-28 lg:pl-70">
        <div class="max-w-5xl mx-auto">

            @if(session('success'))
                <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if($upcomingJobs->isEmpty())
                <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 p-10 text-center">
                    <h3 class="text-3xl font-semibold text-blue-600 mb-3">Upcoming Jobs</h3>
                    <p class="text-gray-600">You do not have any upcoming jobs yet.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($upcomingJobs as $providerRequest)
                        @php
                            $job = $providerRequest->serviceRequest;
                        @endphp

                        <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 p-6">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                                <div>
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <h3 class="text-xl font-semibold text-slate-800">
                                            {{ $job->servicetype }}
                                        </h3>

                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-green-100 text-green-700">
                                            Assigned
                                        </span>

                                        @if(!empty($job->is_urgent) && $job->is_urgent == 1)
                                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium bg-red-100 text-red-700 border border-red-200">
                                                Urgent · Needed today
                                            </span>
                                        @endif
                                    </div>

                                    <p class="text-sm text-slate-500 mt-2">
                                        {{ $job->address_housenumber }} {{ $job->address_street }}, {{ $job->address_county }} {{ $job->address_postcode }}
                                    </p>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Accepted on {{ optional($providerRequest->responded_at)->format('d M Y H:i') }}
                                    </p>

                                    <p class="text-sm text-slate-400 mt-1">
                                        Posted {{ optional($job->created_at)->format('d M Y H:i') }}
                                    </p>
                                </div>

                                @if(!empty($job->requestimage))
                                    <a href="{{ asset('storage/' . $job->requestimage) }}" target="_blank">
                                        <img
                                            src="{{ asset('storage/' . $job->requestimage) }}"
                                            alt="Request image"
                                            class="w-32 h-32 object-cover rounded-xl border border-slate-200 shadow-sm cursor-pointer"
                                        >
                                    </a>
                                @endif
                            </div>

                            <div class="mt-4">
                                <p class="text-slate-700 whitespace-pre-line">{{ $job->description }}</p>
                            </div>

                            <div class="mt-5 flex flex-wrap gap-3">
                                <a href="{{ route('serviceprovider.messages.show', $providerRequest->id) }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                                    Open Chat
                                </a>

                                <form method="POST" action="{{ route('serviceprovider.upcoming.complete', $providerRequest->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-xl font-medium hover:bg-green-700 transition">
                                        Mark as Completed
                                    </button>
                                </form>
                            </div>                            
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>