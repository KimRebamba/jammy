<!DOCTYPE html>
<html>
<head>
    <title>My Cart</title>
</head>
<body>

<h2>My Cart</h2>

@if(!$cart)
    <p>Your cart is empty.</p>
@else
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
        @php $total = 0; @endphp
        @foreach($items as $item)
            @php $subtotal = $item->quantity * $item->retail_price; $total += $subtotal; @endphp
            <tr>
                <td>
                    @if($item->photo_url)
                        <img src="{{ asset($item->photo_url) }}" alt="{{ $item->product_name }}" width="80">
                    @endif
                </td>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->retail_price, 2) }}</td>
                <td>{{ number_format($subtotal, 2) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4" align="right"><strong>Total:</strong></td>
            <td>{{ number_format($total, 2) }}</td>
        </tr>
    </table>

    <p>(Checkout and cart updates will be implemented later.)</p>
@endif

<p><a href="/customer/index">Back to Customer Home</a></p>

</body>
</html>
