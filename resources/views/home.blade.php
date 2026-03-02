<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

    <!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name', 'Jammy - Home') }}</title>
</head>
<body>
<h2>Home Page</h2>

<p>Welcome, 
    @if(!session('user'))
        guest! </p>
    @else
          {{ session('user')->username }}</p>
    @endif
    
    <br>

    @if(session('user'))
        <a href="/logout">Logout</a>
    @else
        <a href="/login">Login</a>
    @endif