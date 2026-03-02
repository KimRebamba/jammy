<!DOCTYPE html>
<html>
<head>
    <title>View Account</title>
</head>
<body>

<h2>Account Details</h2>

@if($account->profile_photo_url)
    <p><img src="{{ asset($account->profile_photo_url) }}" width="200"></p>
@endif

<p>ID: {{ $account->user_id }}</p>
<p>Username: {{ $account->username }}</p>
<p>Email: {{ $account->email }}</p>
<p>First Name: {{ $account->first_name }}</p>
<p>Last Name: {{ $account->last_name }}</p>
<p>Address: {{ $account->address }}</p>
<p>Phone Number: {{ $account->phone_number }}</p>
<p>Role: {{ $account->role }}</p>
<p>Active: {{ $account->is_active ? 'Yes' : 'No' }}</p>

<p><a href="/admin/accounts/{{ $account->user_id }}/edit">Edit</a></p>
<p><a href="/admin/accounts">Back to Accounts</a></p>

</body>
</html>
