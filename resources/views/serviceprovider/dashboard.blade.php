<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Service Provider Dashboard | RentConnect</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fb;
            margin: 0;
            padding: 0;
        }

        .header {
            background: rgb(38, 98, 227);
            padding: 18px 30px;
            color: white;
            font-size: 22px;
            font-weight: 700;
        }

        .container {
            margin: 40px auto;
            width: 90%;
            max-width: 900px;
            background: white;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }

        h2 {
            font-size: 26px;
            margin-top: 0;
            color: rgb(38, 98, 227);
            font-weight: 700;
        }

        p {
            font-size: 16px;
            color: #555;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            background: rgb(38, 98, 227);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn:hover {
            background: #1f54b8;
        }
    </style>

</head>
<body>

    <div class="header">
        Service Provider Dashboard
    </div>

    <div class="container">
        <h2>Welcome to your dashboard!</h2>

        <p>
            You are logged in as a <strong>RentConnect Service Provider</strong>.
            This dashboard will soon display your jobs, payments, notifications and more.
        </p>

        <p>
            For now, this is just placeholder content so you can confirm the login system
            works correctly for service providers.
        </p>

        <a href="{{ url('/') }}" class="btn">Return to Home</a>
    </div>

</body>
</html>