<x-app-layout>
    <x-slot name="header">
        <div class="border-b border-slate-200 px-6 py-3 bg-white">
            <div class="flex items-center gap-4">
                <p class="text-m font-semibold uppercase tracking-[0.12em] text-blue-600">
                    Completed Jobs
                </p>
            </div>
        </div>
    </x-slot>

    <div class="pb-20 lg:pl-70">
        <div class="max-w-5xl mx-auto">
            @forelse($providerRequests as $providerRequest)
                <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden mb-6">
                    <div class="p-8">
                        <div class="flex flex-wrap items-center gap-3 mb-3">
                            <h3 class="text-2xl font-semibold text-slate-900">
                                {{ $providerRequest->servicetype ?? 'Service Job' }}
                            </h3>

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
                                Completed
                            </span>

                            @if(!empty($providerRequest->urgent))
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-600">
                                    Urgent
                                </span>
                            @endif
                        </div>

                        <p class="text-slate-600 text-lg">
                            {{ $providerRequest->housenumber ?? '' }}
                            {{ $providerRequest->street ?? '' }},
                            {{ $providerRequest->county ?? '' }}
                            {{ $providerRequest->postcode ?? '' }}
                        </p>

                        @if(!empty($providerRequest->accepted_at))
                            <p class="text-slate-600 text-lg mt-1">
                                Accepted on
                            </p>
                            <p class="text-slate-400 text-lg">
                                {{ \Carbon\Carbon::parse($providerRequest->accepted_at)->format('d M Y H:i') }}
                            </p>
                        @endif

                        @if(!empty($providerRequest->completed_at))
                            <p class="text-slate-600 text-lg mt-1">
                                Completed on
                            </p>
                            <p class="text-slate-400 text-lg">
                                {{ \Carbon\Carbon::parse($providerRequest->completed_at)->format('d M Y H:i') }}
                            </p>
                        @endif

                        @if(!empty($providerRequest->description))
                            <p class="text-slate-800 text-2xl mt-6">
                                {{ $providerRequest->description }}
                            </p>
                        @endif

                        <div class="mt-5 flex flex-wrap gap-3">
                            <a href="{{ route('serviceprovider.messages.show', $providerRequest->id) }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                                Open Chat
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="p-8">
                        <p class="text-slate-500 text-lg">
                            No completed jobs yet.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>