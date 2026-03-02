<!DOCTYPE html>
<html>
<head>
    <title>Edit Order</title>
</head>
<body>

<h2>Edit Order</h2>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
@if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

@if($errors->any())
    <ul style="color:red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="/admin/orders/{{ $order->order_id }}/update" method="post">
    @csrf
    <p>Payment Status:
        <select name="payment_status">
            <option value="pending" {{ old('payment_status', $order->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="paid" {{ old('payment_status', $order->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
            <option value="refunded" {{ old('payment_status', $order->payment_status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
        </select>
    </p>
    <p>Order Status:
        <select name="order_status">
            <option value="pending" {{ old('order_status', $order->order_status) == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ old('order_status', $order->order_status) == 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="shipped" {{ old('order_status', $order->order_status) == 'shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="completed" {{ old('order_status', $order->order_status) == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ old('order_status', $order->order_status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            <option value="requested_refund" {{ old('order_status', $order->order_status) == 'requested_refund' ? 'selected' : '' }}>Requested Refund</option>
            <option value="returned" {{ old('order_status', $order->order_status) == 'returned' ? 'selected' : '' }}>Returned</option>
        </select>
    </p>
    <p>Payment Option: <input type="text" name="payment_option" value="{{ old('payment_option', $order->payment_option) }}"></p>
    <p>Delivery Fee: <input type="text" name="delivery_fee" value="{{ old('delivery_fee', $order->delivery_fee) }}"></p>

    <p><button type="submit">Save Changes</button></p>
</form>

<p><a href="/admin/orders">Back to Orders</a></p>

</body>
</html>
