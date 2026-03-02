<!DOCTYPE html>
<html>
<head>
    <title>Returns</title>
</head>
<body>

<h2>Returns</h2>

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
    <th>Order ID</th>
    <th>Reason</th>
    <th>Condition</th>
    <th>Status</th>
    <th>Refund</th>
    <th>Actions</th>
</tr>

@foreach($returns as $return)
<tr>
    <td>{{ $return->ID }}</td>
    <td>{{ $return->OrderID }}</td>
    <td>
        <?php
        $reason = $return->Reason;
        if (strlen($reason) > 50) {
            $reason = substr($reason, 0, 50) . '...';
        }
        ?>
        {{ $reason }}
    </td>
    <td>{{ $return->Condition }}</td>
    <td>{{ $return->Status }}</td>
    <td>{{ $return->Refund }}</td>
    <td>
        <a href="/admin/returns/{{ $return->ID }}">View</a> |
        <a href="/admin/returns/{{ $return->ID }}/edit">Edit</a> |
        <form action="/admin/returns/{{ $return->ID }}/delete" method="post" style="display:inline;">
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
