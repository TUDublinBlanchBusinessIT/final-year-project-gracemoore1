<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@php
    $isStudent         = session('student_id');
    $isLandlord        = session('landlord_id');
    $isAdmin           = session('admin_id');
    $isServiceProvider = session('serviceprovider_id');

    // Roles with a FIXED left sidebar on desktop:
    $hasFixedSidebar = false;
    if ($isStudent)         $hasFixedSidebar = true;
    if ($isAdmin)           $hasFixedSidebar = true;
    if ($isLandlord)        $hasFixedSidebar = true;
    if ($isServiceProvider) $hasFixedSidebar = true; // ✅ include SP like Admin
@endphp
@php
    // Load the correct user model based on session
    $currentUser = null;
    $currentRole = null;

    if ($isStudent) {
        $currentRole = 'student';
        $currentUser = \App\Models\Student::find($isStudent);
    }

    if ($isLandlord) {
        $currentRole = 'landlord';
        $currentUser = \App\Models\Landlord::find($isLandlord);
    }

    if ($isServiceProvider) {
        $currentRole = 'serviceprovider';
        // YOUR ACTUAL MODEL NAME:
        $currentUser = \App\Models\Serviceproviderpartnership::find($isServiceProvider);
    }

    if ($isAdmin) {
        $currentRole = 'admin';
        $currentUser = \App\Models\Admin::find($isAdmin);
    }

    // Normalize suspension
    $status = strtolower(trim(
        (string)($currentUser->status ?? $currentUser->account_status ?? '')
    ));

    $isSuspendedBanner = $currentUser && (
        $status === 'suspended' ||
        ($currentUser->is_suspended ?? false)
    );
@endphp
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    {{-- Top nav:
         Admin + ServiceProvider use their own sidebars/bottom navs (no default top bar)
         Others fall back to the standard top nav --}}
    @if ($isAdmin || $isServiceProvider)
        {{-- No default top bar --}}
    
    @elseif ($isLandlord || Auth::check())
            @include('layouts.navigation')
    @endif


    {{-- PAGE HEADER --}}
    @isset($header)
        <header class="bg-white shadow {{ $hasFixedSidebar ? 'lg:pl-60' : '' }}">
            <div class="
                @if ($isStudent || $isAdmin || $isServiceProvider)
                    w-full
                @else
                    max-w-5xl mx-auto
                @endif
                py-6 px-4 sm:px-6 lg:px-8
            ">
                {{ $header }}

                {{-- SUSPENSION BANNER BELOW NAV --}}
                @if($isSuspendedBanner)
                    <div class="{{ $hasFixedSidebar ? 'lg:pl-60' : '' }} w-full px-0 mx-0">
                        <div class="bg-red-600 text-white px-4 py-3 rounded-md mt-4 text-center font-semibold align-left">
                            Your {{ ucfirst($currentRole) }} account is suspended — 
                            contact <strong>rentconnect.app@gmail.com</strong>
                        </div>
                    </div>
                @endif
            </div>
        </header>
    @endisset

    {{-- MAIN CONTENT --}}
    <main class="{{ $hasFixedSidebar ? 'lg:pl-60' : '' }} pb-24 lg:pb-0">
        @if ($isStudent || $isAdmin || $isServiceProvider)
            <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
                {{ $slot ?? '' }}
            </div>
        @else
            <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {{ $slot ?? '' }}
            </div>
        @endif
    </main>

    {{-- FIXED SIDEBARS / NAV PARTIALS --}}
    @if     ($isStudent)
        @include('partials.student-nav')
    @elseif ($isLandlord)
        @include('partials.landlord-nav')
    @elseif ($isAdmin)
        @include('partials.admin-nav')
    @elseif ($isServiceProvider)
        @include('partials.serviceprovider-nav') {{-- ✅ correct include --}}
    @endif

</div>
</body>
</html>

