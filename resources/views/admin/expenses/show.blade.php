<!DOCTYPE html>
<html>
<head>
    <title>View Expense</title>
</head>
<body>

<h2>Expense Details</h2>

<p>ID: {{ $expense->exp_id }}</p>
<p>Type: {{ $expense->expense_type }}</p>
<p>Description: {{ $expense->description }}</p>
<p>Amount: {{ $expense->amount }}</p>
<p>Status: {{ $expense->status }}</p>
<p>Due Date: {{ $expense->due_date }}</p>
<p>Paid Date: {{ $expense->paid_date }}</p>

<p><a href="/admin/expenses/{{ $expense->exp_id }}/edit">Edit</a></p>
<p><a href="/admin/expenses">Back to Expenses</a></p>

</body>
</html>
