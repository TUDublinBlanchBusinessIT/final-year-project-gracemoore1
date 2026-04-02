<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-base text-gray-800 leading-tight">
            Messages
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

            <div class="mb-6">
                <h1 class="text-3xl font-semibold text-slate-900">Messages</h1>
                <p class="text-blue-500 mt-2">Manage conversations with landlords</p>
            </div>

            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 p-6">
                @if($conversations->isEmpty())
                    <div class="text-center py-10 text-slate-500">
                        <p class="text-lg font-medium">No conversations yet</p>
                        <p class="text-sm text-slate-400 mt-2">
                            When you message a landlord about a requested job, it will appear here.
                        </p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($conversations as $conversation)
                            @php
                                $job = $conversation->serviceRequest;
                            @endphp

                            <div class="border border-slate-200 rounded-2xl p-5 hover:bg-slate-50 transition">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        <h3 class="text-xl font-semibold text-slate-900">
                                            {{ $job->servicetype }}
                                        </h3>

                                        <p class="text-slate-500 mt-1">
                                            {{ $job->address_housenumber }} {{ $job->address_street }}, {{ $job->address_county }} {{ $job->address_postcode }}
                                        </p>

                                        <p class="text-slate-700 mt-3 line-clamp-2">
                                            {{ $job->description }}
                                        </p>

                                        <div class="mt-3">
                                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium
                                                @if($conversation->status === 'assigned') bg-green-100 text-green-700
                                                @elseif($conversation->status === 'messaged') bg-blue-100 text-blue-700
                                                @else bg-yellow-100 text-yellow-700
                                                @endif">
                                                {{ ucfirst($conversation->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="text-right shrink-0">
                                        <p class="text-sm text-slate-400">
                                            {{ optional($conversation->created_at)->format('d M Y H:i') }}
                                        </p>

                                        <a href="{{ route('serviceprovider.messages.show', $conversation->id) }}"
                                           class="inline-flex items-center mt-4 px-4 py-2 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                                            Open Chat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>