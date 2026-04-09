<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Email Verification' }}</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
</head>
<body style="margin:0; padding:0; background-color:#f8f9fa; font-family:'Open Sans', sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8f9fa; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="500" cellpadding="0" cellspacing="0" style="background:white; border-radius:12px; overflow:hidden; box-shadow:0 6px 20px rgba(0,0,0,.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(310deg, #141727 0%, #3A416F 100%); padding:40px; text-align:center; color:white;">
                            <h1 style="margin:0; font-size:28px;">BloodConnect</h1>
                            <p style="margin:5px 0 0; font-size:14px; opacity:.8;">Bringing lives closer together</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:35px 40px; color:#344767; font-size:15px;">
                            <p style="margin-top:0;">Hello {{ $user->name ?? 'User' }},</p>

                            <p>Thank you for registering with <strong>BloodConnect</strong>.</p>

                            @isset($user->otp)
                            <p style="margin: 25px 0; font-size:18px; text-align:center;">
                                <strong>Your One-Time Password (OTP):</strong>
                            </p>

                            <div style="text-align:center; margin-bottom:30px;">
                                <span style="background:#3A416F; color:white; padding:12px 25px; border-radius:8px; font-size:22px; letter-spacing:3px; display:inline-block;">
                                    {{ $user->otp }}
                                </span>
                            </div>
                            @endisset

                            <p>This code is valid for <strong>10 minutes</strong>. If you did not request this, please ignore this email.</p>

                            <p style="margin-top:30px;">Best regards,<br><strong>BloodConnect Team</strong></p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f0f2f5; padding:18px; text-align:center; color:#7b809a; font-size:12px;">
                            © {{ date('Y') }} BloodConnect. All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
