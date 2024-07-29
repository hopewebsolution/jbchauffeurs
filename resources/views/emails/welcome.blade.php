<!DOCTYPE html>
<html>
<head>
    <title>Welcome to {{ config('app.name') }}! Verify Your Email to Get Started</title>
</head>
<body>
Dear {{ $user->name }},
<br>
Welcome to {{ config('app.name') }}!
<br>
We are excited to have you on board. To get started, please verify your email address by clicking the link below:
<br>
<a href="{{ $verificationUrl }}"><button type="button">Verify Email Address</button></a>
<br>
If the button doesn’t work, copy and paste the following URL into your web browser:
{{ $verificationUrl }}
<br>
Thank you for joining us, and we look forward to providing you with the best service possible.
<br>
<br>
<br>
Best regards,
{{ config('app.name') }}

</body>
</html>
