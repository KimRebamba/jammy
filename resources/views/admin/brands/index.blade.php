<!DOCTYPE html>
<html>
<head>
    <title>Brands</title>
</head>
<body>

<h2>Brands</h2>

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

<p><a href="/admin/brands/create">Add Brand</a></p>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Logo</th>
    <th>Brand</th>
    <th>Website</th>
    <th>Active</th>
    <th>Actions</th>
</tr>

@foreach($brands as $brand)
<tr>
    <td>{{ $brand->ID }}</td>
    <td>
        @if($brand->Logo)
            <img src="{{ asset($brand->Logo) }}" width="80">
        @endif
    </td>
    <td>{{ $brand->Brand }}</td>
    <td>{{ $brand->Website }}</td>
    <td>{{ $brand->Active ? 'Yes' : 'No' }}</td>
    <td>
        <a href="/admin/brands/{{ $brand->ID }}">View</a> |
        <a href="/admin/brands/{{ $brand->ID }}/edit">Edit</a> |
        <form action="/admin/brands/{{ $brand->ID }}/delete" method="post" style="display:inline;">
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
