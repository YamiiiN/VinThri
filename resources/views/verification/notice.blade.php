<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <div>
        <h2>Verify Your Email Address</h2>
        <p>A verification link has been sent to your email address. Please click the link in the email to verify your account.</p>
        <p>If you did not receive the email, please check your spam folder or <a href="{{ route('verification.send') }}">click here</a> to request another verification link.</p>
    </div>
</body>
</html>
