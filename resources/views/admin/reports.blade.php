<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
</head>
<body>

<h2>Business Reports Summary</h2>

<table border="1" cellpadding="10">

<tr>
    <td>Total Sales Revenue</td>
    <td>{{ $totalSales->total ?? 0 }}</td>
</tr>

<tr>
    <td>Total Paid Expenses</td>
    <td>{{ $totalExpenses }}</td>
</tr>

<tr>
    <td>Total Orders</td>
    <td>{{ $totalOrders }}</td>
</tr>

<tr>
    <td>Total Products</td>
    <td>{{ $totalProducts }}</td>
</tr>

<tr>
    <td>Total Customers</td>
    <td>{{ $totalCustomers }}</td>
</tr>

<tr>
    <td>Total Employees</td>
    <td>{{ $totalEmployees }}</td>
</tr>

<tr>
    <td>Estimated Profit</td>
    <td>{{ ($totalSales->total ?? 0) - $totalExpenses }}</td>
</tr>

</table>

<br>
<a href="/admin/dashboard">Back</a>

</body>
</html>