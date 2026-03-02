<!DOCTYPE html>
<html>
<head>
    <title>Salaries</title>
</head>
<body>

<h2>Salaries</h2>

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

<p><a href="/admin/salaries/create">Add Salary</a></p>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Employee</th>
    <th>Pay Date</th>
    <th>Rate Used</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

@foreach($salaries as $salary)
<tr>
    <td>{{ $salary->ID }}</td>
    <td>{{ $salary->Employee }}</td>
    <td>{{ $salary->PayDate }}</td>
    <td>{{ $salary->Rate }}</td>
    <td>{{ $salary->Status }}</td>
    <td>
        <a href="/admin/salaries/{{ $salary->ID }}">View</a> |
        <a href="/admin/salaries/{{ $salary->ID }}/edit">Edit</a> |
        <form action="/admin/salaries/{{ $salary->ID }}/delete" method="post" style="display:inline;">
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
