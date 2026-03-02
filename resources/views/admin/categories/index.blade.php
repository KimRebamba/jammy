<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
</head>
<body>

    <h2>Categories</h2>

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

<p><a href="/admin/categories/create">Add Category</a></p>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Image</th>
    <th>Category</th>
    <th>Active</th>
    <th>Actions</th>
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
    <td>
        <a href="/admin/categories/{{ $category->ID }}">View</a> |
        <a href="/admin/categories/{{ $category->ID }}/edit">Edit</a> |
        <form action="/admin/categories/{{ $category->ID }}/delete" method="post" style="display:inline;">
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
