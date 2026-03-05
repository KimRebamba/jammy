<!DOCTYPE html>
<html>
<head>
    <title>Confirm Order</title>
</head>
<body>

<h2>Confirm Order</h2>

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

<h3>Customer Information</h3>
@if($account)
    <p><strong>Name:</strong> {{ $account->first_name }} {{ $account->last_name }}</p>
    <p><strong>Address:</strong> {{ $account->address }}</p>
    <p><strong>Phone:</strong> {{ $account->phone_number }}</p>
    <p><strong>Email:</strong> {{ $account->email }}</p>
@endif

<h2>Delivery Fee: 50.00</h2>
<h3>Selected Products</h3>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
    </tr>

    @php $total = 0; @endphp
    @foreach($items as $item)
    @php $subtotal = $item->quantity * $item->retail_price; $total += $subtotal; @endphp
        <tr>
            <td>{{ $item->product_name }}</td>
            <td>{{ number_format($item->retail_price, 2) }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->quantity * $item->retail_price, 2) }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="3">Total:</td>
        <td>{{ number_format($total, 2) }}</td>
    </tr>
</table>

<h3>Payment Option</h3>
<form action="/cart/buy/confirm" method="post">
    @csrf
    @foreach($items as $item)
        <input type="hidden" name="items[]" value="{{ $item->cart_product_id }}">
    @endforeach
    <p>
        <select name="payment_option">
            @foreach($paymentOptions as $option)
                <option value="{{ $option }}">{{ $option }}</option>
            @endforeach
        </select>
    </p>
    <p>
        <button type="submit">Confirm Order</button>
    </p>
</form>

<p><a href="/cart">Back to Cart</a></p>

</body>
</html>
