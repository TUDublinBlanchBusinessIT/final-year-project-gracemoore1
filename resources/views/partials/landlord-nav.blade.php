{{-- DESKTOP SIDEBAR --}}
<aside class="hidden lg:flex fixed left-0 top-0 h-screen w-60 bg-white border-r border-slate-200 px-4 py-6 z-50">
    <div class="w-full flex flex-col gap-2">
        <div class="px-3 pb-4">
            <div class="text-lg font-extrabold text-slate-900">RentConnect</div>
            <div class="text-xs text-slate-500 mt-1">Landlord</div>
        </div>

        <a href="{{ route('dashboard') }}"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 9.5L12 3l9 6.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V9.5z"/>
            </svg>
            <span class="font-semibold">Home</span>
        </a>

        <a href="{{ route('messages') }}"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('messages') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"/>
            </svg>
            <span class="font-semibold">Messages</span>
        </a>

        <a href="{{ route('landlord.support') }}"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('landlord.support') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M8 6h13M8 12h13M8 18h13"/>
                <path d="M3 6h.01M3 12h.01M3 18h.01"/>
            </svg>
            <span class="font-semibold">Support</span>
        </a>

        <a href="{{ route('profile.edit') }}"
           class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21a8 8 0 1 0-16 0"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
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
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 9.5L12 3l9 6.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1V9.5z"/>
            </svg>
            <span class="text-[11px] font-semibold">Home</span>
        </a>

        <a href="{{ route('messages') }}"
           class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
           {{ request()->routeIs('messages') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-slate-900' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"/>
            </svg>
            <span class="text-[11px] font-semibold">Chat</span>
        </a>

        <a href="{{ route('landlord.support') }}"
           class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
           {{ request()->routeIs('landlord.support') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-slate-900' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M8 6h13M8 12h13M8 18h13"/>
                <path d="M3 6h.01M3 12h.01M3 18h.01"/>
            </svg>
            <span class="text-[11px] font-semibold">Support</span>
        </a>

        <a href="{{ route('profile.edit') }}"
           class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
           {{ request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-slate-900' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21a8 8 0 1 0-16 0"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            <span class="text-[11px] font-semibold">Profile</span>
        </a>
    </div>
</nav>
