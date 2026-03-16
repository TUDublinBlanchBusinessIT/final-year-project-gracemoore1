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
                            <h3 class="text-lg font-semibold text-slate-900">
                                {{ $application->rental->landlord->firstname ?? 'Landlord' }}
                                {{ $application->rental->landlord->surname ?? '' }}
                            </h3>
                            <p class="text-sm text-slate-500">
                                {{ $application->rental->housenumber ?? '' }}
                                {{ $application->rental->street ?? '' }},
                                {{ $application->rental->county ?? '' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 px-6 py-6 h-[500px] overflow-y-auto space-y-4" id="chatBox">

                    @php
                        $lastDate = null;
                    @endphp

                    @forelse($messages as $message)
                        @php
                            $messageDate = \Carbon\Carbon::parse($message->created_at)->format('d M Y');
                            $isStudentMessage = $message->sender_type === 'student';
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

                        <div class="flex {{ $isStudentMessage ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[75%]">
                                <div class="px-4 py-3 rounded-2xl text-sm shadow-sm
                                    {{ $isStudentMessage ? 'bg-blue-600 text-white rounded-br-md' : 'bg-white text-slate-800 border border-slate-200 rounded-bl-md' }}">
                                    {{ $message->content }}
                                </div>

                                <div class="mt-1 text-[11px] text-slate-400 {{ $isStudentMessage ? 'text-right' : 'text-left' }}">
                                    {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}
                                </div>
                            </div>
                        </div>
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
</x-app-layout>