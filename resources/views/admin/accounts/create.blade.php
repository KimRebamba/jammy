<!DOCTYPE html>
<html>
<head>
    <title>Add Account</title>
</head>
<body>

<h2>Add Account</h2>

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

<form action="/admin/accounts" method="post" enctype="multipart/form-data">
    @csrf
    <p>Username: <input type="text" name="username" value="{{ old('username') }}"></p>
    <p>Password: <input type="text" name="password"></p>
    <p>Email: <input type="text" name="email" value="{{ old('email') }}"></p>
    <p>First Name: <input type="text" name="first_name" value="{{ old('first_name') }}"></p>
    <p>Last Name: <input type="text" name="last_name" value="{{ old('last_name') }}"></p>
    <p>Address: <input type="text" name="address" value="{{ old('address') }}"></p>
    <p>Phone Number: <input type="text" name="phone_number" value="{{ old('phone_number') }}"></p>
    <p>Role:
        <select name="role">
            <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
    </p>
    <p>Profile Photo (800x800): <input type="file" name="profile_photo_url"></p>
    <p>Active: <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}></p>

    <p><button type="submit">Save</button></p>
</form>

<p><a href="/admin/accounts">Back to Accounts</a></p>

</body>
</html>
