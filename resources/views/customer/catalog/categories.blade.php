<!DOCTYPE html>
<html>
<head>
    <title>Shop - Categories</title>
</head>
<body>

<h2>Categories</h2>

@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Image</th>
        <th>Category</th>
        <th>Action</th>
    </tr>
    @foreach($categories as $category)
        <tr>
            <td>
                @if($category->photo_url)
                    <img src="{{ asset($category->photo_url) }}" alt="{{ $category->category_name }}" width="80">
                @endif
            </td>
            <td>{{ $category->category_name }}</td>
            <td><a href="/shop/categories/{{ $category->category_id }}">View Brands</a></td>
        </tr>
    @endforeach
</table>

<p><a href="/customer/index">Back to Customer Home</a></p>

</body>
</html>
