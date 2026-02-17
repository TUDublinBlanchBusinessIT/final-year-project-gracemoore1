<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | RentConnect</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root { --primary: #2d6cdf; }

        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f5f7fb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            width: 380px;
            padding: 40px 35px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            text-align: center;
        }

        .logo {
            width: 140px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 28px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 10px;
        }

        p {
            color: #555;
            margin-bottom: 25px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: var(--primary);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            cursor: pointer;
        }

        a {
            display: block;
            margin-top: 15px;
            color: var(--primary);
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">
    <img src="/images/RentConnectlogo.png" class="logo">

    <h1>Create New Password</h1>
    <p>Please enter your new password below.</p>

    @if ($errors->any())
        <div style="color: #fff; background: #e74c3c; border-radius: 6px; padding: 10px; margin-bottom: 15px;">
            {{ $errors->first() }}
        </div>
    @endif
    @if (session('status'))
        <div style="color: #fff; background: #27ae60; border-radius: 6px; padding: 10px; margin-bottom: 15px;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

    
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email ?? '' }}">

   
        <input type="password" name="password" placeholder="New Password" required>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

        <button type="submit">Reset Password</button>

        <a href="{{ route('login') }}">← Back to Login</a>
    </form>

</div>

</body>
</html>
