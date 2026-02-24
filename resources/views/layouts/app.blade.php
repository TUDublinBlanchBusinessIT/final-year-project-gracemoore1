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
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @if (session('landlord_id') || Auth::check())
                @include('layouts.navigation')
            @endif

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow lg:pl-60">
                    <div class="max-w-5xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="pb-24 lg:pl-60 lg:pb-0">
                @if (session('student_id'))
                    {{-- Student pages: left-aligned, full-width container --}}
                    <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
                        {{ $slot ?? '' }}
                    </div>
                @else
                    {{-- Other roles: original centered container --}}
                    <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        {{ $slot ?? '' }}
                    </div>
                @endif
            </main>

            @if (session('student_id'))
                @include('partials.student-nav')
            @elseif (session('landlord_id'))
                @include('partials.landlord-nav')
            @endif

        </div>
    </body>
</html>
