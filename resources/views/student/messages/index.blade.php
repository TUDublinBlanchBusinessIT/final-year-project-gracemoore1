<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 leading-tight">
                Messages
            </h2>
            <p class="mt-1 text-sm text-blue-600">
                Manage conversations with landlords
            </p>
        </div>
    </x-slot>

    <div class="pb-28 lg:pl-70">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 text-gray-900">

                @if($applications->count() == 0)
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-6 text-sm text-slate-600">
                        No messages yet.
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($applications as $application)

                            @php
                                $lastMessage = \App\Models\Message::where('studentid', $application->studentid)
                                    ->where('rentalid', $application->rentalid)
                                    ->latest('created_at')
                                    ->first();

                                $unreadCount = \App\Models\Message::where('studentid', $application->studentid)
                                    ->where('rentalid', $application->rentalid)
                                    ->where('sender_type', 'landlord')
                                    ->where('is_read_by_student', false)
                                    ->count();
                            @endphp

                            <a href="{{ route('student.messages.show', $application->id) }}"
                               class="block rounded-xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="text-base font-semibold text-slate-900">
                                            {{ $application->rental->landlord->firstname ?? 'Landlord' }}
                                            {{ $application->rental->landlord->surname ?? '' }}
                                        </h3>

                                        <p class="mt-1 text-sm text-slate-500">
                                            {{ $application->rental->housenumber ?? '' }}
                                            {{ $application->rental->street ?? '' }},
                                            {{ $application->rental->county ?? '' }}
                                        </p>

                                        <p class="mt-2 text-sm text-slate-700">
                                            {{ $lastMessage ? \Illuminate\Support\Str::limit($lastMessage->content, 80) : 'No messages yet.' }}
                                        </p>
                                    </div>

                                    <div class="ml-4 flex flex-col items-end gap-2">
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

                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>