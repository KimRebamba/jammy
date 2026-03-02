<!DOCTYPE html>
<html>
<head>
    <title>Edit Review Verification</title>
</head>
<body>

<h2>Edit Review Verification</h2>

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

<form action="/admin/reviews/{{ $review->review_id }}/update" method="post">
    @csrf
    <p>Verified: <input type="checkbox" name="is_verified" value="1" {{ old('is_verified', $review->is_verified) ? 'checked' : '' }}></p>

    <p><button type="submit">Save Changes</button></p>
</form>

<p><a href="/admin/reviews">Back to Reviews</a></p>

</body>
</html>
