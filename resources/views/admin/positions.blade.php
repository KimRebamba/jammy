<!DOCTYPE html>
<html>
<head>
    <title>Positions</title>
</head>
<body>

<h2>Positions</h2>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Position</th>
    <th>Monthly Salary</th>
</tr>

@foreach($positions as $position)
<tr>
    <td>{{ $position->ID }}</td>
    <td>{{ $position->Position }}</td>
    <td>{{ $position->Salary }}</td>
</tr>
@endforeach

</table>

<br>
<a href="/admin/dashboard">Back</a>

</body>
</html>