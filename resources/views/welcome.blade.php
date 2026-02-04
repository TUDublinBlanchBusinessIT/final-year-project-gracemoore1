<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentConnect</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #ffffff;
        }
        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .card {
            width: 100%;
            max-width: 420px;
            text-align: center;
        }
        h1 {
            color: #2d6cff;
            font-size: 38px;
            margin-bottom: 12px;
        }
        p {
            margin-bottom: 28px;
            color: #333;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            margin-bottom: 16px;
            background: #2d6cff;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 20px;
            font-weight: bold;
        }
        .or {
            margin: 12px 0;
            color: #555;
        }
        .login {
            margin-top: 20px;
            font-size: 14px;
        }
        .login a {
            color: #2d6cff;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h1>Welcome to<br>RentConnect!</h1>
        <p>Please select your account type</p>

        <a class="btn" href="/student/register">Student</a>

        <div class="or">Or</div>

        <a class="btn" href="/landlord/register">Landlord</a>

        <div class="login">
            Already have an account?<br>
            <a href="/login">Log in here</a>
        </div>
    </div>
</div>
</body>
</html>
