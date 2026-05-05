<!-- application/views/email/reset_password.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .logo {
            max-width: 200px;
            height: auto;
        }
        .content {
            padding: 20px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
            text-align: center;
            font-size: 12px;
            color: #666666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="<?= base_url('assets/font-end/images/logo.png') ?>" alt="School Logo" class="logo">
        </div>
        
        <div class="content">
            <h2>Reset Your Password</h2>
            
            <p>Dear <?= $user_name ?>,</p>
            
            <p>We received a request to reset the password for your account. To proceed with the password reset, please click the button below:</p>
            
            <div style="text-align: center;">
                <a href="<?= $reset_link ?>" class="button">Reset Password</a>
            </div>
            
            <p>This password reset link will expire on <?= $expires ?>.</p>
            
            <p>If you didn't request this password reset, you can safely ignore this email. Your password will remain unchanged.</p>
            
            <p>For security reasons, this link can only be used once. If you need to reset your password again, please visit the login page and request another reset link.</p>
        </div>
        
        <div class="footer">
            <p>This is an automated email, please do not reply.</p>
            <p>If you need assistance, please contact our support team.</p>
            <p>&copy; <?= date('Y') ?> School Name. All rights reserved.</p>
        </div>
    </div>
</body>
</html>