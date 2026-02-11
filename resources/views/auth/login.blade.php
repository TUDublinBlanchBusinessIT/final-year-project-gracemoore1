<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | RentConnect</title>

    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary:rgb(38, 98, 227);
        }

        * {
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont,
                         "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background: #f5f7fb;
            margin: 0;
            padding: 0;
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

        .logo {
            width: 140px;
            margin-bottom: 20px;
        }

        h1 {
            margin: 0 0 10px;
            font-size: 30px;
            font-weight: 800;
            color: var(--primary);
            line-height: 1.2;
        }

        p {
            color: #555;
            margin-bottom: 25px;
            font-size: 15px;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 15px;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            font-size: 15px;
            transition: 0.2s;
        }

        input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 2px rgba(45,108,223,0.2);
        }

        button {
            width: 100%;
            padding: 12px;
            background:rgb(38, 98, 227);
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: #1f54b8;
        }

        .link-row {
            margin-top: 15px;
            font-size: 14px;
        }

        .link-row a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
            text-decoration: none;
        }

        .back-btn:hover {
            color: var(--primary);
        }
    </style>
</head>

<body>

<div class="container">

    <!-- RentConnect Logo -->
    <img src="/images/RentConnectlogo.png" alt="RentConnect Logo" class="logo">

    <h1>Welcome Back!</h1>
    <p>Log in to your RentConnect account</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Log In</button>

        <div class="link-row">
            <a href="#">Forgot your password?</a>
        </div>

        <a href="{{ url('/') }}" class="back-btn">← Back to account selection</a>
    </form>
</div>

</body>
</html>
