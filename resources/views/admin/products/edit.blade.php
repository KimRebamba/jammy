<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>

<h2>Edit Product</h2>

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

<form action="/admin/products/{{ $product->product_id }}/update" method="post" enctype="multipart/form-data">
    @csrf
    <p>Name: <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}"></p>
    <p>Brand:
        <select name="brand_id">
            <option value="">-- none --</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->brand_id }}" {{ old('brand_id', $product->brand_id) == $brand->brand_id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
            @endforeach
        </select>
    </p>
    <p>Category:
        <select name="category_id">
            <option value="">-- none --</option>
            @foreach($categories as $category)
                <option value="{{ $category->category_id }}" {{ old('category_id', $product->category_id) == $category->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
            @endforeach
        </select>
    </p>
    <p>Model: <input type="text" name="model" value="{{ old('model', $product->model) }}"></p>
    <p>Retail Price: <input type="text" name="retail_price" value="{{ old('retail_price', $product->retail_price) }}"></p>
    <p>Cost Price: <input type="text" name="cost_price" value="{{ old('cost_price', $product->cost_price) }}"></p>
    <p>Description:<br>
        <textarea name="description" rows="4" cols="50">{{ old('description', $product->description) }}</textarea>
    </p>
    <p>Stock Level: <input type="text" name="stock_level" value="{{ old('stock_level', $product->stock_level) }}"></p>
    <p>Primary Photo (800x800):
        <input type="file" name="photo_url">
    </p>
    <p>Active: <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}></p>

    <p><button type="submit">Save Changes</button></p>
</form>

<p><a href="/admin/products">Back to Products</a></p>

</body>
</html>
