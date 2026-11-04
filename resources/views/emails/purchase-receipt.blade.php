<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Receipt</title>
</head>

<body style="margin: 0;padding: 0;background-color: #f8f8f8;font-family: Arial, Helvetica, sans-serif;color: #333333;">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center">

            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                   style="background-color: #0d6efd;border-radius: 12px;">
                <tr>
                    <td align="center"
                        style="
                            background:#0071f8;
                            color:#ffffff;
                            padding:22px;
                            border-radius:12px;
                            font-size:22px;
                            font-weight:bold;
                        ">
                        PLAY GAMES NOW
                    </td>
                </tr>
            </table>

            <table width="570" cellpadding="0" cellspacing="0" border="0"
                   style="
                        margin: 25px 0;
                        background-color: #ffffff;
                        border: 1px solid #e5e5e5;
                        border-radius: 12px;
                   ">
                <tr>
                    <td style="padding: 32px;">

                        <h2 style="
                            margin-top: 0;
                            color: #111111;
                            font-size: 20px;
                        ">
                            Thank you for your purchase!
                        </h2>

                        <p style="line-height: 1.6;">
                            Hello {{ $sale->user->name }},
                        </p>

                        <p style="line-height: 1.6;">
                            Your order
                            <strong>#{{ $sale->id }}</strong>
                            was completed successfully.
                        </p>

                        <p style="line-height: 1.6;">
                            Your purchase receipt is attached to this email as a PDF.
                        </p>

                        <table width="100%" cellpadding="0" cellspacing="0"
                               style="
                                    margin: 25px 0;
                                    background-color: #f7f7f7;
                                    border-radius: 8px;
                               ">
                            <tr>
                                <td style="padding: 18px;">

                                    <p style="margin: 0 0 8px;">
                                        <strong>Order:</strong>
                                        #{{ $sale->id }}
                                    </p>

                                    <p style="margin: 0 0 8px;">
                                        <strong>Date:</strong>
                                        {{ $sale->created_at->format('d/m/Y H:i') }}
                                    </p>

                                    <p style="margin: 0 0 8px;">
                                        <strong>Payment Method:</strong>
                                        {{ ucfirst($sale->payment_method) }}
                                    </p>

                                    <p style="
                                        margin: 0;
                                        font-size: 18px;
                                    ">
                                        <strong>Total:</strong>
                                        {{ number_format($sale->total, 2) }}€
                                    </p>

                                </td>
                            </tr>
                        </table>

                        <p style="line-height: 1.6;">
                            You can also check your purchase details and game keys
                            in your Play Games Now account.
                        </p>

                        <p style="
                            margin-top: 30px;
                            line-height: 1.6;
                        ">
                            Regards,<br>
                            Play Games Now
                        </p>

                    </td>
                </tr>
            </table>

            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td align="center"
                        style="
                            padding: 15px 20px 30px;
                            color: #999999;
                            font-size: 12px;
                        ">
                        © {{ date('Y') }} Play Games Now. All rights reserved.
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>

</body>
</html>
