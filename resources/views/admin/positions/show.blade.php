<!DOCTYPE html>
<html>
<head>
    <title>View Position</title>
</head>
<body>

<h2>Position Details</h2>

<p>ID: {{ $position->position_id }}</p>
<p>Name: {{ $position->position_name }}</p>
<p>Monthly Rate: {{ $position->monthly_rate }}</p>

<p><a href="/admin/positions/{{ $position->position_id }}/edit">Edit</a></p>
<p><a href="/admin/positions">Back to Positions</a></p>

</body>
</html>
