<!DOCTYPE html>
<html>
<head>
    <title>Accounts</title>
</head>
<body>

<h2>Accounts List</h2>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Picture</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Active</th>
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
    </tr>
    @endforeach
</table>

<br>
<a href="/admin/dashboard">Back</a>

</body>
</html>