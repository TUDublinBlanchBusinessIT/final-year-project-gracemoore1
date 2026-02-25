{{-- STUDENT SIDEBAR NAVIGATION --}}
@php
    $student = \App\Models\Student::find(session('student_id'));
@endphp

<aside class="hidden lg:flex fixed left-0 top-0 h-screen w-60 bg-white border-r border-slate-200 px-4 py-6 z-50">
    <div class="w-full flex flex-col gap-2">

        {{-- User dropdown with student name --}}
        <div class="px-3 pb-5 border-b border-slate-200">
            <x-dropdown align="left" width="48">
                <x-slot name="trigger">
                    <button type="button"
                        class="w-full flex items-center justify-between gap-2 rounded-xl px-3 py-2
                               text-blue-600 font-semibold text-sm hover:bg-blue-50 transition">

                        {{-- STUDENT NAME HERE --}}
                        <span class="truncate">
                            {{ $student->firstname ?? $student->name ?? 'Student' }}
                        </span>

                        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </x-slot>

                {{-- Only LOGOUT in dropdown --}}
                <x-slot name="content">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Log Out
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>

            <div class="text-xs text-slate-500 mt-2 px-3">Student</div>
        </div>

        {{-- Sidebar Links --}}
        <a href="{{ route('student.dashboard') }}"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('student.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            🏠 <span class="font-semibold">Home</span>
        </a>

        <a href="{{ route('student.messages') }}"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('student.messages') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            💬 <span class="font-semibold">Messages</span>
        </a>

        <a href="{{ route('student.support') }}"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('student.support') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            🛟 <span class="font-semibold">Support</span>
        </a>

        <a href="{{ route('student.profile.new') }}"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('student.profile.new') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            👤 <span class="font-semibold">Profile</span>
        </a>

    </div>
</aside>

{{-- MOBILE NAV --}}
<nav class="lg:hidden fixed bottom-4 left-1/2 -translate-x-1/2 w-[min(520px,calc(100%-1.5rem))] bg-white/95 backdrop-blur border border-slate-200 shadow-xl rounded-2xl px-3 py-2 z-50">
    <div class="flex items-center justify-between">

        <a href="{{ route('student.dashboard') }}"
           class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
           {{ request()->routeIs('student.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-black' }}">
            🏠 <span class="text-[11px] font-semibold">Home</span>
        </a>

        <a href="{{ route('student.messages') }}"
           class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
           {{ request()->routeIs('student.messages') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-black' }}">
            💬 <span class="text-[11px] font-semibold">Chat</span>
        </a>

        <a href="{{ route('student.support') }}"
           class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
           {{ request()->routeIs('student.support') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-slate-900' }}">
            🛟 <span class="text-[11px] font-semibold">Support</span>
        </a>

        <a href="{{ route('student.profile.new') }}"
           class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
           {{ request()->routeIs('student.profile.new') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-slate-900' }}">
            👤 <span class="text-[11px] font-semibold">Profile</span>
        </a>

    </div>
</nav>