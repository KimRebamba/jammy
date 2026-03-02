<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
</head>
<body>

<h2>Orders</h2>

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

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Customer</th>
    <th>Payment</th>
    <th>Status</th>
    <th>Delivery Fee</th>
    <th>Date</th>
    <th>Items</th>
    <th>Actions</th>
</tr>

@foreach($orders as $order)
<tr>
    <td>{{ $order->ID }}</td>
    <td>{{ $order->Customer }}</td>
    <td>{{ $order->Payment }}</td>
    <td>{{ $order->Status }}</td>
    <td>{{ $order->Delivery }}</td>
    <td>{{ $order->Date }}</td>
    <td>
        <?php
        $itemsText = $order->Items;
        if (strlen($itemsText) > 50) {
            $itemsText = substr($itemsText, 0, 50) . '...';
        }
        ?>
        {{ $itemsText }}
    </td>
    <td>
        <a href="/admin/orders/{{ $order->ID }}">View</a> |
        <a href="/admin/orders/{{ $order->ID }}/edit">Edit</a> |
        <form action="/admin/orders/{{ $order->ID }}/delete" method="post" style="display:inline;">
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
