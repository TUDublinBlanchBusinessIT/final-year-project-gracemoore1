<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-base text-gray-800 leading-tight">
            Messages
        </h2>
    </x-slot>

    <div class="mb-4">
        <a href="{{ route('landlord.messages') }}" 
        class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1">
            ← Back to Messages
        </a>
    </div>

<div class="pb-28 lg:pl-70">
    <div class="max-w-4xl mx-auto">

    

    <div class="pb-28 lg:pl-70">
        <div class="max-w-4xl mx-auto">
            <div class="bg-slate-50 px-6 py-6 h-[500px] overflow-y-auto space-y-4">

                @php
                    $lastDate = null;
                @endphp

                @forelse($messages as $message)
                    @php
                        $messageDate = \Carbon\Carbon::parse($message->created_at)->format('d M Y');
                        $isLandlordMessage = $message->sender_type === 'landlord';
                    @endphp

                    @if($lastDate !== $messageDate)
                        <div class="flex justify-center my-4">
                            <span class="px-4 py-1 rounded-full bg-slate-200 text-slate-600 text-xs">
                                {{ $messageDate }}
                            </span>
                        </div>
                        @php
                            $lastDate = $messageDate;
                        @endphp
                    @endif

                    <div class="flex {{ $isLandlordMessage ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[75%]">

                            <div class="px-4 py-3 rounded-2xl text-sm shadow-sm
                                {{ $isLandlordMessage ? 'bg-blue-600 text-white rounded-br-md' : 'bg-white text-slate-800 border border-slate-200 rounded-bl-md' }}">
                                {{ $message->content }}
                            </div>

                            <div class="mt-1 text-[11px] text-slate-400 {{ $isLandlordMessage ? 'text-right' : 'text-left' }}">
                                {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}

                                @if($isLandlordMessage)
                                    <span class="ml-1">
                                        {{ $message->is_read_by_student ? 'Seen' : 'Sent' }}
                                    </span>
                                @endif
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="flex justify-center items-center h-full">
                        <p class="text-sm text-slate-500">No messages yet. Start the conversation below.</p>
                    </div>
                @endforelse

            </div>

                {{-- Message input area --}}
                <div class="border-t border-slate-200 bg-white px-6 py-4">
                    <form action="{{ route('landlord.messages.store', $application->id) }}" method="POST" class="flex items-end gap-3">
                        @csrf

                        <div class="flex-1">
                            <textarea
                                name="message"
                                rows="2"
                                class="w-full resize-none rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-400 focus:ring focus:ring-blue-100"
                                placeholder="Type your message here..."
                                required></textarea>
                        </div>

                        <button
                            type="submit"
                            class="rounded-2xl bg-blue-600 px-5 py-3 text-sm font-medium text-white hover:bg-blue-700">
                            Send
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>