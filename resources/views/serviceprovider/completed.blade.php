<x-app-layout>
    <x-slot name="header">
        <div class="border-b border-slate-200 px-6 py-3 bg-white">
            <p class="text-lg font-bold uppercase tracking-[0.12em] text-blue-600">
                Completed Jobs
            </p>
        </div>
    </x-slot>

    <div class="pb-20 lg:pl-70">
        <div class="max-w-4xl mx-auto space-y-4">

            @forelse($completedJobs as $providerRequest)
                @php
                    $job = $providerRequest->serviceRequest;
                @endphp

                <div class="bg-white shadow-sm rounded-xl border border-slate-200 px-5 py-4">

                    <!-- Title + Status -->
                    <div class="flex items-center gap-2 mb-2">
                        <h3 class="text-base font-semibold text-slate-900">
                            {{ $job->servicetype ?? 'Service Job' }}
                        </h3>

                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                            Completed
                        </span>
                    </div>

                    <!-- Address -->
                    <p class="text-sm text-slate-700 mb-2">
                        {{ $job->address_housenumber }} {{ $job->address_street }},
                        {{ $job->address_county }} {{ $job->address_postcode }}
                    </p>

                    <!-- Dates -->
                    <div class="text-sm text-slate-500 space-y-1">

                        <p>
                            <span class="font-semibold text-slate-700">Posted:</span>
                            {{ optional($job->created_at)->format('d M Y H:i') }}
                        </p>

                        <p>
                            <span class="font-semibold text-slate-700">Completed:</span>
                            {{ \Carbon\Carbon::parse($providerRequest->responded_at)->format('d M Y H:i') }}
                        </p>

                    </div>

                </div>

            @empty
                <div class="bg-white shadow-sm rounded-xl border border-slate-200 px-5 py-4">
                    <p class="text-slate-500 text-sm">
                        No completed jobs yet.
                    </p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>


                