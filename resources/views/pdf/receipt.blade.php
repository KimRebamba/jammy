<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Receipt</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        h2, h3 { margin-bottom: 6px; }
    </style>
</head>
<body>
    <h2>Order Receipt</h2>

    <h3>Customer</h3>
    <p>
        {{ $customer->first_name }} {{ $customer->last_name }}<br>
        Username: {{ $customer->username }}<br>
        Email: {{ $customer->email }}<br>
        Address: {{ $customer->address }}<br>
        Phone: {{ $customer->phone_number }}
    </p>

    <h3>Order</h3>
    <p>
        Order #: {{ $order->order_id }}<br>
        Date: {{ $order->date_ordered ?? $order->created_at }}<br>
        Payment Status: {{ $order->payment_status }}<br>
        Order Status: {{ $order->order_status }}<br>
        Payment Option: {{ $order->payment_option }}<br>
        Delivery Fee: {{ number_format($order->delivery_fee, 2) }}
    </p>

    <h3>Items</h3>
    <table>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Line Total</th>
        </tr>
        @php $grandTotal = 0; @endphp
        @foreach($items as $item)
            @php
                $lineTotal = $item->quantity * $item->unit_price;
                $grandTotal += $lineTotal;
            @endphp
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->unit_price, 2) }}</td>
                <td>{{ number_format($lineTotal, 2) }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="3" style="text-align:right;">Subtotal</th>
            <td>{{ number_format($grandTotal, 2) }}</td>
        </tr>
        <tr>
            <th colspan="3" style="text-align:right;">Delivery Fee</th>
            <td>{{ number_format($order->delivery_fee, 2) }}</td>
        </tr>
        <tr>
            <th colspan="3" style="text-align:right;">Total</th>
            <td>{{ number_format($grandTotal + $order->delivery_fee, 2) }}</td>
        </tr>
    </table>
</body>
</html>
