<!DOCTYPE html>
<html>
<head>
    <title>Replace Product Photo</title>
</head>
<body>
    <h1>Replace Product Photo</h1>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div>{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p>
        <a href="/admin/products/{{ $product->product_id }}/edit">Back to Edit Product</a>
    </p>

    <h3>Current Photo</h3>
    <p>
        <img src="{{ asset($photo->photo_url) }}" width="200">
    </p>

    <form action="/admin/products/{{ $product->product_id }}/photos/{{ $photo->product_photo_id }}/replace" method="post" enctype="multipart/form-data">
        @csrf
        <p>
            <label>New Photo:</label>
            <input type="file" name="photo_file">
        </p>
        <p>
            <button type="submit">Replace</button>
        </p>
    </form>
</body>
</html>
