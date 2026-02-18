<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | RentConnect</title>
    <style>
        body {
            background: #f5f7fb;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        .admin-dashboard-container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            padding: 40px 30px;
            text-align: center;
        }
        .dashboard-title {
            font-size: 30px;
            font-weight: 800;
            color: rgb(38, 98, 227);
            margin-bottom: 10px;
        }
        .icon-row {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin: 40px 0 0 0;
            flex-wrap: wrap;
        }
        .icon-card {
            background: #f5f7fb;
            border-radius: 12px;
            padding: 32px 24px 18px 24px;
            width: 160px;
            box-shadow: 0 2px 8px rgba(38,98,227,0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: box-shadow 0.2s;
            cursor: pointer;
            text-decoration: none;
        }
        .icon-card:hover {
            box-shadow: 0 4px 16px rgba(38,98,227,0.12);
            background: #eaf1fc;
        }
        .icon-card svg {
            width: 48px;
            height: 48px;
            margin-bottom: 16px;
            color: rgb(38, 98, 227);
        }
        .icon-label {
            font-size: 17px;
            font-weight: 600;
            color: #333;
            margin-top: 8px;
        }
        @media (max-width: 700px) {
            .icon-row {
                flex-direction: column;
                gap: 24px;
            }
            .icon-card {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="admin-dashboard-container">
        <div class="dashboard-title">
            Welcome to RentConnect, {{ session('admin_firstname') ?? 'Administrator' }}
        </div>
        <div class="icon-row">
            <a href="{{ route('admin.reports') }}" class="icon-card">
                <!-- Reports Icon -->
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" fill="none"/>
                    <path d="M7 8h10M7 12h6M7 16h4" stroke="currentColor"/>
                </svg>
                <div class="icon-label">Reports</div>
            </a>
            <a href="{{ route('admin.accounts') }}" class="icon-card">
                <!-- Accounts Icon -->
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4" stroke="currentColor" fill="none"/>
                    <path d="M4 20c0-4 8-4 8-4s8 0 8 4" stroke="currentColor"/>
                </svg>
                <div class="icon-label">Accounts</div>
            </a>
            <a href="{{ route('admin.partnerships') }}" class="icon-card">
                <!-- Add Partnership Icon -->
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" stroke="currentColor"/>
                </svg>
                <div class="icon-label">Add Partnership</div>
            </a>
            <a href="{{ route('admin.chatbot') }}" class="icon-card">
                <!-- AI Chatbot Icon -->
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
</body>
</html>