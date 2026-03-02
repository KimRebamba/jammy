<!DOCTYPE html>
<html>
<head>
    <title>Edit Return</title>
</head>
<body>

<h2>Edit Return Status</h2>

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

<form action="/admin/returns/{{ $return->order_return_id }}/update" method="post">
    @csrf
    <p>Status:
        <select name="return_status">
            <option value="requested" {{ old('return_status', $return->return_status) == 'requested' ? 'selected' : '' }}>Requested</option>
            <option value="approved" {{ old('return_status', $return->return_status) == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ old('return_status', $return->return_status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
            <option value="processed" {{ old('return_status', $return->return_status) == 'processed' ? 'selected' : '' }}>Processed</option>
        </select>
    </p>

    <p><button type="submit">Save Changes</button></p>
</form>

<p><a href="/admin/returns">Back to Returns</a></p>

</body>
</html>
