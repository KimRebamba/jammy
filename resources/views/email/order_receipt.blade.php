<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Receipt</title>
</head>
<body>
    <p>{{ $emailMessage }}</p>

    <p><strong>Order #{{ $order->order_id }}</strong></p>
    <p>Date: {{ $order->date_ordered ?? $order->created_at }}</p>
    <p>Payment Status: {{ $order->payment_status }}</p>
    <p>Order Status: {{ $order->order_status }}</p>

    <p>The PDF receipt with full details is attached.</p>
</body>
</html>
