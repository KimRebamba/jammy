<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<body>

<h2>Register</h2>

@if(session('error'))
	<p style="color:red;">{{ session('error') }}</p>
@endif

@if ($errors->any())
	<ul style="color:red;">
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
@endif

<form method="POST" action="/register" enctype="multipart/form-data">
	@csrf

	<p>
		<label>Username:</label><br>
		<input type="text" name="username" value="{{ old('username') }}">
	</p>

	<p>
		<label>Email:</label><br>
		<input type="email" name="email" value="{{ old('email') }}">
	</p>

	<p>
		<label>Password:</label><br>
		<input type="password" name="password">
	</p>

	<p>
		<label>Confirm Password:</label><br>
		<input type="password" name="password_confirmation">
	</p>

	<p>
		<label>First Name:</label><br>
		<input type="text" name="first_name" value="{{ old('first_name') }}">
	</p>

	<p>
		<label>Last Name:</label><br>
		<input type="text" name="last_name" value="{{ old('last_name') }}">
	</p>

	<p>
		<label>Address:</label><br>
		<input type="text" name="address" value="{{ old('address') }}">
	</p>

	<p>
		<label>Phone:</label><br>
		<input type="text" name="phone_number" value="{{ old('phone_number') }}">
	</p>

	<p>
		<label>Profile Photo:</label><br>
		<input type="file" name="profile_photo">
	</p>

	<p>
		<button type="submit">Register</button>
	</p>
</form>

<p><a href="/login">Back to Login</a></p>

</body>
</html>
