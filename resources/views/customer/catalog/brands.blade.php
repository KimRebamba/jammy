<!DOCTYPE html>
<html>
<head>
    <title>Shop - Brands</title>
</head>
<body>

<h2>Brands for {{ $category->category_name }}</h2>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Logo</th>
        <th>Brand</th>
        <th>Action</th>
    </tr>
    @foreach($brands as $brand)
        <tr>
            <td>
                @if($brand->logo_url)
                    <img src="{{ asset($brand->logo_url) }}" alt="{{ $brand->brand_name }}" width="80">
                @endif
            </td>
            <td>{{ $brand->brand_name }}</td>
            <td><a href="/shop/categories/{{ $category->category_id }}/brands/{{ $brand->brand_id }}">View Products</a></td>
        </tr>
    @endforeach
</table>

<p><a href="/shop">Back to Categories</a></p>
<p><a href="/customer/index">Back to Customer Home</a></p>

</body>
</html>
