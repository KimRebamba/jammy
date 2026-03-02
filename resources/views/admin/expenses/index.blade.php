<!DOCTYPE html>
<html>
<head>
    <title>Expenses</title>
</head>
<body>

<h2>Expenses</h2>

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

<p><a href="/admin/expenses/create">Add Expense</a></p>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Type</th>
    <th>Amount</th>
    <th>Status</th>
    <th>Due Date</th>
    <th>Actions</th>
</tr>

@foreach($expenses as $expense)
<tr>
    <td>{{ $expense->ID }}</td>
    <td>{{ $expense->Type }}</td>
    <td>{{ $expense->Amount }}</td>
    <td>{{ $expense->Status }}</td>
    <td>{{ $expense->Due }}</td>
    <td>
        <a href="/admin/expenses/{{ $expense->ID }}">View</a> |
        <a href="/admin/expenses/{{ $expense->ID }}/edit">Edit</a> |
        <form action="/admin/expenses/{{ $expense->ID }}/delete" method="post" style="display:inline;">
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
