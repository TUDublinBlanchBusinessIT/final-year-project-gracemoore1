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
    $authUser = Auth::user();

    $authRole = $authUser->role ?? null;

    // Keep support for old custom sessions
    $studentSession = session('student_id');
    $landlordSession = session('landlord_id');
    $adminSession = session('admin_id');
    $serviceProviderSession = session('serviceprovider_id');

    // Student + landlord can come from Auth role OR session
    $isStudent = $authRole === 'student' || $studentSession;
    $isLandlord = $authRole === 'landlord' || $landlordSession;

    // Admin + service provider still rely on session
    $isAdmin = !empty($adminSession);
    $isServiceProvider = !empty($serviceProviderSession);

    $hasFixedSidebar = $isStudent || $isAdmin || $isLandlord || $isServiceProvider;

    $currentUser = null;
    $currentRole = null;

    if ($isStudent) {
        $currentRole = 'student';
        if ($authUser) {
            $currentUser = \App\Models\Student::where('email', $authUser->email)->first();
        } elseif ($studentSession) {
            $currentUser = \App\Models\Student::find($studentSession);
        }
    }

    if ($isLandlord) {
        $currentRole = 'landlord';
        if ($authUser) {
            $currentUser = \App\Models\Landlord::where('email', $authUser->email)->first();
        } elseif ($landlordSession) {
            $currentUser = \App\Models\Landlord::find($landlordSession);
        }
    }

    if ($isServiceProvider) {
        $currentRole = 'serviceprovider';
        $currentUser = \App\Models\Serviceproviderpartnership::find($serviceProviderSession);
    }

    if ($isAdmin) {
        $currentRole = 'admin';
        $currentUser = \App\Models\Administrator::find($adminSession);
    }

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

    {{-- TOP NAV --}}
    @if ($isAdmin || $isServiceProvider || $isLandlord || $isStudent)
        {{-- Roles with sidebars do not use the default top nav --}}
    @elseif (Auth::check())
        @include('layouts.navigation')
    @endif

    {{-- PAGE HEADER --}}
    @isset($header)
    <header class="bg-white shadow {{ $hasFixedSidebar ? 'lg:pl-60' : '' }}">

        @if($isSuspendedBanner)
            <div class="bg-red-600 text-white px-4 py-3 w-full text-center font-semibold">
                Your {{ ucfirst($currentRole) }} account is suspended —
                contact <strong>rentconnect.app@gmail.com</strong>
            </div>
        @endif

        <div class="
            @if ($isStudent || $isAdmin || $isServiceProvider || $isLandlord)
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

    {{-- MAIN CONTENT --}}
    <main class="{{ $hasFixedSidebar ? 'lg:pl-60' : '' }} pb-24 lg:pb-0">
        @if ($isStudent || $isAdmin || $isServiceProvider || $isLandlord)
            <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
                {{ $slot ?? '' }}
            </div>
        @else
            <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {{ $slot ?? '' }}
            </div>
        @endif
    </main>

    {{-- SIDEBAR NAVS --}}
    @if ($isStudent)
        @include('partials.student-nav')
    @elseif ($isLandlord)
        @include('partials.landlord-nav')
    @elseif ($isAdmin)
        @include('partials.admin-nav')
    @elseif ($isServiceProvider)
        @include('partials.serviceprovider-nav')
    @endif

</div>
</body>
</html>

