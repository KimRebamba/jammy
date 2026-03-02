<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
<h2>Admin Dashboard</h2>

<p>Welcome, {{ session('user')->username }}</p>

<ul>
    <li><a href="/admin/accounts">Accounts</a></li>
    <li><a href="/admin/products">Products</a></li>
    <li><a href="/admin/categories">Categories</a></li>
    <li><a href="/admin/orders">Orders</a></li>
    <li><a href="/admin/returns">Returns</a></li>
    <li><a href="/admin/reviews">Reviews</a></li>
    <li><a href="/admin/employees">Employees</a></li>
    <li><a href="/admin/positions">Positions</a></li>
    <li><a href="/admin/expenses">Expenses</a></li>
    <li><a href="/admin/salaries">Salaries</a></li>
    <li><a href="/admin/brands">Brands</a></li>
    <li><a href="/admin/reports">Reports</a></li>
</ul>

<a href="/logout">Logout</a>

</body>
</html>