<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RentConnect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
    :root {
        --primary: rgb(38, 98, 227);
        --primary-hover: #1E4FD8;
        --text-main: #1F2937;
        --text-muted: #6B7280;
    }

    * {
        box-sizing: border-box;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont,
                     "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    body {
        margin: 0;
        min-height: 100vh;
        background: #F3F4F6;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 24px;
    }

    .card {
        width: 100%;
        max-width: 420px;
        background: #ffffff;
        padding: 44px 28px;
        border-radius: 20px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.05);
        text-align: center;
    }

    h1 {
        margin: 0 0 10px;
        font-size: 30px;
        font-weight: 800;
        color: var(--primary);
        line-height: 1.2;
    }

    .subtitle {
        font-size: 16px;
        color: var(--text-muted);
        margin-bottom: 36px;
    }

    .btn {
        display: block;
        width: 100%;
        padding: 15px 0;
        margin-bottom: 20px;
        background: var(--primary);
        color: #ffffff;
        text-decoration: none;
        font-size: 16px;
        font-weight: 600;
        border-radius: 12px;
        transition: background 0.2s ease, transform 0.1s ease, opacity 0.15s ease;
    }

    .btn:hover {
        background: var(--primary-hover);
        transform: translateY(-1px);
    }

    .btn:active {
        opacity: 0.85;
        transform: translateY(0);
    }

    .divider {
        display: flex;
        align-items: center;
        margin: 8px 0 24px;
    }

    .divider::before,
    .divider::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #E5E7EB;
    }

    .divider span {
        margin: 0 10px;
        font-size: 14px;
        color: var(--text-muted);
        font-weight: 500;
    }

    .login {
        margin-top: 32px;
        font-size: 15px;
        color: var(--text-muted);
    }

    .login a {
        display: inline-block;
        margin-top: 6px;
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
    }

    .login a:hover {
        text-decoration: underline;
    }
</style>

</head>

<body>
    <div class="card">
        <h1>Welcome to<br>RentConnect</h1>

        <div class="subtitle">
            Please select your account type
        </div>

        <a class="btn" href="/student/register">Student</a>

        <div class="divider"><span>OR</span></div>

        <a class="btn" href="/landlord/register">Landlord</a>

        <div class="login">
            Already have an account?<br>
            <a href="{{ route('login') }}" class="text-blue-600 underline">Log in here</a>

        </div>
    </div>
</body>
</html>
