<!DOCTYPE html>
<html>
<head>
    <title>Shop - Products</title>
</head>
<body>

<h2>Products for {{ $brand->brand_name }} in {{ $category->category_name }}</h2>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif
@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Image</th>
        <th>Product</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>
    @foreach($products as $product)
        <tr>
            <td>
                @if($product->photo_url)
                    <img src="{{ asset($product->photo_url) }}" alt="{{ $product->product_name }}" width="80">
                @endif
            </td>
            <td>{{ $product->product_name }}</td>
            <td>{{ number_format($product->retail_price, 2) }}</td>
            <td>
                <a href="/shop/products/{{ $product->product_id }}">View</a>
                |
                <form action="/cart/add/{{ $product->product_id }}" method="post" style="display:inline;">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit">Add to Cart</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

<p><a href="/shop/categories/{{ $category->category_id }}">Back to Brands</a></p>
<p><a href="/customer/index">Back to Customer Home</a></p>

</body>
</html>
