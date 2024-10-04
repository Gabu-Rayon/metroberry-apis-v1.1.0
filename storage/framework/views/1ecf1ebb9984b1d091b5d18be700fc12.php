<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Details</title>
</head>
<body>
    <p>Dear <?php echo e($organisation); ?>,</p>
    <p>Please find your password below along with your username (email) to log in and reset it with MetroBerry Travel Tours:</p>
    <p><strong>Username:</strong> <?php echo e($email); ?></p>
    <p><strong>Password:</strong> <?php echo e($password); ?></p>
    <p>Thank you for choosing our service.</p>
    <p>Regards,</p>
    <p>MetroBerry Travel Tours</p>
</body>
</html>

<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/app/resources/views/mail-view/organisation-welcome-mail.blade.php ENDPATH**/ ?>