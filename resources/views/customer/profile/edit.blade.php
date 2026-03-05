<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>

<h2>Edit Profile</h2>

@if($account)
    <p><strong>Username:</strong> {{ $account->username }}</p>
    <p><strong>Email:</strong> {{ $account->email }}</p>
    <p>(Editing will be implemented later.)</p>
@endif

<p><a href="/customer/profile">Back to Profile</a></p>
<p><a href="/customer/index">Back to Customer Home</a></p>

</body>
</html>
