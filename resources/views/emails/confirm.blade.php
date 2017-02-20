<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Email verification</title>
</head>

<body>
<h1>Welcome</h1>

<p>One step left, activate your account by following the link below:</p><br>
<h2><a href="{{ url('register/confirm') }}/{{$user->emailtoken}}">Confirm email</a></h2>


</body>

</html>
