<!DOCTYPE html>
<html>
<head>
    <title>Reviews</title>
</head>
<body>

<h2>Reviews</h2>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Customer</th>
    <th>Product</th>
    <th>Rating</th>
    <th>Verified</th>
</tr>

@foreach($reviews as $review)
<tr>
    <td>{{ $review->ID }}</td>
    <td>{{ $review->Customer }}</td>
    <td>{{ $review->Product }}</td>
    <td>{{ $review->Rating }}</td>
    <td>{{ $review->Verified ? 'Yes' : 'No' }}</td>
</tr>
@endforeach

</table>

<br>
<a href="/admin/dashboard">Back</a>

</body>
</html>