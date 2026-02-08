<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
<body>
    <h1>Email Verification</h1>
    <p>Please enter the 4-digit code sent to your email.</p>

    <form method="POST" action="{{ route('landlord.verify.email.submit') }}">
        @csrf

        <input type="hidden" name="email" value="{{ request('email') }}">

        <label>4 digit code:</label>
        <input type="text" name="code" required maxlength="4">

        <button type="submit">Verify</button>
    </form>
</body>
</html>
