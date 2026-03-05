<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>

<h2>Edit Profile</h2>

@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif
@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if($account)
    <p><strong>Username:</strong> {{ $account->username }}</p>
    <p><strong>Email:</strong> {{ $account->email }}</p>

    <form action="/customer/profile/update" method="post">
        @csrf
        <p>
            <label>First Name:</label>
            <input type="text" name="first_name" value="{{ old('first_name', $account->first_name) }}">
        </p>
        <p>
            <label>Last Name:</label>
            <input type="text" name="last_name" value="{{ old('last_name', $account->last_name) }}">
        </p>
        <p>
            <label>Address:</label>
            <input type="text" name="address" value="{{ old('address', $account->address) }}">
        </p>
        <p>
            <label>Phone:</label>
            <input type="text" name="phone_number" value="{{ old('phone_number', $account->phone_number) }}">
        </p>
        <p>
            <button type="submit">Save</button>
        </p>
    </form>
@endif

<p><a href="/customer/profile">Back to Profile</a></p>
<p><a href="/customer/index">Back to Customer Home</a></p>

</body>
</html>
