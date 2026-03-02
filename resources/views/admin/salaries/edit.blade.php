<!DOCTYPE html>
<html>
<head>
    <title>Edit Salary</title>
</head>
<body>

<h2>Edit Salary</h2>

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

<form action="/admin/salaries/{{ $salary->salary_id }}/update" method="post">
    @csrf
    <p>Employee:
        <select name="emp_id">
            @foreach($employees as $employee)
                <option value="{{ $employee->emp_id }}" {{ old('emp_id', $salary->emp_id) == $employee->emp_id ? 'selected' : '' }}>
                    {{ $employee->last_name }}, {{ $employee->first_name }}
                </option>
            @endforeach
        </select>
    </p>
    <p>Pay Date: <input type="text" name="pay_date" value="{{ old('pay_date', $salary->pay_date) }}"></p>
    <p>Rate Used: <input type="text" name="rate_used" value="{{ old('rate_used', $salary->rate_used) }}"></p>
    <p>Status:
        <select name="status">
            <option value="pending" {{ old('status', $salary->status) == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="paid" {{ old('status', $salary->status) == 'paid' ? 'selected' : '' }}>Paid</option>
            <option value="cancelled" {{ old('status', $salary->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </p>
    <p>From Date: <input type="text" name="from_date" value="{{ old('from_date', $salary->from_date) }}"></p>
    <p>To Date: <input type="text" name="to_date" value="{{ old('to_date', $salary->to_date) }}"></p>

    <p><button type="submit">Save Changes</button></p>
</form>

<p><a href="/admin/salaries">Back to Salaries</a></p>

</body>
</html>
