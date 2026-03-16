<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-base text-gray-800 leading-tight">
            Message Student
        </h2>
    </x-slot>

    <div class="pb-28 lg:pl-70">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 text-gray-900">

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg border border-green-300 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <h1 class="text-base font-semibold text-slate-700 mb-6">
                    Conversation with
                    <span class="font-bold text-slate-900">
                        {{ $application->student->firstname ?? 'Student' }} {{ $application->student->surname ?? '' }}
                    </span>
                    about
                    <span class="font-bold text-slate-900">
                        {{ $application->rental->housenumber ?? '' }}
                        {{ $application->rental->street ?? '' }},
                        {{ $application->rental->county ?? '' }}
                    </span>
                </h1>

                <div class="border rounded-xl p-4 bg-slate-50 space-y-3 mb-6 max-h-[400px] overflow-y-auto">
                    @forelse($messages as $message)
                        <div class="{{ $message->landlordid ? 'text-right' : 'text-left' }}">
                            <div class="inline-block px-4 py-2 rounded-xl text-sm {{ $message->landlordid ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                                {{ $message->content }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ \Carbon\Carbon::parse($message->created_at)->format('d M Y H:i') }}
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No messages yet. Start the conversation below.</p>
                    @endforelse
                </div>

                <form action="{{ route('landlord.messages.store', $application->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <textarea
                            name="message"
                            rows="4"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring focus:ring-blue-200"
                            placeholder="Type your message to the student here..."
                            required></textarea>
                    </div>

                    <button
                        type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm hover:bg-blue-700">
                        Send Message
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>