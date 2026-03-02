<!DOCTYPE html>
<html>
<head>
    <title>Edit Expense</title>
</head>
<body>

<h2>Edit Expense</h2>

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

<form action="/admin/expenses/{{ $expense->exp_id }}/update" method="post">
    @csrf
    <p>Type:
        <select name="expense_type">
            <option value="inventory_purchase" {{ old('expense_type', $expense->expense_type) == 'inventory_purchase' ? 'selected' : '' }}>Inventory Purchase</option>
            <option value="shipping" {{ old('expense_type', $expense->expense_type) == 'shipping' ? 'selected' : '' }}>Shipping</option>
            <option value="maintenance" {{ old('expense_type', $expense->expense_type) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            <option value="rent" {{ old('expense_type', $expense->expense_type) == 'rent' ? 'selected' : '' }}>Rent</option>
            <option value="utilities" {{ old('expense_type', $expense->expense_type) == 'utilities' ? 'selected' : '' }}>Utilities</option>
            <option value="other" {{ old('expense_type', $expense->expense_type) == 'other' ? 'selected' : '' }}>Other</option>
        </select>
    </p>
    <p>Description: <input type="text" name="description" value="{{ old('description', $expense->description) }}"></p>
    <p>Amount: <input type="text" name="amount" value="{{ old('amount', $expense->amount) }}"></p>
    <p>Status:
        <select name="status">
            <option value="pending" {{ old('status', $expense->status) == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="paid" {{ old('status', $expense->status) == 'paid' ? 'selected' : '' }}>Paid</option>
        </select>
    </p>
    <p>Due Date: <input type="text" name="due_date" value="{{ old('due_date', $expense->due_date) }}"></p>
    <p>Paid Date: <input type="text" name="paid_date" value="{{ old('paid_date', $expense->paid_date) }}"></p>

    <p><button type="submit">Save Changes</button></p>
</form>

<p><a href="/admin/expenses">Back to Expenses</a></p>

</body>
</html>
