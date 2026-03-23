<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 leading-tight">
                Messages
            </h2>
            <p class="mt-1 text-sm text-blue-600">
                Manage conversations with students
            </p>
        </div>
    </x-slot>

    <div class="pb-28 lg:pl-70">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 text-gray-900">

            <div class="p-6">

    
    <div class="mb-6 flex flex-wrap gap-3 items-center">

                    @php $active = request('filter', 'all'); @endphp

                    <a href="{{ request()->fullUrlWithQuery(['filter' => 'all']) }}"
                        class="px-4 py-2 text-sm font-medium rounded-full transition
                        {{ $active === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        All
                    </a>

                    <a href="{{ request()->fullUrlWithQuery(['filter' => 'unread']) }}"
                    class="px-4 py-2 text-sm font-medium rounded-full transition
                    {{ $active === 'unread' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Unread
                    </a>

                    <a href="{{ request()->fullUrlWithQuery(['filter' => 'group']) }}"
                    class="px-4 py-2 text-sm font-medium rounded-full transition
                    {{ $active === 'group' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Group chats
                    </a>

                    <a href="{{ request()->fullUrlWithQuery(['filter' => 'individual']) }}"
                    class="px-4 py-2 text-sm font-medium rounded-full transition
                    {{ $active === 'individual' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Individual
                    </a>

                </div>
                

                @if($applications->count() == 0)
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-6 text-sm text-slate-600">
                        No messages yet.
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($applications as $application)

                            @php
                                if ($application->applicationtype === 'group' && $application->group_id) {

                                    $lastMessage = \App\Models\Message::where('group_id', $application->group_id)
                                        ->where('rentalid', $application->rentalid)
                                        ->latest('created_at')
                                        ->first();

                                    $groupMembers = \Illuminate\Support\Facades\DB::table('student_groups')
                                        ->join('student', 'student.id', '=', 'student_groups.student_id')
                                        ->where('student_groups.group_id', $application->group_id)
                                        ->select('student.firstname', 'student.surname')
                                        ->get();

                                    $memberCount = $groupMembers->count();

                                    $chatName = ($application->student->firstname ?? 'Student') . ' ' . ($application->student->surname ?? '');

                                    if ($memberCount > 1) {
                                        $chatName .= ' +' . ($memberCount - 1) . ' other' . ($memberCount - 1 > 1 ? 's' : '');
                                    }

                                    $chatType = 'Group application';

                                } else {

                                    $lastMessage = \App\Models\Message::where('studentid', $application->studentid)
                                        ->where('rentalid', $application->rentalid)
                                        ->latest('created_at')
                                        ->first();

                                    $chatName = ($application->student->firstname ?? 'Student') . ' ' . ($application->student->surname ?? '');

                                    $chatType = 'Individual application';

                                }
                            @endphp

                            <a href="{{ route('landlord.messages.show', $application->id) }}"
                               class="block rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-blue-200 hover:shadow-md">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-base font-semibold text-black truncate">
                                                {{ trim($chatName) }}
                                            </h3>

                                            @if($application->applicationtype === 'group' && $application->group_id)
                                                <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                                                    Group
                                                </span>
                                            @endif
                                        </div>

                                        <p class="mt-1 text-sm text-slate-500">
                                            {{ $chatType }}
                                        </p>

                                        <p class="mt-1 text-sm text-slate-500">
                                            {{ $application->rental->housenumber ?? '' }}
                                            {{ $application->rental->street ?? '' }},
                                            {{ $application->rental->county ?? '' }}
                                        </p>

                                        <p class="mt-3 text-sm text-slate-700 truncate">
                                            {{ $lastMessage ? \Illuminate\Support\Str::limit($lastMessage->content, 90) : 'No messages yet.' }}
                                        </p>
                                    </div>

                                    <div class="shrink-0 text-xs text-slate-400 whitespace-nowrap">
                                        {{ $lastMessage && $lastMessage->created_at ? $lastMessage->created_at->format('d M Y H:i') : '' }}
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