<!DOCTYPE html>
<html>
<head>
    <title>Expenses</title>
</head>
<body>

<h2>Expenses</h2>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Type</th>
    <th>Amount</th>
    <th>Status</th>
    <th>Due Date</th>
</tr>

@foreach($expenses as $expense)
<tr>
    <td>{{ $expense->ID }}</td>
    <td>{{ $expense->Type }}</td>
    <td>{{ $expense->Amount }}</td>
    <td>{{ $expense->Status }}</td>
    <td>{{ $expense->Due }}</td>
</tr>
@endforeach

</table>

<br>
<a href="/admin/dashboard">Back</a>

</body>
</html>