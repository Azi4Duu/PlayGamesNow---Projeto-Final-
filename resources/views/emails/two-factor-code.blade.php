<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Authentication Code</title>
</head>

<body style="margin:0; padding:0; background:#fafafa; font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#fafafa; padding:30px 0;">
    <tr>
        <td align="center">

            <table width="570" cellpadding="0" cellspacing="0" style="width:570px; max-width:90%;">

                <tr>
                    <td
                        align="center"
                        style="
                            background:#0071f8;
                            color:#ffffff;
                            padding:22px;
                            border-radius:12px;
                            font-size:22px;
                            font-weight:bold;
                        "
                    >
                        Play Games Now
                    </td>
                </tr>

                <tr>
                    <td style="height:24px;"></td>
                </tr>

                <tr>
                    <td
                        style="
                            background:#ffffff;
                            padding:32px;
                            border:1px solid #e4e4e7;
                            border-radius:12px;
                        "
                    >

                        <h2 style="margin-top:0; color:#111827;">
                            Two-Factor Authentication
                        </h2>

                        <p style="color:#52525b; font-size:16px;">
                            Use the following code to complete your login:
                        </p>

                        <div
                            style="
                                text-align:center;
                                margin:30px 0;
                            "
                        >
                            <span
                                style="
                                    display:inline-block;
                                    background:#f3f4f6;
                                    padding:16px 30px;
                                    border-radius:10px;
                                    font-size:28px;
                                    font-weight:bold;
                                    letter-spacing:6px;
                                    color:#111827;
                                "
                            >
                                {{ $code }}
                            </span>
                        </div>

                        <p style="color:#52525b; font-size:14px;">
                            This code will expire shortly.
                        </p>

                        <p style="color:#52525b; font-size:14px; margin-bottom:0;">
                            If you did not attempt to log in, you can ignore this email.
                        </p>

                    </td>
                </tr>

                <tr>
                    <td
                        align="center"
                        style="
                            padding-top:28px;
                            color:#a1a1aa;
                            font-size:12px;
                        "
                    >
                        © {{ date('Y') }} Play Games Now. All rights reserved.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
