<!DOCTYPE html>
<html>
<head>
    <title>My Cart</title>
</head>
<body>

<h2>My Cart</h2>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif
@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif

@if(!$cart)
    <p>Your cart is empty.</p>
@else
    @if(count($items) === 0)
        <p>Your cart is empty.</p>
    @else
        <form id="buy-form" action="/cart/buy" method="post">
            @csrf
        </form>

        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Select</th>
                <th>Image</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
                <th>Actions</th>
            </tr>
            @php $total = 0; @endphp
            
            @foreach($items as $item)
                @php $subtotal = $item->quantity * $item->retail_price; $total += $subtotal; @endphp
                <tr>
                    <td>
                        <input type="checkbox" name="items[]" value="{{ $item->cart_product_id }}" form="buy-form">
                    </td>
                    <td>
                        @if($item->photo_url)
                            <img src="{{ asset($item->photo_url) }}" alt="{{ $item->product_name }}" width="80">
                        @endif
                    </td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->retail_price, 2) }}</td>
                    <td>{{ number_format($subtotal, 2) }}</td>
                    <td>
                        <form action="/cart/item/{{ $item->cart_product_id }}/up" method="post" style="display:inline;">
                            @csrf
                            <button type="submit">Up</button>
                        </form>
                        <form action="/cart/item/{{ $item->cart_product_id }}/down" method="post" style="display:inline; margin-left:5px;">
                            @csrf
                            <button type="submit">Down</button>
                        </form>
                        <form action="/cart/item/{{ $item->cart_product_id }}/delete" method="post" style="display:inline; margin-left:5px;">
                            @csrf
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" align="right"><strong>Total:</strong></td>
                <td>{{ number_format($total, 2) }}</td>
                <td></td>
            </tr>
        </table>

        <p>
            <button type="submit" form="buy-form">Buy Selected</button>
        </p>
    @endif
@endif

<p><a href="/customer/index">Back to Customer Home</a></p>

</body>
</html>
