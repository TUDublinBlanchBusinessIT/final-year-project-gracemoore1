{{-- DESKTOP SIDEBAR --}}
<aside class="hidden lg:flex fixed left-0 top-0 h-screen w-60 bg-white border-r border-slate-200 px-4 py-6 z-50">
    <div class="w-full flex flex-col gap-2">
        <div class="px-3 pb-5 border-b border-slate-200">
    {{-- Brand --}}
    <!-- <div class="text-lg font-extrabold text-blue-600">
        RentConnect
    </div> -->

    @php
        $landlord = \App\Models\Landlord::find(session('landlord_id'));

        $landlordUnreadCount = 0;

        if ($landlord) {
            $landlordUnreadCount = \App\Models\Message::where('landlordid', $landlord->id)
                ->where('sender_type', '!=', 'landlord')
                ->where('is_read_by_landlord', false)
                ->count();
        }
    @endphp

    {{-- User dropdown --}}
    <div class="mt-2">
        <x-dropdown align="left" width="48">
            <x-slot name="trigger">
                <button type="button"
                    class="w-full flex items-center justify-between gap-2 rounded-xl px-3 py-1
                           text-blue-600 font-semibold text-lg font-bold hover:bg-blue-50 transition">
                    <span class="truncate">{{ Auth::user()->name }}</span>

                    <svg class="h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>

    {{-- Role label --}}
    <div class="text-xs text-slate-500 mt-2 px-3">
        Landlord
    </div>
</div>


        <a href="{{ route('landlord.dashboard') }}"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            <span>🏠</span>
            <span class="font-semibold">Home</span>
        </a>

        <a href="{{ route('landlord.messages') }}"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('landlord.messages') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            <span>💬</span>
            <span class="font-semibold">Messages</span>
        
            @if($landlordUnreadCount > 0)
                <span class="inline-flex items-center justify-center min-w-[20px] h-[20px] rounded-full bg-red-500 px-1.5 text-[11px] font-semibold text-white">
                    {{ $landlordUnreadCount }}
                </span>
            @endif
    
        </a>

        <a href="{{ route('landlord.support') }}"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('landlord.support') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            <span>🛟</span>
            <span class="font-semibold">Support</span>
        </a>

        <a href="{{ route('profile.edit') }}"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            <span>👤</span>
            <span class="font-semibold">Profile</span>
        </a>
    </div>
</aside>

{{-- MOBILE BOTTOM NAV --}}
<nav class="lg:hidden fixed bottom-4 left-1/2 -translate-x-1/2 w-[min(520px,calc(100%-1.5rem))] bg-white/95 backdrop-blur border border-slate-200 shadow-xl rounded-2xl px-3 py-2 z-50">
    <div class="flex items-center justify-between">
        <a href="{{ route('dashboard') }}"
           class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
           {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-slate-900' }}">
            <span>🏠</span>
            <span class="text-[11px] font-semibold">Home</span>
        </a>

        <a href="{{ route('landlord.messages') }}"
           class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
           {{ request()->routeIs('landlord.messages') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-slate-900' }}">
            <span>💬</span>
            <span class="text-[11px] font-semibold">Chat</span>
        </a>

        <a href="{{ route('landlord.support') }}"
           class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
           {{ request()->routeIs('landlord.support') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-slate-900' }}">
            <span>🛟</span>
            <span class="text-[11px] font-semibold">Support</span>
        </a>

        <a href="{{ route('profile.edit') }}"
           class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
           {{ request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-slate-900' }}">
            <span>👤</span>
            <span class="text-[11px] font-semibold">Profile</span>
        </a>
    </div>
</nav>
