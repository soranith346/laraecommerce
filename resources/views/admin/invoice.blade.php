<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; font-size: 13px; }
        .header-table { width: 100%; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .info-table { width: 100%; margin-top: 20px; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        .items-table th { background: #f2f2f2; padding: 10px; border: 1px solid #ddd; text-align: left; }
        .items-table td { padding: 10px; border: 1px solid #ddd; }
        .total-box { float: right; width: 30%; margin-top: 20px; }
        .badge { padding: 5px 10px; background: #fff3cd; color: #856404; border-radius: 5px; font-weight: bold; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #777; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td>
                <h1 style="margin:0; color: #2d3748;">INVOICE</h1>
                <p style="margin:5px 0;">Order ID: <strong>#{{ $data->id }}</strong></p>
            </div>
            <td style="text-align: right; vertical-align: bottom;">
                <span class="badge">{{ strtoupper($data->status) }}</span>
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td width="50%">
                <strong style="color: #718096; text-transform: uppercase; font-size: 11px;">Billed To:</strong><br>
                <strong>{{ $data->user->name }}</strong><br>
                Email: {{ $data->user->email }}<br>
                User ID: {{ $data->user_id }}
            </td>
            <td width="50%" style="text-align: right;">
                <strong style="color: #718096; text-transform: uppercase; font-size: 11px;">Ship To:</strong><br>
                Address: {{ $data->receiver_address }}<br>
                Phone: {{ $data->receiver_phone }}<br>
                Date: {{ \Carbon\Carbon::parse($data->created_at)->format('d F Y') }}
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>Product Image</th>
                <th>Product Detail</th>
                <th style="text-align: center;">Quantity</th>
                <th style="text-align: right;">Price</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data->items as $item)
            <tr>
                <td style="text-align: center; width: 70px;">
                    <img src="{{ public_path('uploads/'.$item->product->image) }}" width="50" height="50" style="object-fit: cover;">
                </td>
                <td>
                    <strong>{{ $item->product->product_name }}</strong><br>
                    <small>Category: {{ $item->product->category }}</small>
                </td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td style="text-align: right;">${{ number_format($item->price, 2) }}</td>
                <td style="text-align: right;">${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        <table width="100%">
            <tr>
                <td style="padding: 5px 0;">Subtotal:</td>
                <td style="text-align: right;">${{ number_format($data->total_amount, 2) }}</td>
            </tr>
            <tr style="font-size: 16px; font-weight: bold; color: #2d3748;">
                <td style="padding: 10px 0; border-top: 2px solid #eee;">TOTAL:</td>
                <td style="text-align: right; border-top: 2px solid #eee;">${{ number_format($data->total_amount, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Generated on {{ date('Y-m-d H:i:s') }} | Thank you for your purchase!
    </div>

</body>
</html>