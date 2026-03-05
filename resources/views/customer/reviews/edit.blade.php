<!DOCTYPE html>
<html>
<head>
    <title>Edit Review</title>
</head>
<body>

<h2>Edit Review for {{ $review->product_name }}</h2>

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

<form action="/reviews/{{ $review->review_id }}/update" method="post">
    @csrf
    <p>
        <label>Rating (1-5):</label>
        <input type="text" name="rating" value="{{ old('rating', $review->rating) }}">
    </p>
    <p>
        <label>Title:</label>
        <input type="text" name="review_title" value="{{ old('review_title', $review->review_title) }}">
    </p>
    <p>
        <label>Review:</label>
        <textarea name="review_text" rows="4" cols="40">{{ old('review_text', $review->review_text) }}</textarea>
    </p>
    <p>
        <button type="submit">Save</button>
    </p>
</form>

<p><a href="/reviews">Back to Reviews</a></p>

</body>
</html>
