<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Birthday</title>

    <?php 
        $imageUrl = '';
        if($type == 'student' ) {
            $imageUrl = base_url('/uploads/'.$image);
        } elseif($type == 'staff' ) {
            $imageUrl = base_url('/uploads/profile/'.$image);
        }
        $birthday_content = get_birthday_content($name);

        $getBgImage = $birthday_content['bgimg'] ? base_url($birthday_content['bgimg']) : ''
    ?>

    <style>
        /* CSS ANIMATIONS */
        @keyframes bg-glow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes float-item {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(5deg); }
        }

        /*.animated-canvas {
            background: linear-gradient(-45deg, #0f172a, #1e293b, #334155, #1e293b);
            background-size: 400% 400% !important;
            animation: bg-glow 15s ease infinite;
            position: relative;
            overflow: hidden;
        }*/

        .animated-canvas {
            position: relative;
            overflow: hidden;

            background:
                linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
                url('<?= $getBgImage ?>'),
                linear-gradient(-45deg, #0f172a, #1e293b, #334155, #1e293b);

            background-size: cover, cover, 400% 400%;
            background-position: center, center, 0% 50%;
            background-repeat: no-repeat;

            animation: bg-glow 15s ease infinite;
        }

        .profile-frame {
            border: 4px solid #ffd700;
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.3);
            display: inline-block;
            line-height: 0;
            overflow: hidden;
        }

        .floating-icon {
            display: inline-block;
            animation: float-item 4s infinite ease-in-out;
        }

        /* Sparkle texture overlay */
        .sparkles {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: url('https://www.transparenttextures.com/patterns/stardust.png');
            opacity: 0.4;
            pointer-events: none;
        }

        @media only screen and (max-width: 600px) {
            .main-table { width: 100% !important; border-radius: 0 !important; }
            .content-padding { padding: 30px 20px !important; }
        }
    </style>
</head>


<body style="margin:0; padding:0;">



<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 40px 0;">
    <tr>
        <td align="center">
            
            <table class="main-table" width="600" border="0" cellspacing="0" cellpadding="0" style="background-color:#111111; border-radius:30px; overflow:hidden; box-shadow: 0 30px 60px rgba(0,0,0,0.7);">
                
                <tr>
                    <td class="animated-canvas" align="center" style="padding: 150px 40px; text-align: center; color: #ffffff;">
                        
                        <div class="sparkles"></div>

                        <div style="margin-bottom: 25px;">
                            <span class="floating-icon" style="font-size: 35px; animation-delay: 0s;">🎈</span>
                            <span class="floating-icon" style="font-size: 45px; animation-delay: 0.5s; margin: 0 20px;">✨</span>
                            <span class="floating-icon" style="font-size: 35px; animation-delay: 1s;">🎈</span>
                        </div>

                        <div style="margin-bottom: 30px; position: relative; z-index: 5;">
                            <div class="profile-frame">
                                <?php if($imageUrl != ''): ?>
                                    <img src="<?= $imageUrl ?>" alt="Birthday Celebrant" width="220" height="220" style="display:block; object-fit: cover; border-radius: 15px;">
                                <?php else: ?>
                                    <div style="width: 220px; height: 220px; background: #222; display: flex; align-items: center; justify-content: center; font-size: 50px;">🎂</div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div style="margin-bottom: 30px; position: relative; z-index: 10;">
                            <h1 style="margin: 0; font-family: 'Georgia', serif; font-size: 36px; font-weight: bold; color: #ffd700; text-shadow: 0 0 15px rgba(255, 215, 0, 0.5);">
                                <?= $birthday_content['title'] ?? 'Happy Birthday'; ?>
                            </h1>

                            <p style="margin: 15px 0 0; font-family: 'Verdana', sans-serif; font-size: 13px; color: #ffffff; text-transform: uppercase; letter-spacing: 5px; opacity: 0.8;">
                                Shine Bright Today & Always
                            </p>

                            <div style="width: 60px; height: 2px; background: #ffd700; margin: 25px auto;"></div>

                            <p style="margin: 0; font-family: 'Trebuchet MS', sans-serif; font-size: 18px; color: #f1f1f1; line-height: 1.6; font-style: italic;">
                                "<?= $birthday_content['msg'] ?? 'Wishing you a year of immense growth and happiness.'; ?>"
                            </p>

                            <table border="0" cellspacing="0" cellpadding="0" style="margin-top: 40px; width: 100%;">
                                <tr>
                                    <td align="center">
                                        <a href="javascript:;" style="background: linear-gradient(135deg, #ffd700, #b8860b); color: #000000; padding: 18px 50px; text-decoration: none; border-radius: 50px; font-family: Arial, sans-serif; font-size: 15px; font-weight: 900; display: inline-block; box-shadow: 0 10px 25px rgba(255, 215, 0, 0.4); text-transform: uppercase; letter-spacing: 1px;">
                                            Send Your Love 🎊
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <div style="margin-top: 30px;">
                                <span class="floating-icon" style="font-size: 25px; animation-delay: 0.8s;">✨</span>
                                <span class="floating-icon" style="font-size: 20px; animation-delay: 0.3s; margin-left: 10px;">🎈</span>
                            </div>
                        </div>

                        <div style="position: relative; z-index: 5;">
                            <p style="margin: 0; font-family: Arial, sans-serif; font-size: 12px; color: #ffffff; letter-spacing: 2px; font-weight: bold;">
                                © <?= date('Y') ?> SATISH CHANDRA MEMORIAL SCHOOL
                            </p>
                            <p style="margin: 8px 0 0; font-family: 'Georgia', serif; font-size: 13px; color: #ffffff; opacity: 0.7;">
                                Celebrating excellence, one birthday at a time.
                            </p>
                        </div>
                    </td>

                </tr>

                <!-- <tr>
                    <td style="background-color: #0a0a0a; padding: 35px; text-align: center; border-top: 1px solid #1e293b;">
                        <p style="margin: 0; font-family: Arial, sans-serif; font-size: 12px; color: #64748b; letter-spacing: 2px; font-weight: bold;">
                            © <?php // echo date('Y') ?> SATISH CHANDRA MEMORIAL SCHOOL
                        </p>
                        <p style="margin: 8px 0 0; font-family: 'Georgia', serif; font-size: 13px; color: #ffd700; opacity: 0.7;">
                            Celebrating excellence, one birthday at a time.
                        </p>
                    </td>
                </tr> -->
            </table>

        </td>
    </tr>
</table>

</body>
</html>