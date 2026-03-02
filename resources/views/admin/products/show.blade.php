<!DOCTYPE html>
<html>
<head>
    <title>View Product</title>
</head>
<body>

<h2>Product Details</h2>

@if($product->primary_photo)
    <p><img src="{{ asset($product->primary_photo) }}" width="200"></p>
@endif

<p>ID: {{ $product->product_id }}</p>
<p>Name: {{ $product->product_name }}</p>
<p>Brand: {{ $product->brand_name }}</p>
<p>Category: {{ $product->category_name }}</p>
<p>Model: {{ $product->model }}</p>
<p>Retail Price: {{ $product->retail_price }}</p>
<p>Cost Price: {{ $product->cost_price }}</p>
<p>Description: {{ $product->description }}</p>
<p>Stock Level: {{ $product->stock_level }}</p>
<p>Active: {{ $product->is_active ? 'Yes' : 'No' }}</p>

<p><a href="/admin/products/{{ $product->product_id }}/edit">Edit</a></p>
<p><a href="/admin/products">Back to Products</a></p>

</body>
</html>
