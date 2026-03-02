<!DOCTYPE html>
<html>
<head>
    <title>View Review</title>
</head>
<body>

<h2>Review Details</h2>

<p>ID: {{ $review->review_id }}</p>
<p>Customer: {{ $review->username }}</p>
<p>Product: {{ $review->product_name }}</p>
<p>Rating: {{ $review->rating }}</p>
<p>Title: {{ $review->review_title }}</p>
<p>Text: {{ $review->review_text }}</p>
<p>Verified: {{ $review->is_verified ? 'Yes' : 'No' }}</p>

<p><a href="/admin/reviews/{{ $review->review_id }}/edit">Edit</a></p>
<p><a href="/admin/reviews">Back to Reviews</a></p>

</body>
</html>
