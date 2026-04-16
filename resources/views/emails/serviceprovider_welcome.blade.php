<p>Dear {{ $provider->firstname }} {{ $provider->surname }},</p>

<p>We are pleased to inform you that your RentConnect service provider account has been created.</p>

<p>Please find your temporary login credentials below. For security reasons, these details are intended for initial access only.</p>

<p>
    <strong>Login Email:</strong> {{ $provider->email }}<br>
    <strong>Temporary Password:</strong> {{ $plainPassword }}
</p>

<p>
    Once you have logged in, <strong>please change your password immediately</strong> via your account settings to ensure the security of your account.
</p>

<p>If you experience any issues accessing your account, please contact the RentConnect support team.</p>

<p>Welcome to RentConnect.</p>

<p>Kind regards,<br>
<strong>RentConnect Team</strong></p>
