<!DOCTYPE html>
<html>
<head>
    <title>Accounts</title>
</head>
<body>

<h2>Accounts List</h2>

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

<p><a href="/admin/accounts/create">Add Account</a></p>

<table border="1" cellpadding="5">
    <tr>
        <th>Picture</th>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Active</th>
        <th>Actions</th>
    </tr>

    @foreach($accounts as $account)
    <tr>
        <td>
        @if($account->Picture)
            <img src="{{ asset($account->Picture) }}" width="80">
        @endif
        </td>
        <td>{{ $account->ID }}</td>
        <td>{{ $account->Username }}</td>
        <td>{{ $account->Email }}</td>
        <td>{{ $account->Role }}</td>
        <td>{{ $account->Active ? 'Yes' : 'No' }}</td>
        <td>
            <a href="/admin/accounts/{{ $account->ID }}">View</a> |
            <a href="/admin/accounts/{{ $account->ID }}/edit">Edit</a> |
            <form action="/admin/accounts/{{ $account->ID }}/delete" method="post" style="display:inline;">
                @csrf
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

<br>
<a href="/admin/dashboard">Back</a>

</body>
</html>
