<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
</head>
<body>
<h2>Products</h2>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
@if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

@if($errors->any())
    <ul style="color:red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<p><a href="/admin/products/create">Add Product</a></p>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Image</th>
    <th>Product</th>
    <th>Brand</th>
    <th>Category</th>
    <th>Price</th>
    <th>Stock</th>
    <th>Actions</th>
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
    <td>
        <a href="/admin/products/{{ $product->ID }}">View</a> |
        <a href="/admin/products/{{ $product->ID }}/edit">Edit</a> |
        <form action="/admin/products/{{ $product->ID }}/delete" method="post" style="display:inline;">
            @csrf
            <button type="submit">Delete</button>
        </form>
    </td>
</tr>
@endforeach
</table>

<br>
<a href="/admin/dashboard">Back</a>

</body>
</html>
