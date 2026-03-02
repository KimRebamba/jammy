<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
</head>
<body>

<h2>Edit Category</h2>

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

<form action="/admin/categories/{{ $category->category_id }}/update" method="post" enctype="multipart/form-data">
    @csrf
    <p>Name: <input type="text" name="category_name" value="{{ old('category_name', $category->category_name) }}"></p>
    <p>Photo (800x800): <input type="file" name="photo_url"></p>
    <p>Description:<br>
        <textarea name="description" rows="4" cols="50">{{ old('description', $category->description) }}</textarea>
    </p>
    <p>Active: <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}></p>

    <p><button type="submit">Save Changes</button></p>
</form>

<p><a href="/admin/categories">Back to Categories</a></p>

</body>
</html>
