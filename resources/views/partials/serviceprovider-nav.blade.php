{{-- resources/views/partials/serviceprovider-nav.blade.php --}}
@php
    use Illuminate\Support\Facades\Route;

    // Name from session (same key as dashboard header)
    $spName = session('serviceprovider_firstname') ?? 'Service Provider';
    
    $serviceProviderUnreadMessages = \App\Models\Message::where('serviceproviderpartnershipid', session('serviceprovider_id'))
        ->where('sender_type', '!=', 'service_provider')
        ->where('is_read_by_service_provider', false)
        ->count();

    // Build nav items (always show on dashboard too)
    $items = [
        [
            'label' => 'Upcoming Jobs',
            'route' => 'serviceprovider.upcoming',
            'active'=> request()->routeIs('serviceprovider.upcoming'),
            'exists'=> Route::has('serviceprovider.upcoming'),
            'svg'   => 'calendar',
        ],
        [
            'label' => 'Completed Jobs',
            'route' => 'serviceprovider.completed',
            'active'=> request()->routeIs('serviceprovider.completed'),
            'exists'=> Route::has('serviceprovider.completed'),
            'svg'   => 'check',
        ],
        [
            'label' => 'Requested Jobs',
            'route' => 'serviceprovider.requested',
            'active'=> request()->routeIs('serviceprovider.requested'),
            'exists'=> Route::has('serviceprovider.requested'),
            'svg'   => 'document',
        ],
        [
            'label' => 'Messages',
            'route' => 'serviceprovider.messages',
            'active'=> request()->routeIs('serviceprovider.messages'),
            'exists'=> Route::has('serviceprovider.messages'),
            'svg'   => 'chat',
        ],
        [
            'label'  => 'Profile',
            'route'  => 'serviceprovider.profile',
            'active' => request()->routeIs('serviceprovider.profile'),
            'exists' => Route::has('serviceprovider.profile'),
            'svg'    => 'user',
        ],
    ];

    $items = array_values(array_filter($items, fn($i) => !empty($i['exists']) && $i['exists']));

    // Small helper for SVG icons
    $icon = function(string $name) {
        return match ($name) {
            'home' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5L12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1v-10.5z"/>
                       </svg>',
            'calendar' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M8 2v3M16 2v3"/>
                             <path stroke-linecap="round" stroke-linejoin="round" d="M3 9h18"/>
                             <rect x="3" y="5" width="18" height="17" rx="2" ry="2"></rect>
                           </svg>',
            'check' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/>
                        </svg>',
            'document' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l3 3v15a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"/>
                             <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                           </svg>',
            'chat' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8z"/>
                       </svg>',
            'user' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 21a8 8 0 0 0-16 0"/>
                            <circle cx="12" cy="8" r="4"/>
                        </svg>',
            default => '',
        };
    };
@endphp

{{-- ===== DESKTOP LEFT SIDEBAR (always) ===== --}}
<aside class="hidden lg:flex fixed left-0 top-0 h-screen w-60 bg-white border-r border-slate-200 px-4 py-6 z-50">
    <div class="w-full flex flex-col gap-2">

        {{-- SP name dropdown + role --}}
        <div class="px-3 pb-5 border-b border-slate-200">
            <x-dropdown align="left" width="48">
                <x-slot name="trigger">
                    <button type="button"
                        class="w-full flex items-center justify-between gap-2 rounded-xl px-3 py-2
                               text-blue-600 font-semibold text-lg hover:bg-blue-50 transition">
                        <span class="truncate">{{ $spName }}</span>
                        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <form method="POST" action="{{ url('/logout') }}">
                        @csrf
                        <x-dropdown-link :href="url('/logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Log Out
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>

            <div class="text-xs text-slate-500 mt-1 px-3">Service Provider</div>
        </div>

        {{-- Sidebar links (NOW ALWAYS SHOWS, INCLUDING DASHBOARD) --}}
        <nav class="mt-2 flex flex-col gap-1">
            @foreach ($items as $item)
                <a href="{{ route($item['route']) }}"
                   class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
                   {{ !empty($item['active']) && $item['active'] ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <span class="{{ !empty($item['active']) && $item['active'] ? 'text-blue-600' : 'text-slate-500' }}">{!! $icon($item['svg']) !!}</span>
                    <div class="flex items-center gap-2">
                        <span>{{ $item['label'] }}</span>

                        @if($item['route'] === 'serviceprovider.messages' && $serviceProviderUnreadMessages > 0)
                            <span class="inline-flex items-center justify-center min-w-[22px] h-[22px] rounded-full bg-red-500 px-2 text-xs font-semibold text-white">
                                {{ $serviceProviderUnreadMessages }}
                            </span>
                        @endif
                    </div>
                </a>
            @endforeach
        </nav>
    </div>
</aside>

{{-- ===== MOBILE BOTTOM NAV (always) ===== --}}
<nav class="lg:hidden fixed bottom-4 left-1/2 -translate-x-1/2 w-[min(520px,calc(100%-1.5rem))] bg-white/95 backdrop-blur border border-slate-200 shadow-xl rounded-2xl px-3 py-2 z-50">
    <div class="flex items-center justify-between">
        @foreach ($items as $item)
            <a href="{{ route($item['route']) }}"
               class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
               {{ !empty($item['active']) && $item['active'] ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-black' }}">
                <span class="leading-none">{!! $icon($item['svg']) !!}</span>
                <span class="text-[11px] font-semibold">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</nav>