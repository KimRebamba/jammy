<!DOCTYPE html>
<html>
<head>
    <title>Returns</title>
</head>
<body>

<h2>Returns</h2>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Order ID</th>
    <th>Reason</th>
    <th>Condition</th>
    <th>Status</th>
    <th>Refund</th>
</tr>

@foreach($returns as $r)
<tr>
    <td>{{ $r->ID }}</td>
    <td>{{ $r->OrderID }}</td>
    <td>{{ $r->Reason }}</td>
    <td>{{ $r->Condition }}</td>
    <td>{{ $r->Status }}</td>
    <td>{{ $r->Refund }}</td>
</tr>
@endforeach

</table>

<br>
<a href="/admin/dashboard">Back</a>

</body>
</html>