{{-- resources/views/serviceprovider/dashboard.blade.php --}}
<x-app-layout>
    @php
        
        $spName = session('serviceprovider_firstname') ?? 'Service Provider';
    @endphp

    {{-- ====== PAGE HEADER ====== --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Welcome to RentConnect, {{ $spName }}
            {{-- ⭐ SUSPENDED ACCOUNT WARNING --}}
            @if(isset($provider) && strtolower(trim($provider->status)) === 'suspended')
                <div style="
                    background:#c0392b;
                    color:white;
                    padding:22px;
                    border-radius:10px;
                    margin:30px auto 40px auto;
                    max-width:900px;
                    font-size:17px;
                    font-weight:600;
                    text-align:center;">
                    Your service provider account is currently suspended —
                    for enquiries contact <strong>rentconnect.app@gmail.com</strong>.
                </div>
            @endif
        </h2>
    </x-slot>

    {{-- ====== DASHBOARD STYLES (match Admin look) ====== --}}
    <style>
        body {
            background: #f5f7fb !important;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        .sp-dashboard-container {
            max-width: 900px;  /* same as admin */
            margin: 30px auto;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            padding: 40px 30px;
            text-align: center;
            overflow: hidden;
        }

        .icon-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            row-gap: 30px;
            column-gap: 30px;
            margin-top: 10px;
            justify-content: center;
            align-items: center;
        }

        .icon-card {
            background: #f5f7fb;
            border-radius: 12px;
            padding: 26px 20px;
            width: 100%;
            height: 130px;
            box-shadow: 0 2px 8px rgba(38,98,227,0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: box-shadow 0.2s, transform 0.2s;
            cursor: pointer;
            text-decoration: none;
        }

        .icon-card:hover {
            box-shadow: 0 4px 16px rgba(38,98,227,0.12);
            background: #eaf1fc;
            transform: translateY(-2px);
        }

        .icon-card svg {
            width: 40px;
            height: 40px;
            margin-bottom: 10px;
            color: rgb(38, 98, 227);
        }

        .icon-label {
            font-size: 17px;
            font-weight: 600;
            color: #333;
            margin-top: 6px;
        }

        @media (max-width: 700px) {
            .icon-row { grid-template-columns: 1fr; row-gap: 16px; }
            .icon-card { width: 90%; height: 130px; }
        }
    </style>

    {{-- ====== DASHBOARD CONTENT (4 redirect tiles centered) ====== --}}
    <div class="sp-dashboard-container">
        <div class="icon-row">

            {{-- Upcoming Jobs --}}
            <a href="{{ route('serviceprovider.upcoming') }}" class="icon-card">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" fill="none"/>
                    <path d="M8 2v4M16 2v4M3 10h18" stroke="currentColor"/>
                </svg>
                <div class="icon-label">Upcoming Jobs</div>
            </a>

            {{-- Completed Jobs --}}
            <a href="{{ route('serviceprovider.completed') }}" class="icon-card">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M5 13l4 4L19 7" stroke="currentColor"/>
                </svg>
                <div class="icon-label">Completed Jobs</div>
            </a>

            {{-- Requested Jobs --}}
            <a href="{{ route('serviceprovider.requested') }}" class="icon-card">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M7 3h10a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" stroke="currentColor"/>
                    <path d="M9 7h6M9 11h6M9 15h4" stroke="currentColor"/>
                </svg>
                <div class="icon-label">Requested Jobs</div>
            </a>

            {{-- Messages --}}
            <a href="{{ route('serviceprovider.messages') }}" class="icon-card">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M21 15a2 2 0 0 1-2 2H8l-4 4V5a2 2 0 0 1 2-2h13a2 2 0 0 1 2 2v10z" stroke="currentColor"/>
                </svg>
                <div class="icon-label">Messages</div>
            </a>

        </div>
    </div>
</x-app-layout>
