<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
</head>
<body>

    <h2>Categories</h2>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Image</th>
    <th>Category</th>
    <th>Active</th>
</tr>

@foreach($categories as $category)
<tr>
    <td>{{ $category->ID }}</td>
    <td>
        @if($category->Image)
            <img src="{{ asset($category->Image) }}" width="80">
        @endif
    </td>
    <td>{{ $category->Category }}</td>
    <td>{{ $category->Active ? 'Yes' : 'No' }}</td>
</tr>
@endforeach
</table>

<br>

<a href="/admin/dashboard">Back</a>
</body>

</html>