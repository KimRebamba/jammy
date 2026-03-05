<!DOCTYPE html>
<html>
<head>
    <title>Product Details</title>
</head>
<body>

<h2>{{ $product->product_name }}</h2>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif
@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif

@if($product->primary_photo)
    <p><img src="{{ asset($product->primary_photo) }}" alt="{{ $product->product_name }}" width="200"></p>
@endif

<p><strong>Brand:</strong> {{ $product->brand_name }}</p>
<p><strong>Category:</strong> {{ $product->category_name }}</p>
<p><strong>Model:</strong> {{ $product->model }}</p>
<p><strong>Price:</strong> {{ number_format($product->retail_price, 2) }}</p>
<p><strong>Description:</strong> {{ $product->description }}</p>
<p><strong>Stock Level:</strong> {{ $product->stock_level }}</p>

<form action="/cart/add/{{ $product->product_id }}" method="post">
    @csrf
    <input type="hidden" name="quantity" value="1">
    <p>
        <button type="submit">Add to Cart</button>
    </p>
</form>

<h3>All Photos</h3>
@if(count($photos) > 0)
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Image</th>
            <th>Primary</th>
            <th>Sort Order</th>
        </tr>
        @foreach($photos as $photo)
            <tr>
                <td><img src="{{ asset($photo->photo_url) }}" alt="{{ $product->product_name }}" width="100"></td>
                <td>{{ $photo->is_primary ? 'Yes' : 'No' }}</td>
                <td>{{ $photo->sort_order }}</td>
            </tr>
        @endforeach
    </table>
@else
    <p>No additional photos.</p>
@endif

<p><a href="/shop/categories/{{ $product->category_id }}/brands/{{ $product->brand_id }}">Back to Products</a></p>
<p><a href="/shop">Back to Categories</a></p>
<p><a href="/customer/index">Back to Customer Home</a></p>

</body>
</html>
