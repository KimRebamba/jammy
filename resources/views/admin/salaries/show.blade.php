<!DOCTYPE html>
<html>
<head>
    <title>View Salary</title>
</head>
<body>

<h2>Salary Details</h2>

<p>ID: {{ $salary->salary_id }}</p>
<p>Employee: {{ $salary->employee_name }}</p>
<p>Pay Date: {{ $salary->pay_date }}</p>
<p>Rate Used: {{ $salary->rate_used }}</p>
<p>Status: {{ $salary->status }}</p>
<p>From Date: {{ $salary->from_date }}</p>
<p>To Date: {{ $salary->to_date }}</p>

<p><a href="/admin/salaries/{{ $salary->salary_id }}/edit">Edit</a></p>
<p><a href="/admin/salaries">Back to Salaries</a></p>

</body>
</html>
