<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Welcome to RentConnect, {{ session('admin_firstname') ?? 'Administrator' }}
        </h2>
    </x-slot>

    <style>
        body {
            background: #f5f7fb !important;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        .admin-dashboard-container {
            max-width: 900px;               /* matches large admin card style */
            margin: 30px auto;              /* smaller top gap as requested */
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            padding: 40px 30px;
            text-align: center;
            overflow: hidden;
        }

        .icon-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);   /* keeps 2x2 layout */
            row-gap: 30px;
            column-gap: 30px;
            margin-top: 10px;
            justify-content: center;
            align-items: center;
        }

        /* 🔵 UPDATED: rectangle shape instead of square */
        .icon-card {
            background: #f5f7fb;
            border-radius: 12px;
            padding: 26px 20px;
            width: 100%;                     /* fills column width */
            height: 130px;                   /* rectangle shape */
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
            width: 40px;     /* smaller for rectangle proportions */
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
            .icon-row {
                grid-template-columns: 1fr;
                row-gap: 16px;
            }
            .icon-card {
                width: 90%;
                height: 130px;
            }
        }
    </style>

    <div class="admin-dashboard-container">
        {{-- ⭐ User requested: REMOVE "Quick actions" title --}}

        <div class="icon-row">
            <a href="{{ route('admin.reports') }}" class="icon-card">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" fill="none"/>
                    <path d="M7 8h10M7 12h6M7 16h4" stroke="currentColor"/>
                </svg>
                <div class="icon-label">Reports</div>
            </a>

            <a href="{{ route('admin.accounts') }}" class="icon-card">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4" stroke="currentColor" fill="none"/>
                    <path d="M4 20c0-4 8-4 8-4s8 0 8 4" stroke="currentColor"/>
                </svg>
                <div class="icon-label">Accounts</div>
            </a>

            <a href="{{ route('admin.partnerships') }}" class="icon-card">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" stroke="currentColor"/>
                </svg>
                <div class="icon-label">Add Partnership</div>
            </a>

            <a href="{{ route('admin.chatbot') }}" class="icon-card">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <ellipse cx="12" cy="12" rx="10" ry="8" stroke="currentColor" fill="none"/>
                    <circle cx="9" cy="12" r="1.5" fill="currentColor"/>
                    <circle cx="15" cy="12" r="1.5" fill="currentColor"/>
                    <path d="M9 16c1.5 1 4.5 1 6 0" stroke="currentColor"/>
                </svg>
                <div class="icon-label">AI Chatbot</div>
            </a>
        </div>
    </div>
</x-app-layout>