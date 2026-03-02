<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
</head>
<body>
<h2>Products</h2>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Image</th>
    <th>Product</th>
    <th>Brand</th>
    <th>Category</th>
    <th>Price</th>
    <th>Stock</th>
</tr>

@foreach($products as $product)
<tr>
    <td>{{ $product->ID }}</td>
    <td>
        @if($product->Image)
            <img src="{{ asset($product->Image) }}" width="80">
        @endif
    </td>
    <td>{{ $product->Product }}</td>
    <td>{{ $product->Brand }}</td>
    <td>{{ $product->Category }}</td>
    <td>{{ $product->Price }}</td>
    <td>{{ $product->Stock }}</td>
</tr>
@endforeach
</table>

<br>
<a href="/admin/dashboard">Back</a>

</body>
</html>