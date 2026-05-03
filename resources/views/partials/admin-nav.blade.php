{{-- Admin sidebar + mobile nav (Option A: minimal on dashboard) --}}
@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;

    $user = Auth::user();
    $adminName = $user->name ?? (session('admin_firstname') ?? 'Administrator');
    $onDashboard = request()->routeIs('admin.dashboard');

    // Items
    $dashboardItem = [
        'label' => 'Dashboard',
        'icon'  => '🏠',
        'route' => 'admin.dashboard',
        'active'=> request()->routeIs('admin.dashboard'),
        'exists'=> Route::has('admin.dashboard'),
    ];

    $navLinks = [
        [
            'label' => 'User Complaints',
            'icon'  => '📊',
            'route' => 'admin.reports',
            'active'=> request()->routeIs('admin.reports'),
            'exists'=> Route::has('admin.reports'),
        ],
        [
            'label' => 'Accounts',
            'icon'  => '👥',
            'route' => 'admin.accounts',
            'active'=> request()->routeIs('admin.accounts'),
            'exists'=> Route::has('admin.accounts'),
        ],
        [
            'label' => 'Add Partnership',
            'icon'  => '🤝',
            'route' => 'admin.partnerships',
            'active'=> request()->routeIs('admin.partnerships*'),
            'exists'=> Route::has('admin.partnerships'),
        ],
        [
            'label' => 'AI Chatbot',
            'icon'  => '🤖',
            'route' => 'admin.chatbot',
            'active'=> request()->routeIs('admin.chatbot'),
            'exists'=> Route::has('admin.chatbot'),
        ],
    ];

    $analytics = [
    'label' => 'Analytics',
    'icon'  => '📈',
    'route' => 'admin.analytics',
    'active'=> request()->routeIs('admin.analytics'),
    'exists'=> Route::has('admin.analytics'),
    ];

    // Sidebar items:
    // - On dashboard: ONLY Profile
    // - Else: Dashboard + 4 pages + Profile
    if ($onDashboard) {
        $sidebarItems = array_values(array_filter(
            [$analytics],
            fn($i) => !empty($i['exists']) && $i['exists']
        ));
    } else {
        $sidebarItems = array_values(array_filter(
            array_merge([$dashboardItem], $navLinks, [$analytics]),
            fn($i) => !empty($i['exists']) && $i['exists']
        ));
    }

    // Mobile: always Dashboard + 4 pages + Profile
    $mobileItems = array_values(array_filter(
        array_merge([$dashboardItem], $navLinks, [$analytics]),
        fn($i) => !empty($i['exists']) && $i['exists']
    ));
@endphp

{{-- ===== DESKTOP LEFT SIDEBAR (always for admin) ===== --}}
<aside class="hidden lg:flex fixed left-0 top-0 h-screen w-60 bg-white border-r border-slate-200 px-4 py-6 z-50">
    <div class="w-full flex flex-col gap-2">
        {{-- Admin name dropdown + role --}}
        <div class="px-3 pb-5 border-b border-slate-200">
            <x-dropdown align="left" width="48">
                <x-slot name="trigger">
                    <button type="button"
                        class="w-full flex items-center justify-between gap-2 rounded-xl px-3 py-2
                               text-blue-600 font-semibold text-sm hover:bg-blue-50 transition">
                        <span class="truncate">{{ $adminName }}</span>
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

            <div class="text-xs text-slate-500 mt-2 px-3">Administrator</div>
        </div>

        {{-- Sidebar links --}}
        @foreach ($sidebarItems as $item)
            <a href="{{ route($item['route']) }}"
               class="w-full flex items-center gap-3 px-3 py-2 rounded-xl transition
               {{ !empty($item['active']) && $item['active'] ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <span>{{ $item['icon'] }}</span>
                <span class="font-semibold">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</aside>

{{-- ===== MOBILE BOTTOM NAV (always) ===== --}}
<nav class="lg:hidden fixed bottom-4 left-1/2 -translate-x-1/2 w-[min(520px,calc(100%-1.5rem))] bg-white/95 backdrop-blur border border-slate-200 shadow-xl rounded-2xl px-3 py-2 z-50">
    <div class="flex items-center justify-between">
        @foreach ($mobileItems as $item)
            <a href="{{ route($item['route']) }}"
               class="flex flex-col items-center justify-center gap-1 w-20 py-2 rounded-xl transition
               {{ !empty($item['active']) && $item['active'] ? 'bg-blue-50 text-blue-600' : 'text-slate-500 hover:text-black' }}">
                <span class="text-xl leading-none">{{ $item['icon'] }}</span>
                <span class="text-[11px] font-semibold">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</nav>