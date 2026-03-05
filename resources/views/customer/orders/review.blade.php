<!DOCTYPE html>
<html>
<head>
    <title>Create Review</title>
</head>
<body>

<h2>Create Review for Order #{{ $order->order_id }}</h2>

@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif
@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
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

<form action="/orders/{{ $order->order_id }}/review" method="post">
    @csrf
    <p>
        <label>Product:</label>
        <select name="product_order_id">
            @foreach($items as $item)
                <option value="{{ $item->product_order_id }}" @if(old('product_order_id') == $item->product_order_id) selected @endif>
                    {{ $item->product_name }} x{{ $item->quantity }}
                </option>
            @endforeach
        </select>
    </p>
    <p>
        <label>Rating (1-5):</label>
        <input type="text" name="rating" value="{{ old('rating') }}">
    </p>
    <p>
        <label>Title:</label>
        <input type="text" name="review_title" value="{{ old('review_title') }}">
    </p>
    <p>
        <label>Review:</label>
        <textarea name="review_text" rows="4" cols="40">{{ old('review_text') }}</textarea>
    </p>
    <p>
        <button type="submit">Save Review</button>
    </p>
</form>

<p><a href="/orders">Back to Orders</a></p>
<p><a href="/customer/index">Back to Customer Home</a></p>

</body>
</html>
