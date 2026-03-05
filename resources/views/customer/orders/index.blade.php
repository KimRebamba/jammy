<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
</head>
<body>

<h2>My Orders</h2>

@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Payment</th>
        <th>Status</th>
        <th>Items</th>
        <th>Actions</th>
    </tr>
    @foreach($orders as $order)
        <tr>
            <td>{{ $order->order_id }}</td>
            <td>{{ $order->date_ordered }}</td>
            <td>{{ $order->payment_status }}</td>
            <td>{{ $order->order_status }}</td>
            <td>{{ $order->items }}</td>
            <td>
                <a href="/orders/{{ $order->order_id }}">View</a>
                @if($order->order_status !== 'completed' && $order->order_status !== 'cancelled' && $order->order_status !== 'returned')
                    | <a href="#">Return</a>
                    | <a href="#">Cancel</a>
                @endif
                @if($order->order_status === 'completed')
                    | <a href="#">Review</a>
                @endif
            </td>
        </tr>
    @endforeach
</table>

<p><a href="/customer/index">Back to Customer Home</a></p>

</body>
</html>
