<p>Dear {{ $provider->firstname }} {{ $provider->surname }},</p>
<p>Your RentConnect service provider account has been created.</p>

<p>
    <strong>Login Email:</strong> {{ $provider->email }}<br>
    <strong>Password:</strong> {{ $plainPassword }}
</p>

<p>Welcome to RentConnect!</p>
<p>Best regards,<br>RentConnect Team</p>
