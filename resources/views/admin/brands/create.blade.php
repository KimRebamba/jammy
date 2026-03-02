<!DOCTYPE html>
<html>
<head>
    <title>Add Brand</title>
</head>
<body>

<h2>Add Brand</h2>

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

<form action="/admin/brands" method="post" enctype="multipart/form-data">
    @csrf
    <p>Name: <input type="text" name="brand_name" value="{{ old('brand_name') }}"></p>
    <p>Logo (800x800): <input type="file" name="logo_url"></p>
    <p>Website: <input type="text" name="website" value="{{ old('website') }}"></p>
    <p>Description:<br>
        <textarea name="description" rows="4" cols="50">{{ old('description') }}</textarea>
    </p>
    <p>Active: <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}></p>

    <p><button type="submit">Save</button></p>
</form>

<p><a href="/admin/brands">Back to Brands</a></p>

</body>
</html>
