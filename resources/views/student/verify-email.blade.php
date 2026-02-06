<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification | RentConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    :root {
        --primary: rgb(38, 98, 227);
        --primary-hover: #1E4FD8;
        --text-main: #1F2937;
        --text-muted: #6B7280;
        --bg: #F3F4F6;
        --error: #e53e3e;
    }
    * {
        box-sizing: border-box;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }
    body {
        margin: 0;
        min-height: 100vh;
        background: var(--bg);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 24px;
    }
    .card {
        width: 100%;
        max-width: 420px;
        background: #fff;
        padding: 44px 28px;
        border-radius: 20px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.05);
        text-align: center;
    }
    h1 {
        margin: 0 0 10px;
        font-size: 28px;
        font-weight: 800;
        color: var(--primary);
        line-height: 1.2;
    }
    .subtitle {
        font-size: 16px;
        color: var(--text-muted);
        margin-bottom: 28px;
    }
    form {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-top: 12px;
    }
    input[type="text"], input[type="email"], input[type="password"], input[type="date"], input[type="number"] {
        padding: 13px 12px;
        border: 1.5px solid #E5E7EB;
        border-radius: 10px;
        font-size: 15px;
        background: #F9FAFB;
        color: var(--text-main);
        transition: border 0.2s;
    }
    input:focus {
        border-color: var(--primary);
        outline: none;
    }
    .btn-row {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }
    .btn {
        width: 50%;
        min-width: 110px;
        max-width: 180px;
        padding: 15px 0;
        background: var(--primary);
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        border-radius: 12px;
        border: none;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s, opacity 0.15s;
        box-sizing: border-box;
    }
    .btn:hover {
        background: var(--primary-hover);
        transform: translateY(-1px);
    }
    .btn:active {
        opacity: 0.85;
        transform: translateY(0);
    }
    .error-list {
        background: #fff5f5;
        color: var(--error);
        border: 1px solid var(--error);
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 18px;
        text-align: left;
        font-size: 15px;
    }
    </style>
</head>
<body>
    <div class="card">
        <h1>Email Verification</h1>
        <div class="subtitle">
            Please enter the 4-digit code sent to your email
        </div>
        <form method="POST" action="/student/verify-email">
            @csrf

            @if ($errors->any())
                <div class="error-list">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <input type="text" name="code" placeholder="4 digit code" value="{{ old('code') }}" maxlength="4" required pattern="\d{4}">
            <div class="btn-row">
                <button class="btn" type="submit">Verify</button>
            </div>
        </form>
    </div>
</body>
</html>