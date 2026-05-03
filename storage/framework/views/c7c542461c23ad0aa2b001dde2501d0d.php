<p>Dear <?php echo e($provider->firstname); ?> <?php echo e($provider->surname); ?>,</p>

<p>We are pleased to inform you that your RentConnect service provider account has been created.</p>

<p>Please find your temporary login credentials below. For security reasons, these details are intended for initial access only.</p>

<p>
    <strong>Login Email:</strong> <?php echo e($provider->email); ?><br>
    <strong>Temporary Password:</strong> <?php echo e($plainPassword); ?>

</p>

<p>
    Once you have logged in, <strong>please change your password immediately</strong> via your account settings to ensure the security of your account.
</p>

<p>If you experience any issues accessing your account, please contact the RentConnect support team.</p>

<p>Welcome to RentConnect.</p>

<p>Kind regards,<br>
<strong>RentConnect Team</strong></p>
<?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/emails/serviceprovider_welcome.blade.php ENDPATH**/ ?>