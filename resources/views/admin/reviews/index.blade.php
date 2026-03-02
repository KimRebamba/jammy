<!DOCTYPE html>
<html>
<head>
    <title>Reviews</title>
</head>
<body>

<h2>Reviews</h2>

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

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Customer</th>
    <th>Product</th>
    <th>Rating</th>
    <th>Verified</th>
    <th>Actions</th>
</tr>

@foreach($reviews as $review)
<tr>
    <td>{{ $review->ID }}</td>
    <td>{{ $review->Customer }}</td>
    <td>{{ $review->Product }}</td>
    <td>{{ $review->Rating }}</td>
    <td>{{ $review->Verified ? 'Yes' : 'No' }}</td>
    <td>
        <a href="/admin/reviews/{{ $review->ID }}">View</a> |
        <a href="/admin/reviews/{{ $review->ID }}/edit">Edit</a> |
        <form action="/admin/reviews/{{ $review->ID }}/delete" method="post" style="display:inline;">
            @csrf
            <button type="submit">Delete</button>
        </form>
    </td>
</tr>
@endforeach

</table>

<br>
<a href="/admin/dashboard">Back</a>

</body>
</html>
