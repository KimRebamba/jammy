<!DOCTYPE html>
<html>
<head>
    <title>Add Position</title>
</head>
<body>

<h2>Add Position</h2>

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

<form action="/admin/positions" method="post">
    @csrf
    <p>Name: <input type="text" name="position_name" value="{{ old('position_name') }}"></p>
    <p>Monthly Rate: <input type="text" name="monthly_rate" value="{{ old('monthly_rate') }}"></p>

    <p><button type="submit">Save</button></p>
</form>

<p><a href="/admin/positions">Back to Positions</a></p>

</body>
</html>
