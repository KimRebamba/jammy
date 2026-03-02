<!DOCTYPE html>
<html>
<head>
    <title>View Employee</title>
</head>
<body>

<h2>Employee Details</h2>

<p>ID: {{ $employee->emp_id }}</p>
<p>First Name: {{ $employee->first_name }}</p>
<p>Last Name: {{ $employee->last_name }}</p>
<p>Email: {{ $employee->email }}</p>
<p>Phone Number: {{ $employee->phone_number }}</p>
<p>Address: {{ $employee->address }}</p>
<p>Birth Date: {{ $employee->birth_date }}</p>
<p>Gender: {{ $employee->gender }}</p>
<p>Employment Status: {{ $employee->employment_status }}</p>
<p>Hire Date: {{ $employee->hire_date }}</p>
<p>Position: {{ $employee->position_name }}</p>

<p><a href="/admin/employees/{{ $employee->emp_id }}/edit">Edit</a></p>
<p><a href="/admin/employees">Back to Employees</a></p>

</body>
</html>
