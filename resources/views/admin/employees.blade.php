<!DOCTYPE html>
<html>
<head>
    <title>Employees</title>
</head>
<body>

<h2>Employees</h2>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Position</th>
    <th>Status</th>
    <th>Hire Date</th>
</tr>

@foreach($employees as $employee)
<tr>
    <td>{{ $employee->ID }}</td>
    <td>{{ $employee->Name }}</td>
    <td>{{ $employee->Position }}</td>
    <td>{{ $employee->Status }}</td>
    <td>{{ $employee->Hired }}</td>
</tr>
@endforeach

</table>

<br>
<a href="/admin/dashboard">Back</a>

</body>
</html>