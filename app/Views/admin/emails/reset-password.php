<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body style="font-family: Arial, sans-serif; line-height: 1.6;">
        <p>Dear <?= esc(trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?: 'User') ?>,</p>
        <p>You requested a password reset for your account.</p>

        <p>Click the button below to reset your password:</p>
        <p>
            <a href="<?= esc($resetLink) ?>"
               style="
                   background:#0d6efd;
                   color:#fff;
                   padding:10px 15px;
                   text-decoration:none;
                   border-radius:4px;
                   display:inline-block;">
                Reset Password
            </a>
        </p>

        <p>This link will expire in <strong>1 hour</strong>.</p>

        <p>If you did not request this, please ignore this email.</p>

        <hr>

        <p style="font-size:12px;color:#666;">
            Satish Chandra Memorial School<br>
            This is an automated email, please do not reply.
        </p>
    </body>
</html>
