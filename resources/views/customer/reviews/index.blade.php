<!DOCTYPE html>
<html>
<head>
    <title>My Reviews</title>
</head>
<body>

<h2>My Reviews</h2>

@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif
@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

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
                <a href="/reviews/{{ $review->review_id }}/edit">Edit</a>
                |
                <form action="/reviews/{{ $review->review_id }}/delete" method="post" style="display:inline;">
                    @csrf
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

<p><a href="/customer/index">Back to Customer Home</a></p>

</body>
</html>
