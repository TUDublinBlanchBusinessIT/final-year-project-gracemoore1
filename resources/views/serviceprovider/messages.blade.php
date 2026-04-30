<x-app-layout>
    <x-slot name="header">
        <div class="border-b border-slate-200 px-6 py-3 bg-white">
            <p class="text-lg font-bold uppercase tracking-[0.12em] text-blue-600">
                Messages
            </p>
        </div>
    </x-slot>

    <div class="pb-28 lg:pl-70">
        <div class="max-w-5xl mx-auto">

            <div class="mb-6">
                <p class="text-black mt-2">Manage conversations with landlords</p>
            </div>

            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 p-6">
                @if($conversations->count() == 0)
                    <div class="text-center py-10 text-slate-500">
                        <p class="text-lg font-medium">No messages yet</p>
                        <p class="text-sm text-slate-400 mt-2">
                            When you message a landlord about a job, it will appear here.
                        </p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($conversations as $conversation)

                            @php
                                $lastMessage = $conversation->sortByDesc('created_at')->first();

                                $unreadCount = $conversation
                                    ->where('sender_type', '!=', 'service_provider')
                                    ->where('is_read_by_service_provider', false)
                                    ->count();

                                $job = \App\Models\ServiceRequest::where('rentalid', $lastMessage->rentalid)
                                    ->where('landlordid', $lastMessage->landlordid)
                                    ->latest()
                                    ->first();
                            @endphp

                            @if($job)
                                <a href="{{ route('serviceprovider.messages.show', $lastMessage->serviceproviderpartnershipid) }}"
                                   class="block rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-blue-200 hover:shadow-md">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="min-w-0 flex-1">
                                            <h3 class="text-base font-semibold text-black truncate">
                                                {{ $job->servicetype }}
                                            </h3>

                                            <p class="mt-1 text-sm text-slate-500">
                                                {{ $job->address_housenumber ?? '' }}
                                                {{ $job->address_street ?? '' }},
                                                {{ $job->address_county ?? '' }}
                                                {{ $job->address_postcode ?? '' }}
                                            </p>

                                            <p class="mt-3 text-sm text-slate-700 truncate">
                                                {{ \Illuminate\Support\Str::limit($lastMessage->content, 90) }}
                                            </p>
                                        </div>

                                        <div class="ml-4 flex flex-col items-end gap-2 shrink-0">
                                            <div class="text-xs text-slate-400 whitespace-nowrap">
                                                {{ $lastMessage && $lastMessage->created_at ? $lastMessage->created_at->format('d M Y H:i') : '' }}
                                            </div>

                                            @if($unreadCount > 0)
                                                <span class="inline-flex items-center justify-center min-w-[22px] h-[22px] rounded-full bg-red-500 px-2 text-xs font-semibold text-white">
                                                    {{ $unreadCount }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endif

                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>