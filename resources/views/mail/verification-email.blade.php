<!DOCTYPE html>
<html>
<head>
    <title>Email from Laravel</title>
</head>
<body>
    <h1>Welcome to Match Master</h1>
    <h3>{{ $subject }}</h3>
    <p>Congratulations {{ $name }}! You have successfully registered as a {{$role}}.</p>
    <h3>Your password is: {{ $code }}</h3>
</body>
</html>