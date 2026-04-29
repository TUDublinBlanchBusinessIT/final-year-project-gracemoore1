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
                        <a href="{{ route('student.messages') }}" class="text-slate-500 hover:text-slate-700 text-xl">
                            ←
                        </a>

                        <div class="w-11 h-11 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 text-lg font-semibold">
                            {{ strtoupper(substr($application->rental->landlord->firstname ?? 'L', 0, 1)) }}
                        </div>

                        <div>
                            <div class="relative inline-block">
                                <div class="group">

                                    <h3 class="text-lg font-semibold text-slate-900 cursor-pointer">
                                        {{ $application->rental->landlord->firstname ?? 'Landlord' }}
                                        {{ $application->rental->landlord->surname ?? '' }}
                                    </h3>

                                    <div
                                        class="absolute left-0 top-full mt-1 w-44
                                            bg-white border border-slate-200 rounded-lg shadow-lg
                                            opacity-0 invisible group-hover:opacity-100 group-hover:visible
                                            transition-all duration-150 z-50">

                                        <a
                                            href="{{ route('complaint.create', [
                                                'reported_user_id' => $application->rental->landlord->id,
                                                'reported_user_role' => 'landlord'
                                            ]) }}"
                                            class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-lg"
                                        >
                                            Report account
                                        </a>

                                    </div>
                                </div>
                            </div>


                            <p class="text-sm text-slate-500">
                                {{ $application->rental->housenumber ?? '' }}
                                {{ $application->rental->street ?? '' }},
                                {{ $application->rental->county ?? '' }}
                            </p>

                            @if($application->applicationtype === 'group' && $groupMembers->count())
                                <p class="text-xs text-slate-400 mt-1">
                                    Group members:
                                    {{ $groupMembers->pluck('firstname')->implode(', ') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    {{-- RIGHT SIDE – RENT TRACKER BUTTON --}}
                
                    @if($application->status === 'accepted')
                        <div class="flex items-center gap-3">
                        <a href="{{ route('student.rent.page', ['application' => $application->id]) }}{{ $application->group_id ? ('?group_id=' . $application->group_id) : '' }}"
                            class="ml-auto h-9 w-9 flex items-center justify-center rounded-full hover:bg-gray-100"
                            title="Rent Tracker">
                            <span class="text-emerald-600 text-xl font-semibold">€</span>
                        </a>

                        <a href="{{ route('student.maintenance-log', $application->id) }}"
                            class="ml-3 h-9 w-9 flex items-center justify-center rounded-full hover:bg-gray-100"
                            title="Maintenance Log">
                            <span class="text-slate-600 text-xl">🛠</span>
                        </a>

                    @endif
                    
                </div>

                
                @if($isOtherAccountBanned)
                    <div class="mx-6 mt-4 mb-2 rounded-xl border border-red-300 bg-red-50 px-4 py-3 text-red-800">
                        <strong>Notice:</strong>
                        This landlord account has been suspended.
                    </div>
                @endif


                <div id="chatContainer" class="bg-slate-50 px-6 py-6 h-[500px] overflow-y-auto space-y-4">

                    @php
                        $lastDate = null;
                    @endphp

                    @forelse($messages as $message)
                        @php
                            $messageDate = \Carbon\Carbon::parse($message->created_at)->format('d M Y');
                            $loggedInStudentId = session('student_id');
                            $isOwnMessage = $message->sender_type === 'student' && $message->studentid == $loggedInStudentId;
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
                        <div class="flex {{ $isOwnMessage ? 'justify-end' : 'justify-start' }}">
                        
                            <div class="max-w-[75%]">
                                @if($application->applicationtype === 'group')

                                    @if($message->sender_type === 'student')
                                        <p class="text-xs text-black font-medium mb-1 {{ $isOwnMessage ? 'text-right' : 'text-left' }}">
                                            {{ \App\Models\Student::find($message->studentid)->firstname ?? 'Student' }}
                                        </p>
                                    @else
                                        <p class="text-xs text-black font-medium mb-1 text-left">
                                            {{ $application->rental->landlord->firstname ?? 'Landlord' }}
                                        </p>
                                    @endif

                                @endif
                            
                                <div class="px-4 py-3 rounded-2xl text-sm shadow-sm
                                    {{ $isOwnMessage ? 'bg-blue-600 text-white rounded-br-md' : 'bg-white text-slate-800 border border-slate-200 rounded-bl-md' }}">
                                    {{ $message->content }}
                                </div>

                                <div class="mt-1 text-[11px] text-slate-400 {{ $isOwnMessage ? 'text-right' : 'text-left' }}">
                                    {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}

                                    @if($isOwnMessage)
                                        <span class="ml-1">
                                            {{ $message->is_read_by_landlord ? 'Seen' : 'Sent' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    @empty
                        <div class="flex justify-center items-center h-full">
                            <p class="text-sm text-slate-500">No messages yet.</p>
                        </div>
                    @endforelse

                </div>

                <div class="border-t border-slate-200 bg-white px-6 py-4">
                    <form action="{{ route('student.messages.store', $application->id) }}" method="POST" class="flex items-end gap-3">
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
        window.addEventListener('load', function () {
            const chatBox = document.getElementById('chatBox');
            if (chatBox) {
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const chat = document.getElementById("chatContainer");
        if (chat) {
            chat.scrollTop = chat.scrollHeight;
        }
    });
    </script>
</x-app-layout>