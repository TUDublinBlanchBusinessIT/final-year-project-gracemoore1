<p>Dear <?php echo e($provider->firstname); ?> <?php echo e($provider->surname); ?>,</p>
<p>Your RentConnect service provider account has been created.</p>

<p>
    <strong>Login Email:</strong> <?php echo e($provider->email); ?><br>
    <strong>Password:</strong> <?php echo e($plainPassword); ?>

</p>

<p>Welcome to RentConnect!</p>
<p>Best regards,<br>RentConnect Team</p>
<?php /**PATH C:\Users\moyak\final-year-project-gracemoore1\resources\views/emails/serviceprovider_welcome.blade.php ENDPATH**/ ?>