<p>Hello,</p>

<p>You requested a password reset for your RentConnect student account.</p>

<p>Click this link to reset password: <br>

{{ url('/student/reset-password/' . $token) . '?email=' . urlencode($student_email) }}
    Reset Password
    </a>
</p>

<p>If you did not request this, ignore this email.</p>