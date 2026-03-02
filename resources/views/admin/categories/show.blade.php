<!DOCTYPE html>
<html>
<head>
    <title>View Category</title>
</head>
<body>

<h2>Category Details</h2>

@if($category->photo_url)
    <p><img src="{{ asset($category->photo_url) }}" width="200"></p>
@endif

<p>ID: {{ $category->category_id }}</p>
<p>Name: {{ $category->category_name }}</p>
<p>Description: {{ $category->description }}</p>
<p>Active: {{ $category->is_active ? 'Yes' : 'No' }}</p>

<p><a href="/admin/categories/{{ $category->category_id }}/edit">Edit</a></p>
<p><a href="/admin/categories">Back to Categories</a></p>

</body>
</html>
