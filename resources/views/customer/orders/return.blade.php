<!DOCTYPE html>
<html>
<head>
    <title>Request Return</title>
</head>
<body>

<h2>Request Return for Order #{{ $order->order_id }}</h2>

@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif
@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<p><strong>Status:</strong> {{ $order->order_status }}</p>

<h3>Items</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Product</th>
        <th>Quantity</th>
    </tr>
    @foreach($items as $item)
        <tr>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->quantity }}</td>
        </tr>
    @endforeach
</table>

<h3>Return Details</h3>
<form action="/orders/{{ $order->order_id }}/return" method="post">
    @csrf
    <p>
        <label>Reason:</label>
        <input type="text" name="reason" value="{{ old('reason') }}">
    </p>
    <p>
        <label>Condition:</label>
        <select name="cond">
            @foreach($conditions as $cond)
                <option value="{{ $cond }}" @if(old('cond') === $cond) selected @endif>{{ ucfirst($cond) }}</option>
            @endforeach
        </select>
    </p>
    <p>
        <button type="submit">Submit Return Request</button>
    </p>
</form>

<p><a href="/orders">Back to Orders</a></p>
<p><a href="/customer/index">Back to Customer Home</a></p>

</body>
</html>
