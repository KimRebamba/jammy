<!DOCTYPE html>
<html>
<head>
    <title>View Return</title>
</head>
<body>

<h2>Return Details</h2>

<p>ID: {{ $return->order_return_id }}</p>
<p>Order ID: {{ $return->order_id }}</p>
<p>Customer: {{ $return->username }}</p>
<p>Reason: {{ $return->reason }}</p>
<p>Condition: {{ $return->cond }}</p>
<p>Status: {{ $return->return_status }}</p>
<p>Refund Amount: {{ $return->refund_amount }}</p>
<p>Processed At: {{ $return->processed_at }}</p>

<p><a href="/admin/returns/{{ $return->order_return_id }}/edit">Edit</a></p>
<p><a href="/admin/returns">Back to Returns</a></p>

</body>
</html>
