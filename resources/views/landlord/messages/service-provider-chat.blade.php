<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-base text-gray-800 leading-tight">
            Messages
        </h2>
    </x-slot>

    @php
        $providerName = $provider
            ? trim(($provider->firstname ?? '') . ' ' . ($provider->surname ?? ''))
            : 'Service Provider';
    @endphp

    <div class="pb-28 lg:pl-70">
        <div class="max-w-5xl mx-auto">

            @if(session('success'))
                <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                    {{ $errors->first('message') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

                <div class="border-b border-slate-200 px-8 py-5 bg-white">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('landlord.messages', ['filter' => 'service_providers']) }}"
                           class="text-slate-500 hover:text-slate-700 text-xl">
                            ←
                        </a>

                        <div class="h-14 w-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 text-2xl font-semibold">
                            {{ strtoupper(substr($providerName, 0, 1)) }}
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-slate-900">
                                {{ $providerName }}
                            </h3>
                            <p class="text-slate-500 text-base">
                                {{ $job->servicetype ?? 'Service Request' }} ·
                                {{ $rental->housenumber ?? '' }} {{ $rental->street ?? '' }},
                                {{ $rental->county ?? '' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div id="chatContainer" class="px-8 py-6 bg-slate-50 min-h-[420px] max-h-[520px] overflow-y-auto">

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

                    @forelse($messages as $message)
                        <div class="mb-4 flex {{ $message->sender_type === 'landlord' ? 'justify-end' : 'justify-start' }}">
                            <div class="{{ $message->sender_type === 'landlord' ? 'bg-blue-600 text-white' : 'bg-white border border-slate-200 text-slate-800' }} max-w-xl rounded-3xl px-5 py-3 shadow-sm">
                                <p class="text-sm leading-6">{{ $message->content }}</p>
                                <p class="mt-2 text-xs {{ $message->sender_type === 'landlord' ? 'text-blue-100' : 'text-slate-400' }}">
                                    {{ optional($message->timestamp)->format('d M Y H:i') ?? optional($message->created_at)->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-center text-slate-500">
                            No messages yet.
                        </div>
                    @endforelse

                </div>

                <div class="border-t border-slate-200 bg-white px-8 py-5">
                    <form method="POST" action="{{ route('landlord.service-provider.messages.store', $providerRequest->id) }}">
                        @csrf

                        <div class="flex items-end gap-4">
                            <div class="flex-1">
                                <textarea
                                    name="message"
                                    rows="3"
                                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Type your message here..."
                                    required
                                >{{ old('message') }}</textarea>
                            </div>

                            <div>
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-medium text-white hover:bg-blue-700 transition">
                                    Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const container = document.getElementById("chatContainer");
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });
    </script>
</x-app-layout>