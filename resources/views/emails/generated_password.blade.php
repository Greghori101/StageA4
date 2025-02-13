<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Details</title>
</head>
<body>
    <p>Hello {{ $user->full_name }},</p>
    <p>Your account has been created. Here are your login details:</p>
    <ul>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>
    <p>Please log in and change your password as soon as possible.</p>
    <p>Best regards,<br>Admin Team</p>
</body>
</html>
