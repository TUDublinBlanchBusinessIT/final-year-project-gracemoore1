<x-app-layout>
    <x-slot name="header">
        <div class="border-b border-slate-200 px-6 py-3 bg-white">
            <p class="text-lg font-extrabold uppercase tracking-[0.16em] text-blue-600">
                Messages
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
                                $loggedInStudentId = session('student_id');

                                if ($application->applicationtype === 'group' && $application->group_id) {
                                    $lastMessage = \App\Models\Message::where('group_id', $application->group_id)
                                        ->where('rentalid', $application->rentalid)
                                        ->latest('created_at')
                                        ->first();

                                    $unreadCount = \App\Models\Message::where('group_id', $application->group_id)
                                        ->where('rentalid', $application->rentalid)
                                        ->where('is_read_by_student', false)
                                        ->where(function ($query) use ($loggedInStudentId) {
                                            $query->where('sender_type', 'landlord')
                                                ->orWhere('sender_type', 'system')
                                                ->orWhere(function ($subQuery) use ($loggedInStudentId) {
                                                    $subQuery->where('sender_type', 'student')
                                                        ->where('studentid', '!=', $loggedInStudentId);
                                                });
                                        })
                                        ->count();

                                    $groupMembers = \Illuminate\Support\Facades\DB::table('student_groups')
                                        ->join('student', 'student.id', '=', 'student_groups.student_id')
                                        ->where('student_groups.group_id', $application->group_id)
                                        ->where('student.id', '!=', $loggedInStudentId)
                                        ->select('student.firstname', 'student.surname')
                                        ->get();

                                    $otherMemberNames = $groupMembers->map(function ($member) {
                                        return trim(($member->firstname ?? '') . ' ' . ($member->surname ?? ''));
                                    })->filter()->values();

                                    $groupSubtitle = $otherMemberNames->count()
                                        ? 'With ' . $otherMemberNames->implode(', ')
                                        : 'Group application';

                                } else {
                                    $lastMessage = \App\Models\Message::where('studentid', $application->studentid)
                                        ->where('rentalid', $application->rentalid)
                                        ->latest('created_at')
                                        ->first();

                                    $unreadCount = \App\Models\Message::where('studentid', $application->studentid)
                                        ->where('rentalid', $application->rentalid)
                                        ->where('is_read_by_student', false)
                                        ->where('sender_type', '!=', 'student')
                                        ->count();

                                    $groupSubtitle = 'Individual application';
                                }
                            @endphp

                            <a href="{{ route('student.messages.show', $application->id) }}"
                               class="block rounded-xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-base font-semibold text-slate-900 truncate">
                                                {{ $application->rental->landlord->firstname ?? 'Landlord' }}
                                                {{ $application->rental->landlord->surname ?? '' }}
                                            </h3>

                                            @if($application->applicationtype === 'group' && $application->group_id)
                                                <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                                                    Group
                                                </span>
                                            @endif


                                            @if($application->status === 'accepted')
                                                <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                                    Current Accommodation
                                                </span>
                                            @endif
                                        </div>

                                        <p class="mt-1 text-sm text-slate-500">
                                            {{ $groupSubtitle }}
                                        </p>

                                        <p class="mt-1 text-sm text-slate-500">
                                            {{ $application->rental->housenumber ?? '' }}
                                            {{ $application->rental->street ?? '' }},
                                            {{ $application->rental->county ?? '' }}
                                        </p>

                                        <p class="mt-3 text-sm text-slate-700 truncate">
                                            {{ $lastMessage ? \Illuminate\Support\Str::limit($lastMessage->content, 80) : 'No messages yet.' }}
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
                        @endforeach                       
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>