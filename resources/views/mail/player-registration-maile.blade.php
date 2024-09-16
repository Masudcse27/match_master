<!DOCTYPE html>
<html>
<head>
    <title>Email from Laravel</title>
</head>
<body>
    <h1>Welcome to Match Master</h1>
    <h3>{{ $subject }}</h3>
    <p>Congratulations {{ $player_name }}! You have successfully registered as a player. Your password is {{ $password }}. Registered bye {{ $created_by }}</p>
</body>
</html>