@php
    $hasUnreadMaintenance = \App\Models\Maintenancelog::where('applicationid', $application->id)
        ->where('is_seen_by_landlord', false)
        ->exists();
@endphphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-base text-gray-800 leading-tight">
            Messages
        </h2>
    </x-slot>

    <div class="pb-28 lg:pl-70">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

                <div class="border-b border-slate-200 px-6 py-4 bg-white">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('landlord.messages') }}" class="text-slate-500 hover:text-slate-700 text-xl">
                            ←
                        </a>

                        <div class="w-11 h-11 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 text-lg font-semibold">
                            {{ strtoupper(substr($application->student->firstname ?? 'S', 0, 1)) }}
                        </div>

                        
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">
                                {{ $application->student->firstname ?? 'Student' }} {{ $application->student->surname ?? '' }}
                            </h3>
                            <p class="text-sm text-slate-500">
                                {{ $application->rental->housenumber ?? '' }}
                                {{ $application->rental->street ?? '' }},
                                {{ $application->rental->county ?? '' }}
                            </p>

                            @if($application->applicationtype === 'group' && isset($groupMembers) && $groupMembers->count())
                                <p class="text-xs text-slate-400 mt-1">
                                    Group members:
                                    {{ $groupMembers->pluck('firstname')->implode(', ') }}
                                </p>
                            @endif
                        </div>  
                        {{-- RENT TRACKER BUTTON --}}
                        @if($application->status === 'accepted')
                            <a href="{{ route('landlord.rent.page', ['application' => $application->id]) }}{{ $application->group_id ? ('?group_id=' . $application->group_id) : '' }}"
                               class="ml-auto h-9 w-9 flex items-center justify-center rounded-full hover:bg-gray-100"
                               title="Rent Tracker">
                                <span class="text-emerald-600 text-xl font-semibold">€</span>
                            </a>

                            <a href="{{ route('landlord.maintenance-log', $application->id) }}"
                                class="relative ml-3 h-9 w-9 flex items-center justify-center rounded-full transition
                                        {{ $hasUnreadMaintenance ? 'bg-red-50 ring-2 ring-red-200 text-red-500' : 'hover:bg-gray-100 text-slate-600' }}"
                                title="Maintenance Log">
                                <span class="text-xl">🛠</span>

                                @if($hasUnreadMaintenance)
                                    <span class="absolute -top-1 -right-1 h-3 w-3 rounded-full bg-red-500 border-2 border-white"></span>
                                @endif
                            </a>
                        @endif               
                    </div>
                </div>

                
            <div id="chatContainer" class="bg-slate-50 px-6 py-6 h-[500px] overflow-y-auto space-y-4">

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

                    @if($message->sender_type === 'system')
                        <div class="flex justify-center my-4">
                            <div class="inline-block px-4 py-2 rounded-full bg-slate-100 border border-slate-200 text-sm text-slate-500 text-center">
                                {{ $message->content }}
                            </div>
                        </div>
                    @else

                    <div class="flex {{ $isLandlordMessage ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[75%]">

                            @if($application->applicationtype === 'group')

                                @if($message->sender_type === 'student')
                                    <p class="text-xs text-black font-medium mb-1 text-left">
                                        {{ \App\Models\Student::find($message->studentid)->firstname ?? 'Student' }}
                                    </p>
                                @else
                                    <p class="text-xs text-black font-medium mb-1 text-right">
                                        {{ $application->rental->landlord->firstname ?? 'Landlord' }}
                                    </p>
                                @endif

                            @endif

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
                    @endif                   
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

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const chat = document.getElementById("chatContainer");
        if (chat) {
            chat.scrollTop = chat.scrollHeight;
        }
    });
    </script>
</x-app-layout>