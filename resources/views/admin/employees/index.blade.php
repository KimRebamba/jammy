<!DOCTYPE html>
<html>
<head>
    <title>Employees</title>
</head>
<body>

<h2>Employees</h2>

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

<p><a href="/admin/employees/create">Add Employee</a></p>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Position</th>
    <th>Status</th>
    <th>Hire Date</th>
    <th>Actions</th>
</tr>

@foreach($employees as $employee)
<tr>
    <td>{{ $employee->ID }}</td>
    <td>{{ $employee->Name }}</td>
    <td>{{ $employee->Position }}</td>
    <td>{{ $employee->Status }}</td>
    <td>{{ $employee->Hired }}</td>
    <td>
        <a href="/admin/employees/{{ $employee->ID }}">View</a> |
        <a href="/admin/employees/{{ $employee->ID }}/edit">Edit</a> |
        <form action="/admin/employees/{{ $employee->ID }}/delete" method="post" style="display:inline;">
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
