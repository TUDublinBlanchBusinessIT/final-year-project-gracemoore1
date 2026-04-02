<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-base text-gray-800 leading-tight">
            Requested Jobs
        </h2>
    </x-slot>

    <div class="pb-28 lg:pl-70">
        <div class="max-w-5xl mx-auto">
            @if(session('success'))
                <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if($requestedJobs->isEmpty())
                <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 p-10 text-center">
                    <h3 class="text-3xl font-semibold text-blue-600 mb-3">Requested Jobs</h3>
                    <p class="text-gray-600">There are no matching requested jobs for you right now.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($requestedJobs as $providerRequest)
                        @php
                            $job = $providerRequest->serviceRequest;
                        @endphp

                        <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 p-6">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                                <div>
                                    <h3 class="text-xl font-semibold text-slate-800">
                                        {{ $job->servicetype }}
                                    </h3>
                                    <p class="text-sm text-slate-500 mt-1">
                                        {{ $job->address_housenumber }} {{ $job->address_street }}, {{ $job->address_county }} {{ $job->address_postcode }}
                                    </p>
                                    <p class="text-sm text-slate-500 mt-1">
                                        Status: <span class="font-medium">{{ ucfirst($providerRequest->status) }}</span>
                                    </p>
                                </div>

                                @if(!empty($job->requestimage))
                                    <a href="{{ asset('storage/' . $job->requestimage) }}" target="_blank">
                                        <img
                                            src="{{ asset('storage/' . $job->requestimage) }}"
                                            alt="Request image"
                                            class="w-40 h-40 object-cover rounded-xl border border-slate-200 shadow-sm cursor-pointer hover:scale-105 transition"
                                            onerror="this.style.display='none';"
                                        >
                                    </a>
                                @endif
                                
                            </div>

                            <div class="mt-4">
                                <p class="text-slate-700 whitespace-pre-line">{{ $job->description }}</p>
                            </div>

                            <div class="mt-5 flex flex-wrap gap-3">
                                @if(in_array($providerRequest->status, ['pending', 'messaged']))
                                    <a href="{{ route('serviceprovider.messages') }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                                        Message Landlord
                                    </a>
                                @endif

                                @if($providerRequest->status === 'assigned')
                                    <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-xl font-medium border border-green-200">
                                        Assigned by Landlord
                                    </span>

                                    <a href="{{ route('serviceprovider.messages') }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                                        Open Chat
                                    </a>
                                @endif

                                @if(in_array($providerRequest->status, ['declined', 'closed']))
                                    <span class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-500 rounded-xl font-medium border border-slate-200">
                                        No Longer Available
                                    </span>
                                @endif
                            
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>