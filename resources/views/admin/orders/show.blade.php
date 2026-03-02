<!DOCTYPE html>
<html>
<head>
    <title>View Order</title>
</head>
<body>

<h2>Order Details</h2>

<p>ID: {{ $order->order_id }}</p>
<p>Customer: {{ $order->username }}</p>
<p>Payment Status: {{ $order->payment_status }}</p>
<p>Order Status: {{ $order->order_status }}</p>
<p>Payment Option: {{ $order->payment_option }}</p>
<p>Delivery Fee: {{ $order->delivery_fee }}</p>
<p>Date Ordered: {{ $order->date_ordered }}</p>
<p>Completed At: {{ $order->completed_at }}</p>

<h3>Items</h3>
<table border="1" cellpadding="5">
    <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th>Unit Price</th>
    </tr>
    @foreach($items as $item)
    <tr>
        <td>{{ $item->product_name }}</td>
        <td>{{ $item->quantity }}</td>
        <td>{{ $item->unit_price }}</td>
    </tr>
    @endforeach
</table>

<p><a href="/admin/orders/{{ $order->order_id }}/edit">Edit</a></p>
<p><a href="/admin/orders">Back to Orders</a></p>

</body>
</html>
