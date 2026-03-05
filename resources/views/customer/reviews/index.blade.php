<!DOCTYPE html>
<html>
<head>
    <title>My Reviews</title>
</head>
<body>

<h2>My Reviews</h2>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Product</th>
        <th>Rating</th>
        <th>Title</th>
        <th>Review</th>
        <th>Verified</th>
        <th>Actions</th>
    </tr>
    @foreach($reviews as $review)
        <tr>
            <td>{{ $review->product_name }}</td>
            <td>{{ $review->rating }}</td>
            <td>{{ $review->review_title }}</td>
            <td>{{ \Illuminate\Support\Str::limit($review->review_text, 50) }}</td>
            <td>{{ $review->is_verified ? 'Yes' : 'No' }}</td>
            <td>
                <a href="#">Edit</a> | <a href="#">Delete</a>
            </td>
        </tr>
    @endforeach
</table>

<p><a href="/customer/index">Back to Customer Home</a></p>

</body>
</html>
