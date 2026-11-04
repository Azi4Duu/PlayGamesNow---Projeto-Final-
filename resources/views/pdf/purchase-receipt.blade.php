<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333333;
            font-size: 13px;
        }

        .header {
            background-color: #0d6efd;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .title {
            margin-top: 30px;
            font-size: 22px;
            color: #111111;
        }

        .details {
            margin-top: 20px;
            background-color: #f5f5f5;
            padding: 15px;
        }

        .details p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th {
            background-color: #0d6efd;
            color: #ffffff;
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #dddddd;
        }

        .keys {
            font-size: 11px;
            color: #555555;
            margin-top: 4px;
        }

        .summary {
            margin-top: 25px;
            text-align: right;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
            color: #111111;
        }

        .footer {
            margin-top: 45px;
            padding-top: 15px;
            border-top: 1px solid #dddddd;
            text-align: center;
            color: #888888;
            font-size: 10px;
        }
    </style>
</head>

<body>

<div class="header">
    <h1>PLAY GAMES NOW</h1>
</div>

<h2 class="title">Purchase Receipt</h2>

<div class="details">

    <p>
        <strong>Order:</strong>
        #{{ $sale->id }}
    </p>

    <p>
        <strong>Date:</strong>
        {{ $sale->created_at->format('d/m/Y H:i') }}
    </p>

    <p>
        <strong>Customer:</strong>
        {{ $sale->user->name }}
    </p>

    <p>
        <strong>Email:</strong>
        {{ $sale->user->email }}
    </p>

    <p>
        <strong>Payment Method:</strong>
        {{ ucfirst($sale->payment_method) }}
    </p>

</div>

<table>

    <thead>
    <tr>
        <th>Game</th>
        <th>Platform</th>
        <th>Qty.</th>
        <th>Unit Price</th>
        <th>Total</th>
    </tr>
    </thead>

    <tbody>

    @foreach($sale->items as $item)

        <tr>

            <td>
                {{ $item->gamePlatform->game->title }}
            </td>

            <td>
                {{ $item->gamePlatform->platform->platform_name }}
            </td>

            <td>
                {{ $item->quantity }}
            </td>

            <td>
                {{ number_format($item->unit_price, 2) }}€
            </td>

            <td>
                {{ number_format($item->unit_price * $item->quantity, 2) }}€
            </td>

        </tr>

    @endforeach

    </tbody>

</table>

<div class="summary">

    <p>
        Subtotal:
        {{ number_format($sale->subtotal, 2) }}€
    </p>

    @if($sale->discount > 0)
        <p>
            Discount:
            -{{ number_format($sale->discount, 2) }}€
        </p>
    @endif

    <p class="total">
        Total:
        {{ number_format($sale->total, 2) }}€
    </p>

</div>

<div class="footer">

    <p>
        © {{ date('Y') }} Play Games Now. All rights reserved.
    </p>
</div>

</body>
</html>
