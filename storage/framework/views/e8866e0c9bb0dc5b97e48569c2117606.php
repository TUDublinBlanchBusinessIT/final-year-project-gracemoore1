<p>Hello,</p>

<p>You requested a password reset for your RentConnect student account.</p>

<p>Click this link to reset password: <br>

<?php echo e(url('/student/reset-password/' . $token) . '?email=' . urlencode($student_email)); ?>

    Reset Password
    </a>
</p>

<p>If you did not request this, ignore this email.</p><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/emails/student-reset.blade.php ENDPATH**/ ?>