<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
</head>
<body>

<h2>Orders</h2>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Customer</th>
    <th>Payment</th>
    <th>Status</th>
    <th>Delivery Fee</th>
    <th>Date</th>
</tr>

@foreach($orders as $order)
<tr>
    <td>{{ $order->ID }}</td>
    <td>{{ $order->Customer }}</td>
    <td>{{ $order->Payment }}</td>
    <td>{{ $order->Status }}</td>
    <td>{{ $order->Delivery }}</td>
    <td>{{ $order->Date }}</td>
</tr>
@endforeach

</table>

<br>
<a href="/admin/dashboard">Back</a>

</body>
</html>