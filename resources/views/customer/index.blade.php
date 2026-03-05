<!DOCTYPE html>
<html>
<head>
    <title>Customer Home</title>
</head>
<body>
<h2>Customer Home</h2>

@if(session('user'))
    <p>Welcome, {{ session('user')->username }}</p>
@endif

<ul>
    <li><a href="/customer/profile">Profile Settings</a></li>
    <li><a href="/shop">Products</a></li>
    <li><a href="/orders">Orders</a></li>
    <li><a href="/reviews">Reviews</a></li>
    <li><a href="/cart">Cart</a></li>
</ul>

<p><a href="/home">Back to Home</a></p>
<p><a href="/logout">Logout</a></p>

</body>
</html>
