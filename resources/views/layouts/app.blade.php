<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    @php
        $isStudent  = session('student_id');
        $isLandlord = session('landlord_id');
        $isAdmin    = session('admin_id');

        // Sidebar is visible:
        // - Student → always
        // - Admin   → always (including admin.dashboard)
        // - Landlord → keep existing behavior (assumed always)
        $hasSidebar = false;
        if ($isStudent)  $hasSidebar = true;
        if ($isAdmin)    $hasSidebar = true;
        if ($isLandlord) $hasSidebar = true;
    @endphp

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            {{-- TOP NAVIGATION
                 Admin: NO top bar (sidebar handles name + logout)
                 Others: keep existing top nav --}}
            @if ($isAdmin)
                {{-- no top bar for admin --}}
            @elseif ($isLandlord || Auth::check())
                @include('layouts.navigation')
            @endif

            {{-- PAGE HEADER --}}
            @isset($header)
                <header class="bg-white shadow {{ $hasSidebar ? 'lg:pl-60' : '' }}">
                    <div class="
                        @if ($isStudent || $isAdmin)
                            w-full
                        @else
                            max-w-5xl mx-auto
                        @endif
                        py-6 px-4 sm:px-6 lg:px-8
                    ">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- MAIN CONTENT WRAPPER --}}
            <main class="{{ $hasSidebar ? 'lg:pl-60' : '' }} pb-24 lg:pb-0">
                @if ($isStudent || $isAdmin)
                    {{-- Student + Admin pages are full width --}}
                    <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
                        {{ $slot ?? '' }}
                    </div>
                @else
                    {{-- Everyone else keeps centered layout --}}
                    <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        {{ $slot ?? '' }}
                    </div>
                @endif
            </main>

            {{-- FIXED SIDEBARS + MOBILE NAVS --}}
            @if ($isStudent)
                @include('partials.student-nav')
            @elseif ($isLandlord)
                @include('partials.landlord-nav')
            @elseif ($isAdmin)
                @include('partials.admin-nav')
            @endif

        </div>
    </body>
</html>
