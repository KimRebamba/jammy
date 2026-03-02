<!DOCTYPE html>
<html>
<head>
    <title>Positions</title>
</head>
<body>

<h2>Positions</h2>

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

<p><a href="/admin/positions/create">Add Position</a></p>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Position</th>
    <th>Monthly Salary</th>
    <th>Actions</th>
</tr>

@foreach($positions as $position)
<tr>
    <td>{{ $position->ID }}</td>
    <td>{{ $position->Position }}</td>
    <td>{{ $position->Salary }}</td>
    <td>
        <a href="/admin/positions/{{ $position->ID }}">View</a> |
        <a href="/admin/positions/{{ $position->ID }}/edit">Edit</a> |
        <form action="/admin/positions/{{ $position->ID }}/delete" method="post" style="display:inline;">
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
