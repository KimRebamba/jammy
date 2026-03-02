<!DOCTYPE html>
<html>
<head>
    <title>View Brand</title>
</head>
<body>

<h2>Brand Details</h2>

@if($brand->logo_url)
    <p><img src="{{ asset($brand->logo_url) }}" width="200"></p>
@endif

<p>ID: {{ $brand->brand_id }}</p>
<p>Name: {{ $brand->brand_name }}</p>
<p>Website: {{ $brand->website }}</p>
<p>Description: {{ $brand->description }}</p>
<p>Active: {{ $brand->is_active ? 'Yes' : 'No' }}</p>

<p><a href="/admin/brands/{{ $brand->brand_id }}/edit">Edit</a></p>
<p><a href="/admin/brands">Back to Brands</a></p>

</body>
</html>
