<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
</head>
<body>

<h2>Order #{{ $order->order_id }}</h2>

<p><strong>Date:</strong> {{ $order->date_ordered }}</p>
<p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>
<p><strong>Order Status:</strong> {{ $order->order_status }}</p>
<p><strong>Delivery Fee:</strong> {{ number_format($order->delivery_fee, 2) }}</p>

<h3>Items</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Image</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Unit Price</th>
    </tr>
    @foreach($items as $item)
        <tr>
            <td>
                @if($item->photo_url)
                    <img src="{{ asset($item->photo_url) }}" alt="{{ $item->product_name }}" width="80">
                @endif
            </td>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->unit_price, 2) }}</td>
        </tr>
    @endforeach
</table>

<p><a href="/orders">Back to Orders</a></p>
<p><a href="/customer/index">Back to Customer Home</a></p>

</body>
</html>
