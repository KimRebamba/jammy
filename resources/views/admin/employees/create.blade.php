<!DOCTYPE html>
<html>
<head>
    <title>Add Employee</title>
</head>
<body>

<h2>Add Employee</h2>

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

<form action="/admin/employees" method="post">
    @csrf
    <p>First Name: <input type="text" name="first_name" value="{{ old('first_name') }}"></p>
    <p>Last Name: <input type="text" name="last_name" value="{{ old('last_name') }}"></p>
    <p>Email: <input type="text" name="email" value="{{ old('email') }}"></p>
    <p>Phone Number: <input type="text" name="phone_number" value="{{ old('phone_number') }}"></p>
    <p>Address: <input type="text" name="address" value="{{ old('address') }}"></p>
    <p>Birth Date: <input type="text" name="birth_date" value="{{ old('birth_date') }}"></p>
    <p>Gender:
        <select name="gender">
            <option value="">--</option>
            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
        </select>
    </p>
    <p>Employment Status:
        <select name="employment_status">
            <option value="active" {{ old('employment_status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('employment_status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="terminated" {{ old('employment_status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
            <option value="on_leave" {{ old('employment_status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
        </select>
    </p>
    <p>Hire Date: <input type="text" name="hire_date" value="{{ old('hire_date') }}"></p>
    <p>Position:
        <select name="current_position_id">
            <option value="">-- none --</option>
            @foreach($positions as $position)
                <option value="{{ $position->position_id }}" {{ old('current_position_id') == $position->position_id ? 'selected' : '' }}>{{ $position->position_name }}</option>
            @endforeach
        </select>
    </p>

    <p><button type="submit">Save</button></p>
</form>

<p><a href="/admin/employees">Back to Employees</a></p>

</body>
</html>
