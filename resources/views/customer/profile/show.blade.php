<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
</head>
<body>

<h2>My Profile</h2>

@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif
@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

@if($account)
    <p><strong>Username:</strong> {{ $account->username }}</p>
    <p><strong>Email:</strong> {{ $account->email }}</p>
    <p><strong>Name:</strong> {{ $account->first_name }} {{ $account->last_name }}</p>
    <p><strong>Address:</strong> {{ $account->address }}</p>
    <p><strong>Phone:</strong> {{ $account->phone_number }}</p>
    @if($account->profile_photo_url)
        <p><img src="{{ asset($account->profile_photo_url) }}" alt="Profile Photo" width="120"></p>
    @endif
@endif

<p><a href="/customer/profile/edit">Edit Profile</a></p>
<p><a href="/customer/index">Back to Customer Home</a></p>

</body>
</html>
