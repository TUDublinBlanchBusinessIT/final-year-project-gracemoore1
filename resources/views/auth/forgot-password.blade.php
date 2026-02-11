<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | RentConnect</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root { --primary: #2d6cdf; }
        * { box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body {
            background: #f5f7fb;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            width: 380px;
            padding: 40px 35px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            text-align: center;
        }
        .logo { width: 140px; margin-bottom: 20px; }
        h1 { font-size: 28px; font-weight: 800; color: var(--primary); margin-bottom: 10px; }
        p { color: #555; font-size: 15px; margin-bottom: 25px; }
        .success-box {
            background: #e8f1ff;
            border-left: 4px solid var(--primary);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            color: #2d6cdf;
            font-weight: 500;
        }
        .input-wrapper { position: relative; margin-bottom: 15px; }
        .input-wrapper i {
            position: absolute; left: 12px; top: 50%;
            transform: translateY(-50%); color: #888;
        }
        input {
            width: 100%; padding: 12px 14px 12px 40px;
            border: 1px solid #dcdcdc; border-radius: 8px;
            font-size: 15px;
        }
        button {
            width: 100%; padding: 12px;
            background: var(--primary); border: none;
            border-radius: 8px; color: white;
            font-size: 16px; font-weight: 600;
            cursor: pointer;
        }
        a { display: inline-block; margin-top: 20px; color: var(--primary); text-decoration: none; }
    </style>
</head>

<body>

<div class="container">
    <img src="/images/RentConnectlogo.png" class="logo">

    @if (session('status'))
        <h1>Check Your Email</h1>
        <div class="success-box">
            We’ve sent a password reset link to your email.
        </div>
        <a href="{{ route('login') }}">← Back to Login</a>
    @else
        <h1>Forgot Password</h1>
        <p>Enter your email and we’ll send you a reset link.</p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="input-wrapper">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" placeholder="Email Address" required>
            </div>

            <button type="submit">Send Reset Link</button>

            <a href="{{ route('login') }}">← Back to Login</a>
        </form>
    @endif
</div>

<script src="https://kit.fontawesome.com/a2e0e6ad65.js" crossorigin="anonymous"></script>

</body>
</html>
